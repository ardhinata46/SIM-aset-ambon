<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\Tanah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BangunanController extends Controller
{

    public function index()
    {
        $title = 'Data Bangunan ';
        $bangunan = Bangunan::select('bangunans.*', 'tanahs.nama_tanah as nama')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
            ->where('bangunans.status', '=', 1)
            ->latest()
            ->get();


        return view('sa.content.bangunan.list', compact('title', 'bangunan'));
    }

    public function add()
    {
        $title = 'Tambah Data Bangunan ';
        $tanah = Tanah::all();
        $nextKodeBangunan = Bangunan::generateKodeBangunan();

        return view('sa.content.bangunan.add', compact('title', 'nextKodeBangunan', 'tanah'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama_bangunan' => 'required',
            'id_tanah' => 'required',
            'sumber' => 'required',
            'kondisi' => 'required',
            'keterangan' => 'nullable',
        ], [
            'nama_bangunan.required' => 'Nama Bangunan harus dipilih.',
            'id_tanah.required' => 'Tanah lokasi bangunan harus diisi.',
            'sumber.required' => 'Sumber harus dipilih.',
            'kondisi.required' => 'Kondisi harus dipilih.',
        ]);

        $nextKodeBangunan = Bangunan::generateKodeBangunan();

        $bangunan = new Bangunan();
        $bangunan->kode_bangunan        = $nextKodeBangunan;
        $bangunan->id_tanah        = $request->id_tanah;
        $bangunan->nama_bangunan        = $request->nama_bangunan;
        $bangunan->lokasi               = $request->lokasi;
        $bangunan->deskripsi            = $request->deskripsi;
        $bangunan->tanggal_pengadaan    = $request->tanggal_pengadaan;
        $bangunan->sumber               = $request->sumber;
        $bangunan->kondisi               = $request->kondisi;
        $bangunan->harga_perolehan = str_replace('.', '', $request->harga_perolehan);
        $bangunan->umur_manfaat         = $request->umur_manfaat;
        $bangunan->nilai_residu = str_replace('.', '', $request->nilai_residu);
        $bangunan->keterangan            = $request->keterangan;
        $bangunan->created_by = Auth::guard('superadmin')->user()->id_pengguna;

        try {
            $bangunan->save();
            return redirect(route('superadmin.bangunan.index'))->with('success', 'Bangunan berhasil ditambah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.bangunan.index'))->with('error', 'Bangunan gagal ditambah!');
        }
    }

    public function detail($id_bangunan)
    {
        $title = 'Detail Data Bangunan ';
        $detail = Bangunan::select('bangunans.*', 'tanahs.nama_tanah as nama')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
            ->where('bangunans.id_bangunan', '=', $id_bangunan)
            ->first();

        return view('sa.content.bangunan.detail', compact('title', 'detail'));
    }


    public function edit($id_bangunan)
    {
        $title = 'Ubah Data Bangunan ';
        $bangunan = Bangunan::findOrFail($id_bangunan);

        return view('sa.content.bangunan.edit', compact('title', 'bangunan'));
    }

    public function update(Request $request, $id_bangunan)
    {
        $request->validate([
            'nama_bangunan' => 'required',
            'lokasi' => 'required',
            'sumber' => 'required',
            'keterangan' => 'nullable',
        ], [
            'nama_bangunan.required' => 'Nama Bangunan harus dipilih.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'sumber.required' => 'Sumber harus dipilih.',
        ]);

        $bangunan = Bangunan::findOrFail($id_bangunan);
        $bangunan->kode_bangunan        = $request->kode_bangunan;
        $bangunan->nama_bangunan        = $request->nama_bangunan;
        $bangunan->lokasi               = $request->lokasi;
        $bangunan->deskripsi            = $request->deskripsi;
        $bangunan->tanggal_pengadaan    = $request->tanggal_pengadaan;
        $bangunan->sumber               = $request->sumber;
        $bangunan->kondisi               = $request->kondisi;
        $bangunan->harga_perolehan = str_replace('.', '', $request->harga_perolehan);
        $bangunan->umur_manfaat         = $request->umur_manfaat;
        $bangunan->nilai_residu = str_replace('.', '', $request->nilai_residu);
        $bangunan->keterangan           = $request->keterangan;
        $bangunan->created_by           = $request->created_by;
        $bangunan->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

        try {
            $bangunan->save();
            return redirect(route('superadmin.bangunan.index'))->with('success', 'Bangunan berhasil diubah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.bangunan.index'))->with('error', 'Bangunan gagal diubah!');
        }
    }

    public function delete($id_bangunan)
    {
        $bangunan = Bangunan::findOrFail($id_bangunan);
        try {
            $bangunan->delete();
            return redirect(route('superadmin.bangunan.index'))->with('success', 'Bangunan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.bangunan.index'))->with('error', 'Bangunan gagal dihapus!');
        }
    }
}
