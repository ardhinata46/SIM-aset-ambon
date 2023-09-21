<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CetakKodeController extends Controller
{
    public function index()
    {
        $title = 'Cetak Kode';

        $barang = Barang::all();
        $itemBarang = ItemBarang::select('item_barangs.*', 'ruangans.nama_ruangan')
            ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->latest()
            ->get();

        return view('admin.content.cetak-kode.index', compact('title', 'itemBarang', 'barang'));
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

        return view('admin.content.cetak-kode.itemBarang', compact('title', 'itemBarang'));
    }


    // public function itemBarang()
    // {
    //     $title = 'Cetak Kode';

    //     $itemBarang = ItemBarang::select('item_barangs.*', 'ruangans.nama_ruangan', 'bangunans.nama_bangunan')
    //         ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
    //         ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
    //         ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
    //         ->leftJoin('bangunans', 'ruangans.id_bangunan', '=', 'bangunans.id_bangunan')
    //         ->orderBy('kode_item_barang', 'ASC')
    //         ->get();
    //     $itemBarang = ItemBarang::select('item_barangs.*', 'ruangans.nama_ruangan', 'bangunans.nama_bangunan')
    //         ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
    //         ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
    //         ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
    //         ->leftJoin('bangunans', 'ruangans.id_bangunan', '=', 'bangunans.id_bangunan')
    //         ->orderBy('kode_item_barang', 'ASC')
    //         ->get();

    //     return view('admin.content.cetak-kode.itemBarang', compact('title', 'itemBarang'));
    // }

    public function perItemBarang($id_item_barang)
    {
        $title = 'Cetak Kode';

        $itemBarang = ItemBarang::select(
            'item_barangs.id_item_barang',
            'item_barangs.nama_item_barang'
        )
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->first();

        return view('admin.content.cetak-kode.perItemBarang', compact('title', 'itemBarang'));
    }

    public function perBarang(Request $request, $id_barang)
    {
        $title = 'Cetak Kode';
        $barang = $request->id_barang;
        $itemBarang = ItemBarang::select(
            'item_barangs.id_item_barang',
            'item_barangs.nama_item_barang'
        )
            ->where('item_barangs.id_barang', $barang)
            ->get();

        return view('admin.content.cetak-kode.perBarang', compact('title', 'itemBarang'));
    }
}
