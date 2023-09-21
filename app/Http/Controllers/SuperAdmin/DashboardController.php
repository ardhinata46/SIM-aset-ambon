<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\KategoriBarang;
use App\Models\PeminjamanBarang;
use App\Models\PengadaanBangunan;
use App\Models\PengadaanTanah;
use App\Models\Pengguna;
use App\Models\Ruangan;
use App\Models\Tanah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        $title = 'Dashboard SuperAdmin';

        $now = Carbon::now();

        //hitung aset aktif
        $jumlahTanah = Tanah::where('status', 1)->get()->count();
        $jumlahBangunan = Bangunan::where('status', 1)->get()->count();
        $jumlahItemBarang = ItemBarang::where('status', 1)->get()->count();

        //hitung aset non-aktif
        $jumlahTanahNonAktif = Tanah::where('status', 0)->get()->count();
        $jumlahBangunanNonAktif = Bangunan::where('status', 0)->get()->count();
        $jumlahItemBarangNonAktif = ItemBarang::where('status', 0)->get()->count();

        //Hitung pengguna aktif
        $jumlahPengguna = Pengguna::where('status', 1)->get()->count();

        //hitung jumlah kategori, barang dan ruangan
        $jumlahKategoriBarang = KategoriBarang::count();
        $jumlahBarang = Barang::count();
        $ruangan = Ruangan::count();

        //hitung barang rusak ringan dan rusak berat
        $barangBaik = ItemBarang::where('kondisi', 'baik')->where('status', 1)->count();
        $barangRusakRingan = ItemBarang::where('kondisi', 'rusak_ringan')->where('status', 1)->count();
        $barangRusakBerat = ItemBarang::where('kondisi', 'rusak_berat')->where('status', 1)->count();

        $pengadaanTanah = PengadaanTanah::count();
        $pengadaanBangunan = PengadaanBangunan::count();

        //hitung total  jumlah keseluruhan aset aktif
        $totalAsetAktif = $jumlahTanah + $jumlahBangunan + $jumlahItemBarang;

        //hitung total  jumlah keseluruhan aset non aktif
        $totalAsetNonAktif = $jumlahTanahNonAktif + $jumlahBangunanNonAktif + $jumlahItemBarangNonAktif;

        // Menghitung total kekayaan
        $totalKekayaan = 0;

        // Menghitung total harga perolehan tanah
        $totalHargaPerolehanTanah = Tanah::where('status', 1)->sum('harga_perolehan');
        $totalKekayaan += $totalHargaPerolehanTanah;

        $totalKekayaan = 0;
        $barangs = ItemBarang::where('status', 1)->get();
        foreach ($barangs as $barang) {
            $hargaPerolehan = $barang->harga_perolehan;
            $umurManfaat = $barang->umur_manfaat;
            $nilaiResidu = $barang->nilai_residu;

            $tahunSekarang = date('Y');
            $jumlahTahunBerlalu = $tahunSekarang - date('Y', strtotime($barang->tanggal_pengadaan));

            $nilaiAsetTahunIni = $hargaPerolehan - ($barang->nilai_penyusutan * $jumlahTahunBerlalu);
            if ($nilaiAsetTahunIni < 0) {
                $nilaiAsetTahunIni = 0;
            }
            $totalKekayaan += $nilaiAsetTahunIni;
        }


        $bangunans = Bangunan::where('status', 1)->get();
        foreach ($bangunans as $bangunan) {
            $hargaPerolehan = $bangunan->harga_perolehan;
            $nilaiPenyusutan = $bangunan->nilai_penyusutan;

            $tahunSekarang = date('Y');
            $jumlahTahunBerlalu = $tahunSekarang - date('Y', strtotime($bangunan->tanggal_pengadaan));

            $nilaiAsetTahunIni = $hargaPerolehan - ($nilaiPenyusutan * $jumlahTahunBerlalu);
            if ($nilaiAsetTahunIni < 0) {
                $nilaiAsetTahunIni = 0;
            }

            $totalKekayaan += $nilaiAsetTahunIni;
        }


        //untuk chart kondisi barang
        $baik = ItemBarang::where('kondisi', 'baik')->where('status', 1)->get()->count();
        $rusakRingan = ItemBarang::where('kondisi', 'rusak_ringan')->where('status', 1)->get()->count();
        $rusakBerat = ItemBarang::where('kondisi', 'rusak_berat')->where('status', 1)->get()->count();

        //peminjaman berstatus dipinjam
        $peminjaman = PeminjamanBarang::where('status', 0)->count();


        return view('sa.content.dashboard', compact(
            'title',
            'jumlahPengguna',
            'jumlahKategoriBarang',
            'jumlahBarang',
            'jumlahTanah',
            'jumlahItemBarang',
            'ruangan',
            'jumlahBangunan',
            'barangBaik',
            'barangRusakBerat',
            'barangRusakRingan',
            'pengadaanTanah',
            'pengadaanBangunan',
            'totalKekayaan',
            'totalAsetAktif',
            'totalAsetNonAktif',
            'peminjaman',

        ));
    }
}
