<?php

namespace App\Http\Controllers\SuperAdmin\PengadaanAset;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\PengadaanBangunan;
use App\Models\Tanah;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PengadaanBangunanController extends Controller
{
    public function index()
    {
        $title = 'Pengadaan Bangunan Baru';
        $pengadaanBangunan = PengadaanBangunan::select('pengadaan_bangunans.*', 'tanahs.nama_tanah as nama')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'pengadaan_bangunans.id_tanah')->latest()->get();

        return view('sa.content.pengadaan-bangunan.list', compact('title', 'pengadaanBangunan'));
    }

    public function add()
    {
        $title = 'Tambah Pengadaan Bangunan Baru';
        $tanah = Tanah::all();
        $nextKodePengadaanBangunan = PengadaanBangunan::generateKodePengadaanBangunan();
        $nextKodeBangunan = Bangunan::generateKodeBangunan();

        return view('sa.content.pengadaan-bangunan.add', compact('title', 'nextKodePengadaanBangunan', 'nextKodeBangunan', 'tanah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kondisi' => 'required',
            'id_tanah' => 'required',
            'sumber' => 'required',
            'keterangan' => 'nullable',
            'nota' => 'nullable|image',
        ], [
            'kondisi.required' => 'Kondisi harus dipilih',
            'sumber.required' => 'Sumber harus dipilih',
        ]);

        try {
            DB::beginTransaction();

            $nextKodePengadaanBangunan = PengadaanBangunan::generateKodePengadaanBangunan();
            $nextKodeBangunan = Bangunan::generateKodeBangunan();

            $pengadaanBangunan = new PengadaanBangunan();
            $pengadaanBangunan->kode_pengadaan_bangunan = $nextKodePengadaanBangunan;
            $pengadaanBangunan->kode_bangunan = $nextKodeBangunan;
            $pengadaanBangunan->nama_bangunan = $request->nama_bangunan;
            $pengadaanBangunan->id_tanah = $request->id_tanah;
            $pengadaanBangunan->lokasi = $request->lokasi;
            $pengadaanBangunan->kondisi = $request->kondisi;
            $pengadaanBangunan->deskripsi = $request->deskripsi;
            $pengadaanBangunan->tanggal_pengadaan = $request->tanggal_pengadaan;
            $pengadaanBangunan->sumber = $request->sumber;
            $pengadaanBangunan->harga_perolehan = str_replace('.', '', $request->harga_perolehan);
            $pengadaanBangunan->umur_manfaat = $request->umur_manfaat;
            $pengadaanBangunan->nilai_residu = str_replace('.', '', $request->nilai_residu);
            $pengadaanBangunan->keterangan = $request->keterangan;
            $pengadaanBangunan->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            // Cek apakah ada file foto yang diunggah
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $pengadaanBangunan->nota = 'nota/' . $notaName;
            } // Jika tidak ada file nota yang diunggah, biarkan nota tetap menggunakan nota yang sebelumnya
            $pengadaanBangunan->save();

            $bangunan = new Bangunan();
            $bangunan->kode_bangunan = $pengadaanBangunan->kode_bangunan;
            $bangunan->nama_bangunan = $pengadaanBangunan->nama_bangunan;
            $bangunan->id_tanah = $pengadaanBangunan->id_tanah;
            $bangunan->lokasi = $pengadaanBangunan->lokasi;
            $bangunan->deskripsi = $pengadaanBangunan->deskripsi;
            $bangunan->tanggal_pengadaan = $pengadaanBangunan->tanggal_pengadaan;
            $bangunan->sumber = $pengadaanBangunan->sumber;
            $bangunan->kondisi = $pengadaanBangunan->kondisi;
            $bangunan->harga_perolehan = $pengadaanBangunan->harga_perolehan;
            $bangunan->umur_manfaat = $pengadaanBangunan->umur_manfaat;
            $bangunan->nilai_residu = $pengadaanBangunan->nilai_residu;
            $bangunan->keterangan = $pengadaanBangunan->keterangan;
            $bangunan->created_by = $pengadaanBangunan->created_by;
            $bangunan->save();

            DB::commit();

            return redirect(route('superadmin.pengadaan_bangunan.index'))->with('success', 'Pengadaan bangunan berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.pengadaan_bangunan.index'))->with('error', 'Pengadaan bangunan gagal ditambah!');
        }
    }

    public function edit($id_pengadaan_bangunan)
    {
        $title = "Ubah Pengadaan Bangunan";

        $pengadaanBangunan = PengadaanBangunan::findOrFail($id_pengadaan_bangunan);
        return view('sa.content.pengadaan-bangunan.edit', compact('title', 'pengadaanBangunan'));
    }

    public function update(Request $request, $id_pengadaan_bangunan)
    {
        $request->validate([
            'kondisi' => 'required',
            'sumber' => 'required',
            'keterangan' => 'nullable',
            'nota' => 'nullable|image',
        ], [
            'kondisi.required' => 'Kondisi harus dipilih',
            'sumber.required' => 'Sumber harus dipilih',
        ]);

        try {
            DB::beginTransaction();

            $pengadaanBangunan = PengadaanBangunan::findOrFail($id_pengadaan_bangunan);
            $pengadaanBangunan->kode_pengadaan_bangunan = $request->kode_pengadaan_bangunan;
            $pengadaanBangunan->kode_bangunan =  $request->kode_bangunan;
            $pengadaanBangunan->nama_bangunan = $request->nama_bangunan;
            $pengadaanBangunan->lokasi = $request->lokasi;
            $pengadaanBangunan->kondisi = $request->kondisi;
            $pengadaanBangunan->deskripsi = $request->deskripsi;
            $pengadaanBangunan->tanggal_pengadaan = $request->tanggal_pengadaan;
            $pengadaanBangunan->sumber = $request->sumber;
            $pengadaanBangunan->harga_perolehan = str_replace('.', '', $request->harga_perolehan);
            $pengadaanBangunan->umur_manfaat = $request->umur_manfaat;
            $pengadaanBangunan->nilai_residu = str_replace('.', '', $request->nilai_residu);
            $pengadaanBangunan->keterangan = $request->keterangan;
            $pengadaanBangunan->created_by = $request->created_by;

            // Upload file nota
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $pengadaanBangunan->nota = 'nota/' . $notaName;
            } else {
                // Gunakan nota lama jika tidak ada nota baru yang diunggah
                $pengadaanBangunan->nota = $pengadaanBangunan->nota;
            }

            $pengadaanBangunan->updated_by = Auth::guard('superadmin')->user()->id_pengguna;



            $pengadaanBangunan->save();

            $bangunan = Bangunan::where('kode_bangunan', $pengadaanBangunan->kode_bangunan)->first();
            $bangunan->kode_bangunan = $pengadaanBangunan->kode_bangunan;
            $bangunan->nama_bangunan = $pengadaanBangunan->nama_bangunan;
            $bangunan->lokasi = $pengadaanBangunan->lokasi;
            $bangunan->deskripsi = $pengadaanBangunan->deskripsi;
            $bangunan->tanggal_pengadaan = $pengadaanBangunan->tanggal_pengadaan;
            $bangunan->sumber = $pengadaanBangunan->sumber;
            $bangunan->kondisi = $pengadaanBangunan->kondisi;
            $bangunan->harga_perolehan = $pengadaanBangunan->harga_perolehan;
            $bangunan->umur_manfaat = $pengadaanBangunan->umur_manfaat;
            $bangunan->nilai_residu = $pengadaanBangunan->nilai_residu;
            $bangunan->keterangan = $pengadaanBangunan->keterangan;
            $bangunan->created_by = $pengadaanBangunan->created_by;
            $bangunan->updated_by = $pengadaanBangunan->updated_by;
            $bangunan->save();

            DB::commit();

            return redirect(route('superadmin.pengadaan_bangunan.index'))->with('success', 'Pengadaan bangunan berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect(route('superadmin.pengadaan_bangunan.index'))->with('error', 'Pengadaan bangunan gagal diubah!');
        }
    }

    public function delete($id_pengadaan_bangunan)
    {
        try {
            DB::beginTransaction();

            $pengadaanBangunan = PengadaanBangunan::findOrFail($id_pengadaan_bangunan);

            // Hapus data bangunan terkait
            $bangunan = Bangunan::where('kode_bangunan', $pengadaanBangunan->kode_bangunan)->first();
            if ($bangunan) {
                $bangunan->delete();
            }

            // Hapus data pengadaan bangunan
            $pengadaanBangunan->delete();

            DB::commit();
            return redirect(route('superadmin.pengadaan_bangunan.index'))->with('success', 'Pengadaan bangunan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect(route('superadmin.pengadaan_bangunan.index'))->with('error', 'Pengadaan bangunan gagal dihapus!');
        }
    }

    public function detail($id_pengadaan_bangunan)
    {
        $title = 'Detail Pengadaan Bangunan';
        $detail = PengadaanBangunan::select('pengadaan_bangunans.*', 'tanahs.nama_tanah as nama')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'pengadaan_bangunans.id_tanah')
            ->findOrFail($id_pengadaan_bangunan);

        return view('sa.content.pengadaan-bangunan.detail', compact('title', 'detail'));
    }
}

//   dd($e->getMessage());