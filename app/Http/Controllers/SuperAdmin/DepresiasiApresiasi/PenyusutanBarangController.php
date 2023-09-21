<?php

namespace App\Http\Controllers\SuperAdmin\DepresiasiApresiasi;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use Illuminate\Http\Request;

class PenyusutanBarangController extends Controller
{
    public function index()
    {
        $title = 'Penyusutan Nilai Aset Barang ';

        // Mengambil semua data bangunan
        $barangs = ItemBarang::where('status', 1)->get();
        foreach ($barangs as $bangunan) {
            $hargaPerolehan = $bangunan->harga_perolehan;
            $umurManfaat = $bangunan->umur_manfaat;
            $nilaiResidu = $bangunan->nilai_residu;

            // Menghitung nilai penyusutan tahunan
            $penyusutanTahunan = ($hargaPerolehan - $nilaiResidu) / $umurManfaat;

            // Menyimpan nilai penyusutan tahunan ke kolom 'nilai_penyusutan'
            $bangunan->nilai_penyusutan = $penyusutanTahunan;

            // Mengakses atribut 'tahun_penggunaan' dari model
            $tahunPenggunaan = $bangunan->tahun_penggunaan;

            // Menyimpan perubahan pada model
            $bangunan->save();
        }

        return view('sa.content.penyusutan-barang.list', compact('title', 'barangs'));
    }


    public function detail($id_item_barang)
    {
        $title = 'Detail Penyusutan Nilai Aset Barang ';
        $barang = ItemBarang::findOrFail($id_item_barang);
        $hargaPerolehan = $barang->harga_perolehan;
        $umurManfaat = $barang->umur_manfaat;
        $nilaiResidu = $barang->nilai_residu;

        // Menghitung nilai penyusutan tahunan
        $penyusutanTahunan = ($hargaPerolehan - $nilaiResidu) / $umurManfaat;

        // Menghitung nilai aset pertahun
        $nilaiAsetPertahun = [];
        $tahunSekarang = date('Y');
        $tahunPengadaan = date('Y', strtotime($barang->tanggal_pengadaan));

        for ($i = 0; $i <= $umurManfaat; $i++) {
            $tahun = $tahunPengadaan + $i;
            $jumlahTahunBerlalu = $tahun - $tahunPengadaan;

            // Periksa jika sudah mencapai tahun terakhir umur manfaat
            if ($jumlahTahunBerlalu >= $umurManfaat) {
                $nilaiAset = $nilaiResidu; // Set nilai aset sama dengan nilai residu
            } else {
                $nilaiAset = $hargaPerolehan - ($penyusutanTahunan * $jumlahTahunBerlalu);
            }

            $nilaiAsetPertahun[$tahun] = $nilaiAset;
        }

        return view('sa.content.penyusutan-barang.detail', compact('barang', 'nilaiAsetPertahun', 'title'));
    }
}
