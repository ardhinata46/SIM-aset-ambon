<?php

namespace App\Exports;

use App\Models\PengadaanTanah;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengadaanTanahExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $lokasi;
    protected $sumber;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($lokasi, $sumber, $tanggal_awal, $tanggal_akhir)
    {
        $this->lokasi = $lokasi;
        $this->sumber = $sumber;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {
        $query = PengadaanTanah::query()
            ->select(
                'pengadaan_tanahs.kode_pengadaan_tanah',
                'pengadaan_tanahs.kode_tanah',
                'pengadaan_tanahs.nama_tanah',
                'pengadaan_tanahs.lokasi',
                'pengadaan_tanahs.tanggal_pengadaan',
                'pengadaan_tanahs.sumber',
                'pengadaan_tanahs.harga_perolehan',
                'pengadaan_tanahs.luas',
                'pengadaan_tanahs.keterangan',
            );

        if ($this->lokasi) {
            $query->where('pengadaan_tanahs.lokasi', 'like', '%' . $this->lokasi . '%');
        }
        if ($this->sumber) {
            $query->where('pengadaan_tanahs.sumber', $this->sumber);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('pengadaan_tanahs.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('pengadaan_tanahs.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }
    public function map($pengadaanTanah): array
    {

        if ($pengadaanTanah->sumber === 'pembelian') {
            $sumber = 'Pembelian';
        } elseif ($pengadaanTanah->sumber === 'hibah') {
            $sumber = 'Hibah';
        }
        return [
            $pengadaanTanah->kode_pengadaan_tanah,
            $pengadaanTanah->kode_tanah,
            $pengadaanTanah->nama_tanah,
            $pengadaanTanah->lokasi,
            $sumber,
            $pengadaanTanah->luas,
            $pengadaanTanah->tanggal_pengadaan,
            $pengadaanTanah->harga_perolehan,
            $pengadaanTanah->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            'KODE PENGADAAN TANAH',
            'KODE TANAH',
            'NAMA TANAH',
            'LOKASI',
            'SUMBER ASET',
            'LUAS TANAH',
            'TANGGAL PENGADAAN',
            'HARGA PEROLEHAN',
            'KETERANGAN'
        ];
    }
}
