<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemBarang;
use App\Models\KategoriBarang;
use App\Models\PeminjamanBarang;
use App\Models\PerawatanBarang;
use App\Models\Tanah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        $title = 'Dashboard Admin';

        $jumlahItemBarangNonAktif = ItemBarang::where('status', 0)->get()->count();
        $jumlahKategoriBarang = KategoriBarang::count();
        //untuk chart kondisi barang
        $baik = ItemBarang::where('kondisi', 'baik')->where('status', 1)->get()->count();
        $rusakRingan = ItemBarang::where('kondisi', 'rusak_ringan')->where('status', 1)->get()->count();
        $rusakBerat = ItemBarang::where('kondisi', 'rusak_berat')->where('status', 1)->get()->count();

        //hitung barang rusak ringan dan rusak berat
        $barangBaik = ItemBarang::where('kondisi', 'baik')->where('status', 1)->count();
        $barangRusakRingan = ItemBarang::where('kondisi', 'rusak_ringan')->where('status', 1)->count();
        $barangRusakBerat = ItemBarang::where('kondisi', 'rusak_berat')->where('status', 1)->count();

        //peminjaman berstatus dipinjam
        $peminjaman = PeminjamanBarang::where('status', 0)->count();

        //perawatan barang
        $perawatanBarang = PerawatanBarang::count();

        return view('admin.content.dashboard', compact(
            'title',
            'jumlahKategoriBarang',
            'jumlahItemBarangNonAktif',
            'barangBaik',
            'barangRusakRingan',
            'barangRusakBerat',
            'peminjaman',
            'perawatanBarang'

        ));
    }
}
