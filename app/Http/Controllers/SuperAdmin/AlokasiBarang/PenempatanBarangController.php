<?php

namespace App\Http\Controllers\SuperAdmin\AlokasiBarang;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\ItemPenempatanBarang;
use App\Models\PenempatanBarang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenempatanBarangController extends Controller
{

    public function index()
    {
        $title = 'Penempatan Barang';
        $penempatanBarang = PenempatanBarang::select("penempatan_barangs.*", 'ruangans.nama_ruangan as ruangan')
            ->join('ruangans', 'ruangans.id_ruangan', '=', 'penempatan_barangs.id_ruangan')
            ->latest()->get();

        return view('sa.content.penempatan-barang.list', compact('title', 'penempatanBarang'));
    }

    public function add()
    {
        $title = 'Tambah Penempatan Barang';
        $ruangans = Ruangan::all();

        $itemBarang = DB::table('item_barangs')
            ->leftJoin('item_penempatan_barangs', function ($join) {
                $join->on('item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang');
            })
            ->leftJoin('penempatan_barangs', function ($join) {
                $join->on('item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang');
            })
            ->whereNull('item_penempatan_barangs.id_item_barang')
            ->where('item_barangs.status', '=', 1)
            ->select('item_barangs.*')
            ->get();

        $nextKodePenempatanBarang = PenempatanBarang::generateKodePenempatanBarang();

        return view('sa.content.penempatan-barang.add', compact('ruangans', 'title', 'nextKodePenempatanBarang', 'itemBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan'    => 'required',
            'keterangan'           => 'nullable',
        ], [
            'id_ruangan.required'       => 'Ruangan harus dipilih',
        ]);

        $nextKodePenempatanBarang = PenempatanBarang::generateKodePenempatanBarang();

        try {

            DB::beginTransaction();

            // Simpan data ke database dengan menggunakan $nextKodeBarang
            $penempatanBarang = new PenempatanBarang();
            $penempatanBarang->kode_penempatan_barang = $nextKodePenempatanBarang;
            $penempatanBarang->id_ruangan = $request->id_ruangan;
            $penempatanBarang->tanggal   = $request->tanggal;
            $penempatanBarang->keterangan = $request->keterangan;
            $penempatanBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            $penempatanBarang->save();

            // Simpan item barang
            $idPenempatanBarang = $penempatanBarang->id_penempatan_barang;
            $idItemBarangSelect = $request->idItemBarangSelect;

            foreach ($idItemBarangSelect as $idItemBarang) {
                $itemPenempatanBarang = new ItemPenempatanBarang();
                $itemPenempatanBarang->id_penempatan_barang = $idPenempatanBarang;
                $itemPenempatanBarang->id_item_barang = $idItemBarang;
                $itemPenempatanBarang->save();
            }

            DB::commit();
            return redirect(route('superadmin.penempatan_barang.index'))->with('success', 'Penempatan barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.penempatan_barang.index'))->with('error', 'Penempatan barang gagal ditambah!');
        }
    }

    public function detail($id_penempatan_barang)
    {

        $title = 'Detail Penempatan Barang';
        $detail = PenempatanBarang::select("penempatan_barangs.*", 'ruangans.nama_ruangan as nama', 'ruangans.kode_ruangan as kode')
            ->join('ruangans', 'ruangans.id_ruangan', '=', 'penempatan_barangs.id_ruangan')
            ->findOrFail($id_penempatan_barang);

        $item = ItemPenempatanBarang::select("item_penempatan_barangs.*", 'item_barangs.nama_item_barang as nama_item_barang', 'item_barangs.kode_item_barang as kode_item_barang')
            ->join('item_barangs', 'item_penempatan_barangs.id_item_barang', '=', 'item_barangs.id_item_barang')
            ->where('item_penempatan_barangs.id_penempatan_barang', $id_penempatan_barang)
            ->get();

        return view('sa.content.penempatan-barang.detail', compact('title', 'detail', 'item'));
    }

    public function delete($id_penempatan_barang)
    {
        $penempatanBarang = PenempatanBarang::findOrFail($id_penempatan_barang);
        try {
            $penempatanBarang->delete();
            return redirect(route('superadmin.penempatan_barang.index'))->with('success', 'Penempatan barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.penempatan_barang.index'))->with('error', 'Penempatan barang gagal dihapus!');
        }
    }

    public function edit($id_penempatan_barang)
    {
        $title = 'Ubah Penempatan Barang';
        $ruangan = Ruangan::all();
        $penempatanBarang = PenempatanBarang::findOrFail($id_penempatan_barang);
        $itemBarang = DB::table('item_barangs')
            ->leftJoin('item_penempatan_barangs', function ($join) {
                $join->on('item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang');
            })
            ->leftJoin('penempatan_barangs', function ($join) {
                $join->on('item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang');
            })
            ->whereNull('item_penempatan_barangs.id_item_barang')
            ->where('item_barangs.status', '=', 1)
            ->select('item_barangs.*')
            ->get();

        return view('sa.content.penempatan-barang.edit', compact('title', 'penempatanBarang', 'ruangan', 'itemBarang'));
    }

    public function update(Request $request, $id_penempatan_barang)
    {
        $request->validate([
            'id_ruangan'    => 'required',
            'keterangan'           => 'nullable',
        ], [
            'id_ruangan.required'       => 'Ruangan harus dipilih',
        ]);

        $penempatanBarang = PenempatanBarang::findOrFail($id_penempatan_barang);
        $created = $penempatanBarang->created_by;

        $penempatanBarang->kode_penempatan_barang = $request->kode_penempatan_barang;
        $penempatanBarang->id_ruangan = $request->id_ruangan;
        $penempatanBarang->tanggal   = $request->tanggal;
        $penempatanBarang->keterangan = $request->keterangan;
        $penempatanBarang->created_by = $created;
        $penempatanBarang->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

        try {
            $penempatanBarang->save();
            return redirect(route('superadmin.penempatan_barang.index'))->with('success', 'Penempatan barang berhasil diubah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.penempatan_barang.index'))->with('error', 'Penempatan barang gagal diubah!');
        }
    }
}
