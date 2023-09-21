<?php

namespace App\Exports;

use App\Models\PengadaanBarang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengadaanBarangExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $sumber;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($sumber, $tanggal_awal, $tanggal_akhir)
    {
        $this->sumber = $sumber;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {
        $query = PengadaanBarang::query();

        if ($this->sumber) {
            $query->where('pengadaan_barangs.sumber', $this->sumber);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('pengadaan_barangs.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('pengadaan_barangs.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }
    public function map($pengadaanBarang): array
    {
        if ($pengadaanBarang->sumber === 'pembelian') {
            $sumber = 'Pembelian';
        } elseif ($pengadaanBarang->sumber === 'hibah') {
            $sumber = 'Hibah';
        }
        return [
            $pengadaanBarang->kode_pengadaan_barang,
            $pengadaanBarang->tanggal_pengadaan,
            $sumber,
            $pengadaanBarang->keterangan
        ];
    }

    public function headings(): array
    {
        return [
            'KODE PENGADAAN BARANG',
            'TANGGAL PENGADAAN',
            'SUMBER ASET',
            'KETERANGAN'
        ];
    }
}
