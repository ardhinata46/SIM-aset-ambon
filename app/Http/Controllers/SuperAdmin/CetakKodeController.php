<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class CetakKodeController extends Controller
{
    public function index()
    {
        $title = 'Cetak Kode QR Code';

        $ruangan = Ruangan::select(
            'ruangans.id_ruangan',
            'ruangans.kode_ruangan',
            'ruangans.nama_ruangan',
            'bangunans.nama_bangunan as nama'
        )
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'ruangans.id_bangunan')
            ->orderBy('ruangans.id_ruangan', 'ASC')->get();

        $barang = Barang::all();
        $itemBarang = ItemBarang::select(
            'item_barangs.id_item_barang',
            'item_barangs.kode_item_barang',
            'item_barangs.nama_item_barang',
            'item_barangs.id_item_barang',
            'ruangans.nama_ruangan'
        )
            ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->orderBy('item_barangs.id_item_barang', 'ASC')
            ->get();

        return view('sa.content.cetak-kode.index', compact('title', 'ruangan', 'itemBarang', 'barang'));
    }

    public function itemBarang(Request $request)
    {
        $title = 'Cetak Kode';
        $id_barang = $request->id_barang;

        $itemBarang = ItemBarang::select(
            'item_barangs.id_item_barang',
            'item_barangs.nama_item_barang'
        )
            ->where('id_barang', $id_barang)->get();

        return view('sa.content.cetak-kode.itemBarang', compact('title', 'itemBarang'));
    }

    public function perItemBarang($id_item_barang)
    {
        $title = 'Cetak Kode';

        $itemBarang = ItemBarang::select(
            'item_barangs.id_item_barang',
            'item_barangs.nama_item_barang'
        )
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->first();

        return view('sa.content.cetak-kode.perItemBarang', compact('title', 'itemBarang'));
    }

    public function ruangan()
    {
        $title = 'Cetak Kode';

        $ruangan = Ruangan::select(
            'ruangans.id_ruangan',
            'ruangans.nama_ruangan'
        )
            ->get();

        return view('sa.content.cetak-kode.ruangan', compact('title', 'ruangan'));
    }

    public function perRuangan($id_ruangan)
    {
        $title = 'Cetak Kode';

        $ruangan = Ruangan::select('ruangans.*', 'bangunans.nama_bangunan as nama')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'ruangans.id_bangunan')
            ->where('id_ruangan', $id_ruangan)
            ->get()
            ->first();
        return view('sa.content.cetak-kode.perRuangan', compact('title', 'ruangan'));
    }
}
