<?php

namespace App\Http\Controllers\SuperAdmin\AlokasiBarang;

use App\Http\Controllers\Controller;
use App\Models\ItemBarang;
use App\Models\ItemPenempatanBarang;
use App\Models\MutasiBarang;
use App\Models\PenempatanBarang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MutasiBarangController extends Controller
{
    public function index()
    {
        $title = 'Mutasi Lokasi Barang';
        $mutasi = MutasiBarang::select(
            'mutasi_barangs.*',
            'item_barangs.kode_item_barang',
            'item_barangs.nama_item_barang',
            'ruangans.kode_ruangan as kode_ruangan_awal',
            'ruangans.nama_ruangan as nama_ruangan_awal',
            'ruangans_tujuan.kode_ruangan as kode_ruangan_tujuan',
            'ruangans_tujuan.nama_ruangan as nama_ruangan_tujuan'
        )
            ->join('item_barangs', 'mutasi_barangs.id_item_barang', '=', 'item_barangs.id_item_barang')
            ->join('ruangans', 'mutasi_barangs.id_ruangan_awal', '=', 'ruangans.id_ruangan')
            ->join('ruangans as ruangans_tujuan', 'mutasi_barangs.id_ruangan_tujuan', '=', 'ruangans_tujuan.id_ruangan')
            ->get();

        return view("sa.content.mutasi-barang.list", compact('title', 'mutasi'));
    }

    public function add()
    {
        $title = 'Tambah Mutasi Barang';
        $ruangans = Ruangan::all();

        $itemBarang = ItemBarang::join('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->join('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->join('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->select('item_barangs.*', 'penempatan_barangs.id_ruangan', 'ruangans.nama_ruangan', 'ruangans.id_ruangan', 'item_penempatan_barangs.id_penempatan_barang')
            ->orderBy('kode_item_barang', 'asc')
            ->get();

        $nextKodeMutasiBarang = MutasiBarang::generateKodeMutasiBarang();

        return view('sa.content.mutasi-barang.add', compact('ruangans', 'title', 'nextKodeMutasiBarang', 'itemBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'           => 'required',
            'id_item_barang'    => 'required',
            'id_ruangan_tujuan' => 'required',
            'keterangan'        => 'nullable',
        ], [
            'id_item_barang.required'       => 'Item barang harus dipilih',
            'id_ruangan_tujuan.required'    => 'Ruangan tujuan harus dipilih',
            'tanggal.required'              => 'Tanggal harus diisi',
        ]);

        $itemBarang = ItemBarang::join('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->join('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->join('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->where('item_barangs.id_item_barang', $request->id_item_barang)
            ->select('item_barangs.*', 'penempatan_barangs.id_ruangan', 'ruangans.nama_ruangan', 'ruangans.id_ruangan', 'item_penempatan_barangs.id_penempatan_barang')
            ->first();

        $ruanganAwal = $itemBarang->nama_ruangan;

        $nextKodeMutasiBarang = MutasiBarang::generateKodeMutasiBarang();
        $nextKodePenempatanBarang = PenempatanBarang::generateKodePenempatanBarang();

        try {

            DB::beginTransaction();

            $mutasiBarang = new MutasiBarang();
            $mutasiBarang->kode_mutasi_barang = $nextKodeMutasiBarang;
            $mutasiBarang->tanggal   = $request->tanggal;
            $mutasiBarang->id_item_barang = $request->id_item_barang;
            $mutasiBarang->id_ruangan_awal = $request->id_ruangan_awal;
            $mutasiBarang->id_ruangan_tujuan = $request->id_ruangan_tujuan;
            $mutasiBarang->keterangan = $request->keterangan;
            $mutasiBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;
            $mutasiBarang->save();

            //tambah penemenpatan baru untuk mutasi
            $ruanganTujuan = $mutasiBarang->id_ruangan_tujuan;

            $penempatanDariMutasi = new PenempatanBarang();
            $penempatanDariMutasi->kode_penempatan_barang = $nextKodePenempatanBarang;
            $penempatanDariMutasi->id_ruangan = $ruanganTujuan;
            $penempatanDariMutasi->tanggal = $mutasiBarang->tanggal;
            $penempatanDariMutasi->keterangan = "Mutasi dari " . $ruanganAwal;
            $penempatanDariMutasi->created_by = $mutasiBarang->created_by;
            $penempatanDariMutasi->save();

            $itemPenempatan = ItemPenempatanBarang::where('id_item_barang', $mutasiBarang->id_item_barang)->first();
            $itemPenempatan->id_penempatan_barang = $penempatanDariMutasi->id_penempatan_barang;
            $itemPenempatan->save();


            DB::commit();
            return redirect(route('superadmin.mutasi_barang.index'))->with('success', 'Mutasi barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.mutasi_barang.index'))->with('error', 'Mutasi barang gagal ditambah!');
        }
    }

    public function delete($id_mutasi_barang)
    {
        $mutasiBarang = MutasiBarang::findOrFail($id_mutasi_barang);

        try {
            $mutasiBarang->delete();
            return redirect(route('superadmin.mutasi_barang.index'))->with('success', 'Mutasi Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.mutasi_barang.index'))->with('error', 'Mutasi Barang gagal dihapus!');
        }
    }

    public function edit($id_mutasi_barang)
    {
        $title = 'Ubah Data Mutasi Barang';
        $mutasiBarang = MutasiBarang::select(
            'mutasi_barangs.*',
            'item_barangs.kode_item_barang',
            'item_barangs.nama_item_barang',
            'ruangans.kode_ruangan as kode_ruangan_awal',
            'ruangans.nama_ruangan as nama_ruangan_awal',
            'ruangans_tujuan.kode_ruangan as kode_ruangan_tujuan',
            'ruangans_tujuan.nama_ruangan as nama_ruangan_tujuan'
        )
            ->join('item_barangs', 'mutasi_barangs.id_item_barang', '=', 'item_barangs.id_item_barang')
            ->join('ruangans', 'mutasi_barangs.id_ruangan_awal', '=', 'ruangans.id_ruangan')
            ->join('ruangans as ruangans_tujuan', 'mutasi_barangs.id_ruangan_tujuan', '=', 'ruangans_tujuan.id_ruangan')
            ->where('mutasi_barangs.id_mutasi_barang', $id_mutasi_barang)
            ->first();

        $ruangans = Ruangan::all();

        $itemBarang = ItemBarang::join('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->join('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->join('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->select('item_barangs.*', 'penempatan_barangs.id_ruangan', 'ruangans.nama_ruangan', 'ruangans.id_ruangan', 'item_penempatan_barangs.id_penempatan_barang')
            ->orderBy('kode_item_barang', 'asc')
            ->get();

        return view('sa.content.mutasi-barang.edit', compact('title', 'mutasiBarang', 'itemBarang', 'ruangans'));
    }

    public function update(Request $request, $id_mutasi_barang)
    {
        $request->validate([
            'tanggal'           => 'required',
            'id_item_barang'    => 'required',
            'id_ruangan_tujuan' => 'required',
            'keterangan'        => 'nullable',
        ], [
            'id_item_barang.required'       => 'Item barang harus dipilih',
            'id_ruangan_tujuan.required'    => 'Ruangan tujuan harus dipilih',
            'tanggal.required'              => 'Tanggal harus diisi',
        ]);

        $mutasiBarang = MutasiBarang::findOrFail($id_mutasi_barang);
        $ruanganAwal = $mutasiBarang->id_ruangan_awal;
        $ruanganTujuan = $mutasiBarang->id_ruangan_tujuan;
        $created_by = $mutasiBarang->created_by;

        try {

            DB::beginTransaction();

            $mutasiBarang->kode_mutasi_barang = $request->kode_mutasi_barang;
            $mutasiBarang->tanggal   = $request->tanggal;
            $mutasiBarang->id_item_barang = $request->id_item_barang;
            $mutasiBarang->id_ruangan_awal = $request->id_ruangan_awal;
            $mutasiBarang->id_ruangan_tujuan = $request->id_ruangan_tujuan;
            $mutasiBarang->keterangan = $request->keterangan;
            $mutasiBarang->created_by = $created_by;
            $mutasiBarang->updated_by = Auth::guard('superadmin')->user()->id_pengguna;
            $mutasiBarang->save();

            $itemBarang = $mutasiBarang->id_item_barang;

            $penempatanDariMutasi = PenempatanBarang::join('item_penempatan_barangs', 'penempatan_barangs.id_penempatan_barang', '=', 'item_penempatan_barangs.id_penempatan_barang')
                ->where('item_penempatan_barangs.id_item_barang', $itemBarang)
                ->first();
            $kodePenempatanBarang = $penempatanDariMutasi->kode_penempatan_barang;

            $penempatanDariMutasi->kode_penempatan_barang = $kodePenempatanBarang;
            $penempatanDariMutasi->id_ruangan = $mutasiBarang->id_ruangan_tujuan;
            $penempatanDariMutasi->tanggal = $mutasiBarang->tanggal;
            $penempatanDariMutasi->keterangan = "Mutasi dari " . $ruanganAwal;
            $penempatanDariMutasi->created_by = $mutasiBarang->created_by;
            $penempatanDariMutasi->save();

            dd($penempatanDariMutasi);
            DB::commit();
            return redirect(route('superadmin.mutasi_barang.index'))->with('success', 'Mutasi barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.mutasi_barang.index'))->with('error', 'Mutasi barang gagal ditambah!');
        }
    }
}

//dd($e->getMessage());