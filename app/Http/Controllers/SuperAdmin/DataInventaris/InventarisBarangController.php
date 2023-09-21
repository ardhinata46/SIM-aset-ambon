<?php

namespace App\Http\Controllers\superAdmin\DataInventaris;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\PenghapusanBarang;
use App\Models\PerawatanBarang;
use App\Models\Profil;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InventarisBarangController extends Controller
{
    public function index()
    {
        $title = 'Inventaris Barang | GPIBI AA';
        $barang = Barang::all();
        $ruangan = Ruangan::all();

        $itemBarang = ItemBarang::with('penghapusanBarang')
            ->select('item_barangs.*', 'ruangans.nama_ruangan')
            ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->latest()
            ->get();

        return view('sa.content.inventaris-barang.list', compact('title', 'itemBarang', 'barang', 'ruangan'));
    }



    public function filterInventarisBarangPDF(Request $request)
    {
        $title = 'Inventaris Barang | GPIBI AA';

        $id_barang = $request->input('id_barang');
        $merk = $request->input('merk');
        $kondisi = $request->input('kondisi');
        $status = $request->input('status');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $barang = Barang::get();

        $itemBarang = ItemBarang::with('penghapusanBarang')
            ->select('item_barangs.*', 'ruangans.nama_ruangan')
            ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->orderBy('item_barangs.status', 'desc')
            ->latest();

        if ($id_barang) {
            $itemBarang->where('item_barangs.id_barang', $id_barang);
        }
        if ($kondisi) {
            $itemBarang->where('item_barangs.kondisi', $kondisi);
        }
        if ($status !== null) {
            $itemBarang->where('item_barangs.status', $status);
        }
        if ($merk) {
            $itemBarang->where('item_barangs.merk', 'LIKE', '%' . $merk . '%');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $itemBarang->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                $query->whereDate('tanggal', '>=', $tanggal_awal)
                    ->whereDate('tanggal', '<=', $tanggal_akhir);
            });
        }

        $itemBarang = $itemBarang->latest()->get();

        return view('sa.content.inventaris-barang.list', compact('title', 'itemBarang', 'barang'));
    }

    public function perawatan($id_item_barang)
    {
        $title = 'Perawatan Inventaris Barang | GPIBI AA';

        $itemBarang = ItemBarang::findOrFail($id_item_barang);
        $nextKodePerawatanBarang = PerawatanBarang::generateKodePerawatanBarang();

        return view('sa.content.inventaris-barang.perawatan', compact('title', 'itemBarang', 'nextKodePerawatanBarang'));
    }

    public function storePerawatan(Request $request, $id_item_barang)
    {
        $request->validate([
            'kode_perawatan_barang' => 'required',
            'tanggal_perawatan' => 'required',
            'id_item_barang' => 'required',
            'deskripsi' => 'required',
            'kondisi_sesudah' => 'required',
            'biaya' => 'nullable',
            'keterangan' => 'nullable',
            'nota' => 'nullable|image|max:2048',
        ], [
            'kondisi.required' => 'Kondisi harus dipilih',
            'id_item_barang.required' => 'Barang harus dipilih',
        ]);

        $itemBarang = ItemBarang::findOrFail($id_item_barang); // Mengambil data barang berdasarkan ID yang dipilih

        $idItemBarang = $itemBarang->id_item_barang;
        $kondisiSebelum = $itemBarang->kondisi; // Mengambil kondisi barang sebelum perawatan
        try {
            DB::beginTransaction();
            $nextKodePerawatanBarang = PerawatanBarang::generateKodePerawatanBarang();

            $perawatanBarang = new PerawatanBarang();
            $perawatanBarang->kode_perawatan_barang = $nextKodePerawatanBarang;
            $perawatanBarang->id_item_barang = $idItemBarang;
            $perawatanBarang->tanggal_perawatan = $request->tanggal_perawatan;
            $perawatanBarang->kondisi_sebelum = $kondisiSebelum;
            $perawatanBarang->kondisi_sesudah = $request->kondisi_sesudah;
            $perawatanBarang->deskripsi = $request->deskripsi;
            $perawatanBarang->biaya = str_replace('.', '', $request->biaya);
            $perawatanBarang->keterangan = $request->keterangan;
            $perawatanBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            // Cek apakah ada file foto yang diunggah
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $perawatanBarang->nota = 'nota/' . $notaName;
            }

            $perawatanBarang->save();
            $barang = ItemBarang::findOrFail($idItemBarang);

            $barang->kondisi = $perawatanBarang->kondisi_sesudah;
            $barang->save();

            DB::commit();
            return redirect(route('superadmin.inventaris_barang.index'))->with('success', 'Perawatan barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.inventaris_barang.index'))->with('error', 'Perawatan barang gagal ditambah!');
        }
    }

    public function nonaktif($id_item_barang)
    {
        $title = 'Penghapusan Aset Barang ';

        $itemBarang = ItemBarang::findOrFail($id_item_barang);
        $nextKodePenghapusanBarang = PenghapusanBarang::generateKodePenghapusanBarang();

        return view('sa.content.inventaris-barang.penghapusan', compact('title', 'itemBarang', 'nextKodePenghapusanBarang'));
    }

    public function storePenghapusan(Request $request, $id_item_barang)
    {

        $itemBarang = ItemBarang::findOrFail($id_item_barang);

        $request->validate([
            'tanggal' => 'required',
            'id_item_barang' => 'required',
            'tindakan' => 'required',
            'alasan' => 'required',
            'keterangan' => 'nullable',
        ], [
            'id_item_barang.required' => 'Bangunan harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
            'alasan.required' => 'Alasan harus dipilih',
        ]);

        $nextKodePenghapusanBarang = PenghapusanBarang::generateKodePenghapusanBarang();

        try {
            DB::beginTransaction();

            // Simpan data ke database dengan menggunakan $nextKodePenghapusanBarang
            $penghapusanBarang = new PenghapusanBarang();
            $penghapusanBarang->id_item_barang  = $itemBarang->id_item_barang;
            $penghapusanBarang->kode_penghapusan_barang = $nextKodePenghapusanBarang;
            $penghapusanBarang->tanggal = $request->tanggal;
            $penghapusanBarang->tindakan = $request->tindakan;
            $penghapusanBarang->alasan = $request->alasan;
            $penghapusanBarang->keterangan = $request->keterangan;
            $penghapusanBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;


            $penghapusanBarang->save();

            $barang = ItemBarang::findOrFail($penghapusanBarang->id_item_barang);
            $barang->status = $penghapusanBarang->status ?? 0; // Berikan nilai default jika $penghapusanBarang->status null

            $barang->save();

            DB::commit();
            return redirect(route('superadmin.inventaris_barang.index'))->with('success', 'Penghapusan Barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.inventaris_barang.index'))->with('error', 'Penghapusan Barang gagal ditambah!');
        }
    }

    public function detail($id_item_barang)
    {
        $title = "Detail Item Barang ";

        $detail = ItemBarang::with('penghapusanBarang')
            ->select('item_barangs.*', 'ruangans.nama_ruangan', 'barangs.kode_barang as kode_barang', 'barangs.nama_barang as nama_barang', 'bangunans.nama_bangunan')
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->leftJoin('ruangans as r', 'r.id_ruangan', '=', 'ruangans.id_ruangan')
            ->leftJoin('bangunans', 'bangunans.id_bangunan', '=', 'r.id_bangunan')
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->first();

        return view('sa.content.inventaris-barang.detail', compact('title', 'detail'));
    }
}
