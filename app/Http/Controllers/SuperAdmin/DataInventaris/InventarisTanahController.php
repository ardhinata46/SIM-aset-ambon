<?php

namespace App\Http\Controllers\SuperAdmin\DataInventaris;

use App\Http\Controllers\Controller;
use App\Models\PenghapusanTanah;
use App\Models\Tanah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventarisTanahController extends Controller
{
    public function index()
    {
        $title = 'Inventaris Tanah ';
        $tanah = Tanah::with('penghapusanTanah')
            ->orderBy('status', 'desc')
            ->get();

        return view('sa.content.inventaris-tanah.list', compact('title', 'tanah'));
    }

    public function filterInventarisTanah(Request $request)
    {
        $title = 'Inventaris Tanah ';


        $status = $request->input('status');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $tanah = Tanah::with('penghapusanTanah')
            ->orderBy('status', 'desc')
            ->latest();


        if ($status !== null) {
            $tanah->where('tanahs.status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $tanah->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                $query->whereDate('tanggal_pengadaan', '>=', $tanggal_awal)
                    ->whereDate('tanggal_pengadaan', '<=', $tanggal_akhir);
            });
        }

        $tanah = $tanah->latest()->get();

        return view('sa.content.inventaris-tanah.list', compact('title', 'tanah'));
    }

    public function detail($id_tanah)
    {
        $title = 'Detail Aset Tanah ';

        $tanah = Tanah::with('penghapusanTanah')
            ->findOrFail($id_tanah);

        return view('sa.content.inventaris-tanah.detail', compact('title', 'tanah'));
    }

    public function nonaktif($id_tanah)
    {
        $title = "Hapusan Aset Tanah | Invnetaris GPIBI AA";
        $tanah = Tanah::findOrFail($id_tanah);

        $nextKodePenghapusanTanah = PenghapusanTanah::generateKodePenghapusanTanah();

        return view('sa.content.inventaris-tanah.nonaktif', compact('title', 'tanah', 'nextKodePenghapusanTanah'));
    }

    public function storePenghapusan(Request $request, $id_tanah)
    {

        $request->validate([
            'tanggal' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'nullable',
        ], [
            'tindakan.required' => 'Tindakan harus dipilih',
        ]);

        $datatanah = Tanah::findOrFail($id_tanah);
        $idTanah = $datatanah->id_tanah;
        $nextKodePenghapusanTanah = PenghapusanTanah::generateKodePenghapusanTanah();

        try {
            DB::beginTransaction();
            // Simpan data ke database dengan menggunakan $nextKodePenghapusanTanah
            $penghapusanTanah = new PenghapusanTanah();
            $penghapusanTanah->id_tanah  = $idTanah;
            $penghapusanTanah->kode_penghapusan_tanah = $nextKodePenghapusanTanah;
            $penghapusanTanah->tanggal = $request->tanggal;
            $penghapusanTanah->tindakan = $request->tindakan;
            $penghapusanTanah->keterangan = $request->keterangan;
            $penghapusanTanah->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            $penghapusanTanah->save();

            $tanah = Tanah::findOrFail($penghapusanTanah->id_tanah);
            $tanah->status = $penghapusanTanah->status ?? 0; // Berikan nilai default jika $penghapusanTanah->status null

            $tanah->save();

            DB::commit();

            return redirect(route('superadmin.inventaris_tanah.index'))->with('success', 'Penghapusan tanah berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.inventaris_tanah.index'))->with('error', 'Penghapusan tanah gagal ditambah!');
        }
    }
}
