<?php

namespace App\Http\Controllers\SuperAdmin\DataInventaris;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\PenghapusanBangunan;
use App\Models\PerawatanBangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InventarisBangunanController extends Controller
{
    public function index()
    {
        $title = 'Inventaris Bangunan ';

        $bangunan = Bangunan::with('penghapusanBangunan')
            ->select('bangunans.*', 'tanahs.nama_tanah as nama')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
            ->orderBy('bangunans.status', 'desc')
            ->latest()
            ->get();

        return view('sa.content.inventaris-bangunan.list', compact('title', 'bangunan'));
    }


    public function filterInventarisBangunan(Request $request)
    {
        $title = 'Inventaris Bangunan ';

        $kondisi = $request->input('kondisi');
        $status = $request->input('status');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $bangunan = Bangunan::with('penghapusanBangunan')
            ->orderBy('bangunans.status', 'desc')
            ->latest();


        if ($kondisi) {
            $bangunan->where('bangunans.kondisi', $kondisi);
        }
        if ($status !== null) {
            $bangunan->where('bangunans.status', $status);
        }


        if ($tanggal_awal && $tanggal_akhir) {
            $bangunan->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                $query->whereDate('tanggal', '>=', $tanggal_awal)
                    ->whereDate('tanggal', '<=', $tanggal_akhir);
            });
        }

        $bangunan = $bangunan->latest()->get();

        return view('sa.content.inventaris-bangunan.list', compact('title', 'bangunan'));
    }

    public function perawatan($id_bangunan)
    {
        $title = 'Perawatan Inventaris Bangunan ';

        $bangunan = Bangunan::findOrFail($id_bangunan);
        $nextKodePerawatanBangunan = PerawatanBangunan::generateKodePerawatanBangunan();

        return view('sa.content.inventaris-bangunan.perawatan', compact('title', 'bangunan', 'nextKodePerawatanBangunan'));
    }

    public function storePerawatan(Request $request, $id_bangunan)
    {


        $request->validate([
            'kode_perawatan_bangunan' => 'required',
            'tanggal_perawatan' => 'required',
            'id_bangunan' => 'required',
            'deskripsi' => 'required',
            'kondisi_sesudah' => 'required',
            'biaya' => 'nullable',
            'keterangan' => 'nullable',
            'nota' => 'nullable|image',
        ], [
            'kondisi_sesudah.required' => 'Kondisi Sesudah harus dipilih',
            'id_bangunan.required' => 'Bangunan harus dipilih',
        ]);


        $bangunan = Bangunan::findOrFail($id_bangunan); // Mengambil data bangunan berdasarkan ID yang dipilih

        $idBangunan = $bangunan->id_bangunan;


        $kondisiSebelum = $bangunan->kondisi; // Mengambil kondisi bangunan sebelum perawatan

        try {
            DB::beginTransaction();

            $nextKodePerawatanBangunan = PerawatanBangunan::generateKodePerawatanBangunan();

            $perawatanBangunan = new PerawatanBangunan();
            $perawatanBangunan->kode_perawatan_bangunan = $nextKodePerawatanBangunan;
            $perawatanBangunan->id_bangunan = $idBangunan;
            $perawatanBangunan->tanggal_perawatan = $request->tanggal_perawatan;
            $perawatanBangunan->kondisi_sebelum = $kondisiSebelum;
            $perawatanBangunan->kondisi_sesudah = $request->kondisi_sesudah;
            $perawatanBangunan->deskripsi = $request->deskripsi;
            $perawatanBangunan->biaya = str_replace('.', '', $request->biaya);
            $perawatanBangunan->keterangan = $request->keterangan;
            $perawatanBangunan->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            // Cek apakah ada file foto yang diunggah
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $perawatanBangunan->nota = 'nota/' . $notaName;
            }


            $perawatanBangunan->save();

            $bangunan = Bangunan::findOrFail($perawatanBangunan->id_bangunan);
            $bangunan->kondisi = $perawatanBangunan->kondisi_sesudah;

            $bangunan->save();

            DB::commit();
            return redirect(route('superadmin.inventaris_bangunan.index'))->with('success', 'Perawatan bangunan berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.inventaris_bangunan.index'))->with('error', 'Perawatan bangunan gagal ditambah!');
        }
    }

    public function detail($id_bangunan)
    {
        $title = 'Detail Aset Bangunan | Inventaris GPIBI AA';

        $bangunan = Bangunan::with('penghapusanBangunan')
            ->select('bangunans.*', 'tanahs.nama_tanah as nama')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
            ->findOrFail($id_bangunan);

        return view('sa.content.inventaris-bangunan.detail', compact('title', 'bangunan'));
    }

    public function nonaktif($id_bangunan)
    {
        $title = 'Penghapusan Aset Bangunan | Inventaris GPIBI AA';

        $bangunan = Bangunan::findOrFail($id_bangunan);
        $nextKodePenghapusanBangunan = PenghapusanBangunan::generateKodePenghapusanBangunan();

        return view('sa.content.inventaris-bangunan.penghapusan', compact('title', 'bangunan', 'nextKodePenghapusanBangunan'));
    }

    public function storePenghapusan(Request $request, $id_bangunan)
    {
        $request->validate([
            'tanggal' => 'required',
            'id_bangunan' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'nullable',
        ], [
            'id_bangunan.required' => 'bangunan harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
        ]);

        $bangunan = Bangunan::findOrFail($id_bangunan);

        $idBangunan = $bangunan->id_bangunan;

        $nextKodePenghapusanBangunan = PenghapusanBangunan::generateKodePenghapusanBangunan();
        try {
            DB::beginTransaction();
            // Simpan data ke database dengan menggunakan $nextKodePenghapusanBangunan
            $penghapusanBangunan = new PenghapusanBangunan();
            $penghapusanBangunan->id_bangunan  = $idBangunan;
            $penghapusanBangunan->kode_penghapusan_bangunan = $nextKodePenghapusanBangunan;
            $penghapusanBangunan->tanggal = $request->tanggal;
            $penghapusanBangunan->tindakan = $request->tindakan;
            $penghapusanBangunan->keterangan = $request->keterangan;
            $penghapusanBangunan->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            $penghapusanBangunan->save();

            $bangunan = Bangunan::findOrFail($penghapusanBangunan->id_bangunan);
            $bangunan->status = $penghapusanBangunan->status ?? 0; // Berikan nilai default jika $penghapusanBangunan->status null  
            $bangunan->save();

            DB::commit();
            return redirect(route('superadmin.inventaris_bangunan.index'))->with('success', 'Penghapusan bangunan berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.inventaris_bangunan.index'))->with('error', 'Penghapusan bangunan gagal ditambah!');
        }
    }
}
//dd($e->getMessage());