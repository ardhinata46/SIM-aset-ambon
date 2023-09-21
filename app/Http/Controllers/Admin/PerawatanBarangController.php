<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\PerawatanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;

class PerawatanBarangController extends Controller
{

    public function index()
    {
        $title = 'Data Perawatan Aset Barang';

        $perawatanBarang = PerawatanBarang::select("perawatan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'perawatan_barangs.id_item_barang')
            ->latest()->get();

        return view('admin.content.perawatan-barang.list', compact('title', 'perawatanBarang'));
    }

    public function add()
    {
        $barang = ItemBarang::where('status', 1)->get();
        $title = 'Tambah Perawatan Barang';
        $nextKodePerawatanBarang = PerawatanBarang::generateKodePerawatanBarang();

        return view('admin.content.perawatan-barang.add', compact('title', 'nextKodePerawatanBarang', 'barang'));
    }

    public function store(Request $request)
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

        $barang = ItemBarang::findOrFail($request->id_item_barang); // Mengambil data barang berdasarkan ID yang dipilih

        $kondisiSebelum = $barang->kondisi; // Mengambil kondisi barang sebelum perawatan
        try {
            DB::beginTransaction();
            $nextKodePerawatanBarang = PerawatanBarang::generateKodePerawatanBarang();

            $perawatanBarang = new PerawatanBarang();
            $perawatanBarang->kode_perawatan_barang = $nextKodePerawatanBarang;
            $perawatanBarang->id_item_barang = $request->id_item_barang;
            $perawatanBarang->tanggal_perawatan = $request->tanggal_perawatan;
            $perawatanBarang->kondisi_sebelum = $kondisiSebelum;
            $perawatanBarang->kondisi_sesudah = $request->kondisi_sesudah;
            $perawatanBarang->deskripsi = $request->deskripsi;
            $perawatanBarang->biaya = str_replace('.', '', $request->biaya);
            $perawatanBarang->keterangan = $request->keterangan;
            $perawatanBarang->created_by = Auth::guard('admin')->user()->id_pengguna;

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
            $barang = ItemBarang::findOrFail($perawatanBarang->id_item_barang);
            $barang->kondisi = $perawatanBarang->kondisi_sesudah;
            $barang->save();

            DB::commit();
            return redirect(route('admin.perawatan_barang.index'))->with('success', 'Perawatan barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('admin.perawatan_barang.index'))->with('error', 'Perawatan barang gagal ditambah!');
        }
    }

    public function detail($id_perawatan_barang)
    {
        $title = 'Detail Perawatan Aset Barang';

        $detail = PerawatanBarang::select("perawatan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'perawatan_barangs.id_item_barang')
            ->where('perawatan_barangs.id_perawatan_barang', $id_perawatan_barang)
            ->first();

        return view('admin.content.perawatan-barang.detail', compact('title', 'detail'));
    }

    public function edit($id_perawatan_barang)
    {
        $title = 'Ubah Perawatan Barang';
        $barang = ItemBarang::where('status', 1)->get();
        $perawatanBarang = PerawatanBarang::findOrFail($id_perawatan_barang);

        return view('admin.content.perawatan-barang.edit', compact('title', 'barang', 'perawatanBarang'));
    }

    public function update(Request $request, $id_perawatan_barang)
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

        try {
            DB::beginTransaction();

            $barang = ItemBarang::findOrFail($request->id_item_barang); // Mengambil data barang berdasarkan ID yang dipilih

            $kondisiSebelum = $barang->kondisi; // Mengambil kondisi barang sebelum perawatan

            $perawatanBarang = PerawatanBarang::findOrFail($id_perawatan_barang);
            $barangSebelumnya = $perawatanBarang->id_item_barang;
            $kembalikanKondisi = $perawatanBarang->kondisi_sebelum;

            $perawatanBarang->kode_perawatan_barang = $request->kode_perawatan_barang;
            $perawatanBarang->id_item_barang = $request->id_item_barang;
            $perawatanBarang->tanggal_perawatan = $request->tanggal_perawatan;
            $perawatanBarang->kondisi_sebelum = $kondisiSebelum;
            $perawatanBarang->kondisi_sesudah = $request->kondisi_sesudah;
            $perawatanBarang->deskripsi = $request->deskripsi;
            $perawatanBarang->biaya = str_replace('.', '', $request->biaya);
            $perawatanBarang->keterangan = $request->keterangan;
            $perawatanBarang->created_by = Auth::guard('admin')->user()->id_pengguna;

            // Upload file nota
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $perawatanBarang->nota = 'nota/' . $notaName;
            } else {
                // Gunakan nota lama jika tidak ada nota baru yang diunggah
                $perawatanBarang->nota = $perawatanBarang->nota;
            }

            $perawatanBarang->save();


            if ($request->id_item_barang == $perawatanBarang->barangSebelumnya) {
                $barang->kondisi = $perawatanBarang->kondisi_sesudah;
            } else {
                $barang->kondisi = $request->kondisi_sesudah;

                $barangSebelumnya = ItemBarang::findOrFail($barangSebelumnya); // Mengambil data barang sebelumnya
                $barangSebelumnya->kondisi = $kembalikanKondisi;
                $barangSebelumnya->save();
            }

            $barang->save();

            DB::commit();
            return redirect(route('admin.perawatan_barang.index'))->with('success', 'Perawatan barang berhasil diupdate!');
        } catch (\Exception $e) {

            return redirect(route('admin.perawatan_barang.index'))->with('error', 'Perawatan barang gagal diupdate!');
        }
    }
}
