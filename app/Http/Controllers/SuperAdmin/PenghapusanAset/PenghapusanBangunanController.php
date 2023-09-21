<?php

namespace App\Http\Controllers\SuperAdmin\PenghapusanAset;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\PenghapusanBangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenghapusanBangunanController extends Controller
{
    public function index()
    {
        $title = 'Penghapusan Aset Bangunan';
        $penghapusanBangunan = PenghapusanBangunan::select("penghapusan_bangunans.*", 'bangunans.nama_bangunan as bangunan')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'penghapusan_bangunans.id_bangunan')
            ->latest()->get();

        return view('sa.content.penghapusan-bangunan.list', compact('title', 'penghapusanBangunan'));
    }

    public function add()
    {
        $title = 'Penghapusan Aset Bangunan';
        $bangunan = Bangunan::where('status', 1)->get();
        $nextKodePenghapusanBangunan = PenghapusanBangunan::generateKodePenghapusanBangunan();



        return view('sa.content.penghapusan-bangunan.add', compact('title', 'bangunan', 'nextKodePenghapusanBangunan'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'tanggal' => 'required',
            'id_bangunan' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'nullable',
            'harga' => 'nullable',
        ], [
            'id_bangunan.required' => 'bangunan harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
        ]);

        $nextKodePenghapusanBangunan = PenghapusanBangunan::generateKodePenghapusanBangunan();
        try {
            DB::beginTransaction();
            $penghapusanBangunan = new PenghapusanBangunan();
            $penghapusanBangunan->id_bangunan  = $request->id_bangunan;
            $penghapusanBangunan->kode_penghapusan_bangunan = $nextKodePenghapusanBangunan;
            $penghapusanBangunan->tanggal = $request->tanggal;
            $penghapusanBangunan->tindakan = $request->tindakan;
            $penghapusanBangunan->keterangan = $request->keterangan;
            $penghapusanBangunan->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            if ($request->tindakan !== 'jual') {
                $penghapusanBangunan->harga = null;
            } else {
                $penghapusanBangunan->harga = $request->harga;
            }

            $penghapusanBangunan->save();

            $bangunan = Bangunan::findOrFail($penghapusanBangunan->id_bangunan);
            $bangunan->status = $penghapusanBangunan->status ?? 0;
            $bangunan->save();

            DB::commit();
            return redirect(route('superadmin.penghapusan_bangunan.index'))->with('success', 'Penghapusan bangunan berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.penghapusan_bangunan.index'))->with('error', 'Penghapusan bangunan gagal ditambah!');
        }
    }

    public function edit($id_pengahapusan_bangunan)
    {
        $title = 'Ubah Penghapusan Aset Bangunan';

        $penghapusanBangunan = PenghapusanBangunan::findOrFail($id_pengahapusan_bangunan);

        $bangunan = Bangunan::whereIn('status', [1])
            ->orWhere(function ($query) use ($penghapusanBangunan) {
                $query->whereIn('status', [0])
                    ->whereIn('id_bangunan', [$penghapusanBangunan->id_bangunan]);
            })
            ->get();

        return view('sa.content.penghapusan-bangunan.edit', compact('title', 'bangunan', 'penghapusanBangunan'));
    }



    public function update(Request $request, $id_pengahapusan_bangunan)
    {
        $request->validate([
            'tanggal' => 'required',
            'id_bangunan' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'nullable',
        ], [
            'id_bangunan.required' => 'Tanah harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
        ]);


        try {
            DB::beginTransaction();
            $penghapusanBangunan = PenghapusanBangunan::findOrFail($id_pengahapusan_bangunan);
            $created = $penghapusanBangunan->created_by;
            $bangunanSebelumnya = $penghapusanBangunan->id_bangunan;
            $kembalikanStatus = 1;
            $bangunan = Bangunan::findOrFail($request->id_bangunan);

            // Memperbarui data penghapusan tanah
            $penghapusanBangunan->tanggal = $request->tanggal;
            $penghapusanBangunan->id_bangunan = $request->id_bangunan;
            $penghapusanBangunan->tindakan = $request->tindakan;
            $penghapusanBangunan->keterangan = $request->keterangan;
            $penghapusanBangunan->created_by = $created;
            $penghapusanBangunan->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

            $penghapusanBangunan->save();

            if ($request->id_bangunan == $penghapusanBangunan->bangunanSebelumnya) {
                $bangunan->status = $penghapusanBangunan->status_sesudah;
            } else {
                $bangunan->status = $request->status_sesudah;

                $bangunanSebelumnya = Bangunan::findOrFail($bangunanSebelumnya);
                $bangunanSebelumnya->status = $kembalikanStatus;
                $bangunanSebelumnya->save();
            }

            DB::commit();
            return redirect(route('superadmin.penghapusan_bangunan.index'))->with('success', 'Penghapusan bangunan berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.penghapusan_bangunan.index'))->with('error', 'Penghapusan bangunan gagal diubah!');
        }
    }

    public function delete($id_pengahapusan_bangunan)
    {
        try {
            DB::beginTransaction();
            $penghapusanBangunan = PenghapusanBangunan::findOrFail($id_pengahapusan_bangunan);
            $bangunan = Bangunan::findOrFail($penghapusanBangunan->id_bangunan);

            $penghapusanBangunan->delete();

            // Mengupdate status bangunan menjadi 1
            $bangunan->status = 1;
            $bangunan->save();

            DB::commit();
            return redirect(route('superadmin.penghapusan_bangunan.index'))->with('success', 'Penghapusan bangunan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.penghapusan_bangunan.index'))->with('error', 'Penghapusan bangunan gagal dihapus!');
        }
    }
}

//dd($e->getMessage());