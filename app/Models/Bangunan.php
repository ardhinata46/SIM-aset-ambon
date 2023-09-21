<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bangunan extends Model
{
    use HasFactory;
    protected $table = "bangunans";
    protected $primaryKey = "id_bangunan";
    protected $fillable = [
        'id_tanah',
        'kode_bangunan',
        'nama_bangunan',
        'lokasi',
        'kondisi',
        'deskripsi',
        'tanggal_pengadaan',
        'sumber',
        'harga_perolehan',
        'umur_manfaat',
        'nilai_residu',
        'nilai_penyusutan',
        'keterangan',
        'status',
        'created_by',
        'updated_by'
    ];

    public static function generateKodeBangunan()
    {
        $lastBangunan = self::orderBy('id_bangunan', 'desc')->first();

        $nextBangunanNumber = 1;
        if ($lastBangunan) {
            $lastBangunanNumber = (int) substr($lastBangunan->kode_bangunan, 9);
            $nextBangunanNumber = $lastBangunanNumber + 1;
        }

        return 'BANGUNAN-' . str_pad($nextBangunanNumber, 5, '0', STR_PAD_LEFT);
    }

    protected $appends = ['tahun_penggunaan', 'nilai_aset_tahun_ini'];

    public function getTahunPenggunaanAttribute()
    {
        $tahunSaatIni = date('Y');
        $tanggalPengadaan = $this->tanggal_pengadaan;
        $tahunPenggunaan = $tahunSaatIni - date('Y', strtotime($tanggalPengadaan));
        return $tahunPenggunaan;
    }

    public function getNilaiAsetTahunIniAttribute()
    {
        $hargaPerolehan = $this->harga_perolehan;
        $umurManfaat = $this->umur_manfaat;
        $nilaiResidu = $this->nilai_residu;


        $tahunSekarang = date('Y');

        // hitung tanan berlalu (pemakain)
        $jumlahTahunBerlalu = $tahunSekarang - date('Y', strtotime($this->tanggal_pengadaan));

        // rumus Metode garis lurus
        $penyusutanTahunan = ($hargaPerolehan - $nilaiResidu) / $umurManfaat;

        // jika umur manfaat habis, gunakan nilai residu sebagai nilai aset
        if ($jumlahTahunBerlalu >= $umurManfaat) {
            $nilaiAsetTahunIni = $nilaiResidu;
        } else {
            // hitung nilai dari aset tahun sekarang: harga perolehan - (penyusutan tahunan * jumlah tahun berlalu)
            $nilaiAsetTahunIni = $hargaPerolehan - ($penyusutanTahunan * $jumlahTahunBerlalu);
        }

        // Jika nilai aset tahun ini negatif, ubah menjadi 0
        if ($nilaiAsetTahunIni < 0) {
            $nilaiAsetTahunIni = 0;
        }

        // Mengembalikan nilai aset tahun ini
        return $nilaiAsetTahunIni;
    }

    public function penghapusanBangunan()
    {
        return $this->hasOne(PenghapusanBangunan::class, 'id_bangunan');
    }
}
