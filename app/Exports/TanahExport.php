<?php

namespace App\Exports;

use App\Models\Tanah;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TanahExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $lokasi;
    protected $sumber;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    // Constructor untuk menerima data filter dari form
    public function __construct($lokasi, $sumber, $tanggal_awal, $tanggal_akhir)
    {
        $this->lokasi = $lokasi;
        $this->sumber = $sumber;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    // Implementasi fungsi query() dengan filter
    public function query()
    {
        $query = Tanah::query()
            ->select(
                'tanahs.kode_tanah',
                'tanahs.nama_tanah',
                'tanahs.lokasi',
                'tanahs.sumber',
                'tanahs.luas',
                'tanahs.tanggal_pengadaan',
                'tanahs.harga_perolehan',
                'tanahs.keterangan',
            )
            ->where('tanahs.status', 1);;

        // Lakukan filter berdasarkan data dari form
        if ($this->lokasi) {
            $query->where('lokasi', 'like', '%' . $this->lokasi . '%');
        }

        if ($this->sumber) {
            $query->where('sumber', $this->sumber);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }

    public function map($tanah): array
    {
        if ($tanah->sumber === 'pembelian') {
            $sumber = 'Pembelian';
        } elseif ($tanah->sumber === 'hibah') {
            $sumber = 'Hibah';
        }

        return [
            $tanah->kode_tanah,
            $tanah->nama_tanah,
            $tanah->lokasi,
            $sumber,
            $tanah->luas,
            $tanah->tanggal_pengadaan,
            $tanah->harga_perolehan,
            $tanah->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
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
