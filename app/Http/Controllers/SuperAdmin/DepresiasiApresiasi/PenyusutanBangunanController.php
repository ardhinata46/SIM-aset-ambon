<?php

namespace App\Http\Controllers\SuperAdmin\DepresiasiApresiasi;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use Illuminate\Http\Request;

class PenyusutanBangunanController extends Controller
{
    public function index()
    {
        $title = 'Penyusutan Nilai Aset bangunan';

        // Mengambil semua data bangunan
        $bangunans = Bangunan::where('status', 1)->get();
        foreach ($bangunans as $bangunan) {
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

        return view('sa.content.penyusutan-bangunan.list', compact('title', 'bangunans'));
    }

    public function detail($id_bangunan)
    {
        $title = 'Detail Penyusutan Nilai Aset bangunan';
        $bangunan = Bangunan::findOrFail($id_bangunan);
        $hargaPerolehan = $bangunan->harga_perolehan;
        $umurManfaat = $bangunan->umur_manfaat;
        $nilaiResidu = $bangunan->nilai_residu;

        // Menghitung nilai penyusutan tahunan
        $penyusutanTahunan = ($hargaPerolehan - $nilaiResidu) / $umurManfaat;

        // Menghitung nilai aset pertahun
        $nilaiAsetPertahun = [];
        $tahunSekarang = date('Y');
        $tahunPengadaan = date('Y', strtotime($bangunan->tanggal_pengadaan));

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

        return view('sa.content.penyusutan-bangunan.detail', compact('bangunan', 'nilaiAsetPertahun', 'title'));
    }
}
