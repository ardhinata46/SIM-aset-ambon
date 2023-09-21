<?php

namespace App\Http\Controllers\SuperAdmin\PenghapusanAset;

use App\Http\Controllers\Controller;
use App\Models\PengadaanTanah;
use App\Models\PenghapusanTanah;
use App\Models\Tanah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenghapusanTanahController extends Controller
{
    public function index()
    {
        $title = 'Penghapusan Aset Tanah';
        $penghapusanTanah = PenghapusanTanah::select("penghapusan_tanahs.*", 'tanahs.nama_tanah as tanah')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'penghapusan_tanahs.id_tanah')
            ->latest()->get();

        return view('sa.content.penghapusan-tanah.list', compact('title', 'penghapusanTanah'));
    }

    public function add()
    {
        $title = 'Penghapusan Aset Tanah';
        $tanah = Tanah::where('status', 1)->get();
        $nextKodePenghapusanTanah = PenghapusanTanah::generateKodePenghapusanTanah();


        return view('sa.content.penghapusan-tanah.add', compact('title', 'tanah', 'nextKodePenghapusanTanah'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'tanggal' => 'required',
            'id_tanah' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'nullable',
            'harga' => 'nullable',
        ], [
            'id_tanah.required' => 'Tanah harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
        ]);

        $nextKodePenghapusanTanah = PenghapusanTanah::generateKodePenghapusanTanah();

        try {
            DB::beginTransaction();

            $penghapusanTanah = new PenghapusanTanah();

            $penghapusanTanah->id_tanah  = $request->id_tanah;
            $penghapusanTanah->kode_penghapusan_tanah = $nextKodePenghapusanTanah;
            $penghapusanTanah->tanggal = $request->tanggal;
            $penghapusanTanah->tindakan = $request->tindakan;
            $penghapusanTanah->keterangan = $request->keterangan;
            $penghapusanTanah->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            $penghapusanTanah->id_tanah  = $request->id_tanah;
            $penghapusanTanah->kode_penghapusan_tanah = $nextKodePenghapusanTanah;
            $penghapusanTanah->tanggal = $request->tanggal;
            $penghapusanTanah->tindakan = $request->tindakan;
            $penghapusanTanah->keterangan = $request->keterangan;
            $penghapusanTanah->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            if ($request->tindakan !== 'jual') {
                $penghapusanTanah->harga = null;
            } else {
                $penghapusanTanah->harga = $request->harga;
            }


            $penghapusanTanah->save();

            $tanah = Tanah::findOrFail($penghapusanTanah->id_tanah);
            $tanah->status = $penghapusanTanah->status ?? 0;
            $tanah->save();

            DB::commit();

            return redirect(route('superadmin.penghapusan_tanah.index'))->with('success', 'Penghapusan tanah berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.penghapusan_tanah.index'))->with('error', 'Penghapusan tanah gagal ditambah!');
        }
    }

    public function delete($id_penghapusan_tanah)
    {
        try {
            DB::beginTransaction();
            $penghapusanTanah = PenghapusanTanah::findOrFail($id_penghapusan_tanah);
            $tanah = Tanah::findOrFail($penghapusanTanah->id_tanah);

            $penghapusanTanah->delete();

            // Mengupdate status tanah menjadi 1
            $tanah->status = 1;
            $tanah->save();

            DB::commit();
            return redirect(route('superadmin.penghapusan_tanah.index'))->with('success', 'Penghapusan tanah berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.penghapusan_tanah.index'))->with('error', 'Penghapusan tanah gagal dihapus!');
        }
    }


    public function edit($id_penghapusan_tanah)
    {
        $title = 'Ubah Penghapusan Aset Tanah';

        $penghapusanTanah = PenghapusanTanah::findOrFail($id_penghapusan_tanah);

        $tanah = Tanah::whereIn('status', [1]) // Memanggil tanah dengan status 1
            ->orWhere(function ($query) use ($penghapusanTanah) {
                $query->whereIn('status', [0])
                    ->whereIn('id_tanah', [$penghapusanTanah->id_tanah]);
            })
            ->get();

        return view('sa.content.penghapusan-tanah.edit', compact('title', 'tanah', 'penghapusanTanah'));
    }

    public function update(Request $request, $id_penghapusan_tanah)
    {
        $request->validate([
            'tanggal' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'nullable',
            'harga' => 'nullable',
            'id_tanah' => 'required',
        ], [
            'id_tanah.required' => 'Tanah harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
        ]);

        try {
            DB::beginTransaction();

            $tanah = Tanah::findOrFail($request->id_tanah);

            $penghapusanTanah = PenghapusanTanah::findOrFail($id_penghapusan_tanah);
            $tanahSebelumnya = $penghapusanTanah->id_tanah;
            $kembalikanStatus = 1;

            $nextKodePenghapusanTanah = PenghapusanTanah::generateKodePenghapusanTanah();

            $penghapusanTanah->id_tanah = $request->id_tanah;
            $penghapusanTanah->kode_penghapusan_tanah = $nextKodePenghapusanTanah;
            $penghapusanTanah->tanggal = $request->tanggal;
            $penghapusanTanah->tindakan = $request->tindakan;
            $penghapusanTanah->keterangan = $request->keterangan;
            $penghapusanTanah->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            if ($request->tindakan !== 'jual') {
                $penghapusanTanah->harga = null;
            } else {
                $penghapusanTanah->harga = $request->harga;
            }

            $penghapusanTanah->save();

            if ($request->id_tanah == $penghapusanTanah->tanahSebelumnya) {
                $tanah->status = $penghapusanTanah->status_sesudah;
            } else {
                $tanah->status = $request->status_sesudah;

                $tanahSebelumnya = tanah::findOrFail($tanahSebelumnya);
                $tanahSebelumnya->status = $kembalikanStatus;
                $tanahSebelumnya->save();
            }

            DB::commit();
            return redirect(route('superadmin.penghapusan_tanah.index'))->with('success', 'Penghapusan tanah berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.penghapusan_tanah.index'))->with('error', 'Penghapusan tanah gagal dihapus!');
        }
    }
}
// dd($e->getMessage());