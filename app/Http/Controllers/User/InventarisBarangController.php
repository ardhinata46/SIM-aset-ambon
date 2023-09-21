<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ItemBarang;

class InventarisBarangController extends Controller
{

    public function info($id_item_barang)
    {
        $title = "Detail Item Barang ";
        $detail = ItemBarang::select('item_barangs.*', 'ruangans.nama_ruangan', 'barangs.kode_barang as kode_barang', 'barangs.nama_barang as nama_barang', 'bangunans.nama_bangunan')
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->leftJoin('item_penempatan_barangs', 'item_barangs.id_item_barang', '=', 'item_penempatan_barangs.id_item_barang')
            ->leftJoin('penempatan_barangs', 'item_penempatan_barangs.id_penempatan_barang', '=', 'penempatan_barangs.id_penempatan_barang')
            ->leftJoin('ruangans', 'penempatan_barangs.id_ruangan', '=', 'ruangans.id_ruangan')
            ->leftJoin('ruangans as r', 'r.id_ruangan', '=', 'ruangans.id_ruangan')
            ->leftJoin('bangunans', 'bangunans.id_bangunan', '=', 'r.id_bangunan')
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->first();

        return view('user.data', compact('title', 'detail'));
    }
}
