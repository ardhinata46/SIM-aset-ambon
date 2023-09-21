<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\ItemBarang;
use App\Models\ItemPenempatanBarang;
use App\Models\MutasiBarang;
use App\Models\PenempatanBarang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class RuanganController extends Controller
{
    public function index()
    {
        $title = 'Ruangan ';
        $ruangan = Ruangan::select('ruangans.*', 'bangunans.nama_bangunan as nama')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'ruangans.id_bangunan')
            ->latest()->get();

        return view('sa.content.ruangan.list', compact('title', 'ruangan'));
    }

    public function add()
    {
        $title = 'Tambah Ruangan ';
        $nextKodeRuangan = Ruangan::generateKodeRuangan();
        $bangunan = Bangunan::all();

        return view('sa.content.ruangan.add', compact('title', 'nextKodeRuangan', 'bangunan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'id_bangunan' => 'required',
        ]);

        $nextKodeRuangan = Ruangan::generateKodeRuangan();

        // Simpan data ke database dengan menggunakan $nextKodeRuangan
        $ruangan = new Ruangan();
        $ruangan->kode_ruangan = $nextKodeRuangan;
        $ruangan->id_bangunan = $request->id_bangunan;
        $ruangan->nama_ruangan = $request->nama_ruangan;
        $ruangan->created_by = Auth::guard('superadmin')->user()->id_pengguna;

        try {
            $ruangan->save();
            return redirect(route('superadmin.ruangan.index'))->with('success', 'Ruangan berhasil ditambah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.ruangan.index'))->with('error', 'Ruangan gagal ditambah!');
        }
    }

    public function detail($id_ruangan)
    {
        $title = 'Detail Ruangan ';

        // Ambil data ruangan
        $ruangan = Ruangan::select('ruangans.*', 'bangunans.nama_bangunan as nama')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'ruangans.id_bangunan')
            ->where('ruangans.id_ruangan', '=', $id_ruangan)
            ->first();


        // Ambil data penempatan barang berdasarkan ruangan
        $penempatanBarang = PenempatanBarang::where('id_ruangan', $id_ruangan)->get();

        // Ambil detail item penempatan berdasarkan penempatan barang
        $detailPenempatan = [];
        foreach ($penempatanBarang as $penempatan) {
            $itemPenempatan = DB::table('item_penempatan_barangs')
                ->select('item_penempatan_barangs.id_item_penempatan_barang', 'item_barangs.id_item_barang', 'item_barangs.nama_item_barang', 'item_barangs.kode_item_barang', 'penempatan_barangs.tanggal as tanggal_penempatan')
                ->join('item_barangs', 'item_penempatan_barangs.id_item_barang', '=', 'item_barangs.id_item_barang')
                ->join('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
                ->where('item_penempatan_barangs.id_penempatan_barang', $penempatan->id_penempatan_barang)
                ->get();

            $detailPenempatan[] = [
                'penempatan' => $penempatan,
                'itemPenempatan' => $itemPenempatan,
            ];
        }

        return view('sa.content.ruangan.detail', compact('ruangan', 'detailPenempatan', 'title'));
    }


    public function edit($id_ruangan)
    {
        $title = 'Ubah Ruangan ';
        $ruangan = Ruangan::findOrFail($id_ruangan);

        return view('sa.content.ruangan.edit', compact('ruangan', 'title'));
    }

    public function update(Request $request, $id_ruangan)
    {

        $ruangan = Ruangan::findOrFail($id_ruangan);
        $ruangan->kode_ruangan = $request->kode_ruangan;
        $ruangan->nama_ruangan = $request->nama_ruangan;
        $ruangan->created_by =  $request->created_by;
        $ruangan->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

        try {
            $ruangan->save();
            return redirect(route('superadmin.ruangan.index'))->with('success', 'Ruangan berhasil diubah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.ruangan.index'))->with('error', 'Ruangan gagal diubah!');
        }
    }

    public function delete($id_ruangan)
    {

        $ruangan = Ruangan::findOrFail($id_ruangan);

        try {
            $ruangan->delete();
            return redirect(route('superadmin.ruangan.index'))->with('success', 'Ruangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.ruangan.index'))->with('error', 'Ruangan gagal dihapus!');
        }
    }

    public function deleteItem($id_item_penempatan_barang)
    {
        $itemPenempatan = ItemPenempatanBarang::findOrFail($id_item_penempatan_barang);

        try {
            $itemPenempatan->delete();
            return redirect()->back()->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Barang gagal dihapus!');
        }
    }

    public function mutasi($id_item_barang)
    {
        $title = 'Mutasi Barang ';
        $itemBarang = ItemBarang::select('item_barangs.*', 'penempatan_barangs.id_ruangan', 'ruangans.nama_ruangan')
            ->join('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->join('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->join('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->first();

        $ruangan = Ruangan::all();
        $nextKodeMutasiBarang = MutasiBarang::generateKodeMutasiBarang();

        return view('sa.content.ruangan.mutasi', compact('title', 'itemBarang', 'ruangan', 'nextKodeMutasiBarang'));
    }

    public function storeMutasi(Request $request, $id_item_barang)
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

            $id_ruangan = $mutasiBarang->id_ruangan_tujuan;
            DB::commit();
            return redirect(route('superadmin.ruangan.detail', $id_ruangan))->with('success', 'Mutasi barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.ruangan.detail', $id_ruangan))->with('error', 'Mutasi barang gagal ditambah!');
        }
    }
}
//dd($e->getMessage());