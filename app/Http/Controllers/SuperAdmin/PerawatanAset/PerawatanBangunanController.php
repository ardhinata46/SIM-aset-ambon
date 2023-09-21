<?php

namespace App\Http\Controllers\SuperAdmin\PerawatanAset;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\PerawatanBangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PerawatanBangunanController extends Controller
{
    public function index()
    {
        $title = 'Data Perawatan Aset Bangunan';

        $perawatanBangunan = PerawatanBangunan::select("perawatan_bangunans.*", 'bangunans.nama_bangunan as bangunan', 'bangunans.kode_bangunan as kode')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'perawatan_bangunans.id_bangunan')
            ->latest()->get();

        return view('sa.content.perawatan-bangunan.list', compact('title', 'perawatanBangunan'));
    }

    public function add()
    {
        $bangunan = Bangunan::where('status', 1)->get();
        $title = 'Tambah Perawatan Bangunan';
        $nextKodePerawatanBangunan = PerawatanBangunan::generateKodePerawatanBangunan();

        return view('sa.content.perawatan-bangunan.add', compact('title', 'nextKodePerawatanBangunan', 'bangunan'));
    }

    public function store(Request $request)
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


        $bangunan = Bangunan::findOrFail($request->id_bangunan); // Mengambil data bangunan berdasarkan ID yang dipilih

        $kondisiSebelum = $bangunan->kondisi; // Mengambil kondisi bangunan sebelum perawatan
        try {
            DB::beginTransaction();

            $nextKodePerawatanBangunan = PerawatanBangunan::generateKodePerawatanBangunan();

            $perawatanBangunan = new PerawatanBangunan();
            $perawatanBangunan->kode_perawatan_bangunan = $nextKodePerawatanBangunan;
            $perawatanBangunan->id_bangunan = $request->id_bangunan;
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
            return redirect(route('superadmin.perawatan_bangunan.index'))->with('success', 'Perawatan bangunan berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.perawatan_bangunan.index'))->with('error', 'Perawatan bangunan gagal ditambah!');
        }
    }


    public function delete($id_perawatan_bangunan)
    {
        try {
            DB::beginTransaction();

            $perawatanBangunan = PerawatanBangunan::findOrFail($id_perawatan_bangunan);
            $bangunan = $perawatanBangunan->id_bangunan;
            $kembalikanKondisi = $perawatanBangunan->kondisi_sebelum;
            $perawatanBangunan->delete();

            $bangunan = bangunan::findOrFail($bangunan); // Mengambil data bangunan sebelumnya
            $bangunan->kondisi = $kembalikanKondisi;
            $bangunan->save();

            DB::commit();
            return redirect(route('superadmin.perawatan_bangunan.index'))->with('success', 'Perawatan bangunan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.perawatan_bangunan.index'))->with('error', 'Perawatan bangunan gagal dihapus!');
        }
    }

    public function edit($id_perawatan_bangunan)
    {
        $title = 'Perawatan Aset Bangunan';
        $perawatanBangunan = PerawatanBangunan::findOrFail($id_perawatan_bangunan);
        $bangunan = Bangunan::where('status', 1)->get();

        return view('sa.content.perawatan-bangunan.edit', compact('title', 'perawatanBangunan', 'bangunan'));
    }

    public function update(Request $request, $id_perawatan_bangunan)
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

        try {
            $bangunan = Bangunan::findOrFail($request->id_bangunan); // Mengambil data bangunan berdasarkan ID yang dipilih

            $kondisiSebelum = $bangunan->kondisi; // Mengambil kondisi bangunan sebelum perawatan

            $perawatanBangunan = Perawatanbangunan::findOrFail($id_perawatan_bangunan);
            $bangunanSebelumnya = $perawatanBangunan->id_bangunan;
            $kembalikanKondisi = $perawatanBangunan->kondisi_sebelum;

            $perawatanBangunan->kode_perawatan_bangunan = $request->kode_perawatan_bangunan;
            $perawatanBangunan->id_bangunan = $request->id_bangunan;
            $perawatanBangunan->tanggal_perawatan = $request->tanggal_perawatan;
            $perawatanBangunan->kondisi_sebelum = $kondisiSebelum;
            $perawatanBangunan->kondisi_sesudah = $request->kondisi_sesudah;
            $perawatanBangunan->deskripsi = $request->deskripsi;
            $perawatanBangunan->biaya = str_replace('.', '', $request->biaya);
            $perawatanBangunan->keterangan = $request->keterangan;
            $perawatanBangunan->updated_by = Auth::guard('superadmin')->user()->id_pengguna;
            // Upload file nota
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $perawatanBangunan->nota = 'nota/' . $notaName;
            } else {
                // Gunakan nota lama jika tidak ada nota baru yang diunggah
                $perawatanBangunan->nota = $perawatanBangunan->nota;
            }
            $perawatanBangunan->save();

            if ($request->id_bangunan == $perawatanBangunan->bangunanSebelumnya) {
                $bangunan->kondisi = $perawatanBangunan->kondisi_sesudah;
            } else {
                $bangunan->kondisi = $request->kondisi_sesudah;

                $bangunanSebelumnya = Bangunan::findOrFail($bangunanSebelumnya); // Mengambil data bangunan sebelumnya
                $bangunanSebelumnya->kondisi = $kembalikanKondisi;
                $bangunanSebelumnya->save();
            }

            $bangunan->save();

            DB::commit();
            return redirect(route('superadmin.perawatan_bangunan.index'))->with(['success' => 'Perubahan data berhasil']);
        } catch (\Exception $e) {
            DB::rollback();

            // Kembalikan kondisi bangunan A ke kondisi sebelumnya
            $bangunanSebelumnya = Bangunan::find($bangunanSebelumnya->id_bangunan);
            $bangunanSebelumnya->kondisi = $kondisiSebelum;
            $bangunanSebelumnya->save();

            return redirect(route('superadmin.perawatan_bangunan.index'))->with(['warning' => 'Perubahan data gagal. Pastikan semua inputan sudah diisi dengan benar!']);
        }
    }

    public function detail($id_perawatan_bangunan)
    {
        $title = 'Data Perawatan Aset Bangunan';

        $detail = PerawatanBangunan::select("perawatan_bangunans.*", 'bangunans.nama_bangunan as bangunan', 'bangunans.kode_bangunan as kode')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'perawatan_bangunans.id_bangunan')
            ->where('perawatan_bangunans.id_perawatan_bangunan', $id_perawatan_bangunan)
            ->first();

        return view('sa.content.perawatan-bangunan.detail', compact('title', 'detail'));
    }
}
//   dd($e->getMessage());