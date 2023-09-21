<?php

namespace App\Http\Controllers\SuperAdmin\PengadaanAset;

use App\Http\Controllers\Controller;
use App\Models\PengadaanTanah;
use App\Models\Tanah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PengadaanTanahController extends Controller
{
    public function index()
    {
        $title = 'Data Pengadaan Aset Tanah ';
        $pengadaanTanah = PengadaanTanah::latest()->get();

        return view('sa.content.pengadaan-tanah.list', compact('title', 'pengadaanTanah'));
    }
    public function add()
    {
        $title = 'Tambah Pengadaan Aset Tanah ';
        $nextKodePengadaanTanah = PengadaanTanah::generateKodePengadaanTanah();
        $nextKodeTanah = Tanah::generateKodeTanah();
        return view('sa.content.pengadaan-tanah.add', compact('title', 'nextKodePengadaanTanah', 'nextKodeTanah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pengadaan_tanah' => 'required',
            'kode_tanah' => 'required',
            'nama_tanah' => 'required',
            'lokasi' => 'required',
            'sumber' => 'required',
            'luas' => 'required',
            'tanggal_pengadaan' => 'required',
            'harga_perolehan' => 'required',
            'nota' => 'nullable|image',
            'keterangan' => 'nullable'
        ], [
            'nama_tanah.required' => 'Nama Tanah harus diisi.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'sumber.required' => 'Sumber harus dipilih.',
            'luas.required' => 'Luas harus diisi.',
            'tanggal_pengadaan.required' => 'Tanggal harus diisi.',
            'harga_perolehan.required' => 'Harga Perolehan harus diisi.',
        ]);
        $nextKodePengadaanTanah = PengadaanTanah::generateKodePengadaanTanah();
        $nextKodeTanah = Tanah::generateKodeTanah();
        try {

            DB::beginTransaction();
            // Menyimpan data pengadaan tanah
            $pengadaanTanah = new PengadaanTanah();
            $pengadaanTanah->kode_pengadaan_tanah = $nextKodePengadaanTanah;
            $pengadaanTanah->kode_tanah = $nextKodeTanah;
            $pengadaanTanah->nama_tanah = $request->nama_tanah;
            $pengadaanTanah->lokasi = $request->lokasi;
            $pengadaanTanah->sumber = $request->sumber;
            $pengadaanTanah->luas = $request->luas;
            $pengadaanTanah->tanggal_pengadaan = $request->tanggal_pengadaan;
            $pengadaanTanah->harga_perolehan  = str_replace('.', '', $request->harga_perolehan);
            $pengadaanTanah->keterangan = $request->keterangan;
            $pengadaanTanah->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            // Cek apakah ada file foto yang diunggah
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $pengadaanTanah->nota = 'nota/' . $notaName;
            }

            $pengadaanTanah->save();

            // // Menyimpan data tanah
            $tanah = new Tanah();
            $tanah->kode_tanah = $pengadaanTanah->kode_tanah;
            $tanah->nama_tanah = $pengadaanTanah->nama_tanah;
            $tanah->lokasi = $pengadaanTanah->lokasi;
            $tanah->sumber = $pengadaanTanah->sumber;
            $tanah->luas = $pengadaanTanah->luas;
            $tanah->tanggal_pengadaan = $pengadaanTanah->tanggal_pengadaan;
            $tanah->harga_perolehan = $pengadaanTanah->harga_perolehan;
            $tanah->keterangan = $pengadaanTanah->keterangan;
            $tanah->created_by = $pengadaanTanah->created_by;
            $tanah->save();

            DB::commit();

            return redirect(route('superadmin.pengadaan_tanah.index'))->with('success', 'Pengadaan tanah berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect(route('superadmin.pengadaan_tanah.index'))->with('error', 'Pengadaan tanah gagal ditambah!');
        }
    }

    public function edit($id_pengadaan_tanah)
    {
        $title = 'Ubah Pengadaan Tanah';
        $pengadaanTanah = PengadaanTanah::findOrFail($id_pengadaan_tanah);

        return view('sa.content.pengadaan-tanah.edit', compact('pengadaanTanah', 'title'));
    }

    public function update(Request $request, $id_pengadaan_tanah)
    {
        $request->validate([
            'kode_pengadaan_tanah' => 'required',
            'nama_tanah' => 'required',
            'lokasi' => 'required',
            'sumber' => 'required',
            'luas' => 'required',
            'tanggal_pengadaan' => 'required',
            'harga_perolehan' => 'required',
            'keterangan' => 'nullable',
            'nota' => 'nullable|image',
        ], [
            'nama_tanah.required' => 'Nama Tanah harus diisi.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'sumber.required' => 'Sumber harus dipilih.',
            'luas.required' => 'Luas harus diisi.',
            'tanggal_pengadaan.required' => 'Tanggal harus diisi.',
            'harga_perolehan.required' => 'Harga Perolehan harus diisi.',
        ]);

        try {

            DB::beginTransaction();
            // Perbarui data pengadaan tanah
            $pengadaanTanah = PengadaanTanah::findOrFail($id_pengadaan_tanah);
            $pengadaanTanah->kode_pengadaan_tanah = $request->kode_pengadaan_tanah;
            $pengadaanTanah->nama_tanah = $request->nama_tanah;
            $pengadaanTanah->lokasi = $request->lokasi;
            $pengadaanTanah->sumber = $request->sumber;
            $pengadaanTanah->luas = $request->luas;
            $pengadaanTanah->tanggal_pengadaan = $request->tanggal_pengadaan;
            $pengadaanTanah->harga_perolehan  = str_replace('.', '', $request->harga_perolehan);
            $pengadaanTanah->keterangan = $request->keterangan;
            $pengadaanTanah->created_by = $request->created_by;
            $pengadaanTanah->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

            // Upload file nota
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $pengadaanTanah->nota = 'nota/' . $notaName;
            } else {
                // Gunakan nota lama jika tidak ada nota baru yang diunggah
                $pengadaanTanah->nota = $pengadaanTanah->nota;
            }
            $pengadaanTanah->save();

            // Perbarui data tanah terkait di tabel tanah
            $tanah = Tanah::where('kode_tanah', $pengadaanTanah->kode_tanah)->first();
            $tanah->kode_tanah = $pengadaanTanah->kode_tanah;
            $tanah->nama_tanah = $pengadaanTanah->nama_tanah;
            $tanah->lokasi = $pengadaanTanah->lokasi;
            $tanah->sumber = $pengadaanTanah->sumber;
            $tanah->luas = $pengadaanTanah->luas;
            $tanah->tanggal_pengadaan = $pengadaanTanah->tanggal_pengadaan;
            $tanah->harga_perolehan = $pengadaanTanah->harga_perolehan;
            $tanah->keterangan = $pengadaanTanah->keterangan;
            $tanah->created_by = $pengadaanTanah->created_by;
            $tanah->updated_by = $pengadaanTanah->updated_by;
            $tanah->save();


            DB::commit();
            return redirect(route('superadmin.pengadaan_tanah.index'))->with('success', 'Pengadaan tanah berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect(route('superadmin.pengadaan_tanah.index'))->with('error', 'Pengadaan tanah gagal diubah!');
        }
    }

    public function delete($id_pengadaan_tanah)
    {
        try {
            DB::beginTransaction();

            $pengadaanTanah = PengadaanTanah::findOrFail($id_pengadaan_tanah);

            // Hapus data tanah terkait
            $tanah = Tanah::where('kode_tanah', $pengadaanTanah->kode_tanah)->first();
            if ($tanah) {
                $tanah->delete();
            }

            // Hapus data pengadaan tanah
            $pengadaanTanah->delete();

            DB::commit();
            return redirect(route('superadmin.pengadaan_tanah.index'))->with('success', 'Pengadaan tanah berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect(route('superadmin.pengadaan_tanah.index'))->with('error', 'Pengadaan tanah gagal dihapus!');
        }
    }


    public function detail($id_pengadaan_tanah)
    {
        $title = 'Detail Pengadaan Aset Tanah';
        $detail = PengadaanTanah::findOrFail($id_pengadaan_tanah);

        return view('sa.content.pengadaan-tanah.detail', compact('title', 'detail'));
    }
}



//dd($e->getMessage());