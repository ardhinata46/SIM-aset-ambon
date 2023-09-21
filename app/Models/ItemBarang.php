<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBarang extends Model
{
    use HasFactory;
    protected $table = "item_barangs";
    protected $primaryKey = "id_item_barang";
    protected $fillable = [
        'id_barang',
        'kode_item_barang',
        'nama_item_barang',
        'merk',
        'kondisi',
        'sumber',
        'tanggal_pengadaan',
        'harga_perolehan',
        'umur_manfaat',
        'nilai_residu',
        'nilai_penyusutan',
        'keterangan',
        'status',
        'created_by',
        'updated_by'
    ];

    public static function generateKodeItemBarang()
    {
        $lastItemBarang = self::orderBy('id_item_barang', 'desc')->first();

        $nextItemBarangNumber = 1;
        if ($lastItemBarang) {
            $lastItemBarangNumber = (int) substr($lastItemBarang->kode_item_barang, 14);
            $nextItemBarangNumber = $lastItemBarangNumber + 1;
        }

        return 'ITEM-BARANG-' . str_pad($nextItemBarangNumber, 5, '0', STR_PAD_LEFT);
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

        // Ambil tahun pengadaan
        $tahunPengadaan = date('Y', strtotime($this->tanggal_pengadaan));

        // Hitung tahun sekarang
        $tahunSekarang = date('Y');

        // Hitung tahun berlalu (pemakaian) mulai dari tahun pengadaan
        $jumlahTahunBerlalu = $tahunSekarang - $tahunPengadaan;

        // Rumus Metode garis lurus
        $penyusutanTahunan = ($hargaPerolehan - $nilaiResidu) / $umurManfaat;

        // Jika umur manfaat habis, gunakan nilai residu sebagai nilai aset
        if ($jumlahTahunBerlalu >= $umurManfaat) {
            $nilaiAsetTahunIni = $nilaiResidu;
        } else {
            // Hitung nilai dari aset tahun sekarang: harga perolehan - (penyusutan tahunan * jumlah tahun berlalu)
            $nilaiAsetTahunIni = $hargaPerolehan - ($penyusutanTahunan * $jumlahTahunBerlalu);
        }

        // Jika nilai aset tahun ini negatif, ubah menjadi 0
        if ($nilaiAsetTahunIni < 0) {
            $nilaiAsetTahunIni = 0;
        }

        // Mengembalikan nilai aset tahun ini
        return $nilaiAsetTahunIni;
    }


    public function penghapusanBarang()
    {
        return $this->hasOne(PenghapusanBarang::class, 'id_item_barang');
    }
}
