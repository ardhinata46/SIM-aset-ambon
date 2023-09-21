<?php

namespace App\Exports;

use App\Models\Bangunan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BangunanExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $kondisi;
    protected $id_tanah;
    protected $sumber;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    // Constructor untuk menerima data filter dari form
    public function __construct($kondisi, $id_tanah, $sumber, $tanggal_awal, $tanggal_akhir)
    {
        $this->kondisi = $kondisi;
        $this->id_tanah = $id_tanah;
        $this->sumber = $sumber;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {
        $query = Bangunan::query()
            ->select(
                'tanahs.nama_tanah',
                'bangunans.kode_bangunan',
                'bangunans.nama_bangunan',
                'bangunans.deskripsi',
                'bangunans.harga_perolehan',
                'bangunans.kondisi',
                'bangunans.id_tanah',
                'bangunans.lokasi',
                'bangunans.sumber',
                'bangunans.tanggal_pengadaan',
                'bangunans.keterangan'
            )
            ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
            ->where('bangunans.status', '=', 1);

        // Lakukan filter berdasarkan data dari form

        if ($this->kondisi) {
            $query->where('bangunans.kondisi', $this->kondisi);
        }
        if ($this->id_tanah) {
            $query->where('bangunans.id_tanah', $this->id_tanah);
        }
        if ($this->sumber) {
            $query->where('bangunans.sumber', $this->sumber);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('bangunans.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('bangunans.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }


    public function map($bangunan): array
    {
        if ($bangunan->sumber === 'pembangunan') {
            $sumber = 'Pembangunan';
        } elseif ($bangunan->sumber === 'pembelian') {
            $sumber = 'Pembelian';
        } elseif ($bangunan->sumber === 'hibah') {
            $sumber = 'Hibah';
        }

        if ($bangunan->kondisi === 'baik') {
            $kondisi = 'Baik';
        } elseif ($bangunan->kondisi === 'rusak_ringan') {
            $kondisi = 'Rusak Ringan';
        } elseif ($bangunan->kondisi === 'rusak_berat') {
            $kondisi = 'Rusak Berat';
        }

        return [
            $bangunan->nama_tanah,
            $bangunan->lokasi,
            $bangunan->kode_bangunan,
            $bangunan->nama_bangunan,
            $bangunan->deskripsi,
            $kondisi,
            $bangunan->tanggal_pengadaan,
            $sumber,
            $bangunan->harga_perolehan,
            $bangunan->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            'TANAH',
            'LOKASI',
            'KODE BANGUNAN',
            'NAMA BANGUNAN',
            'DESKRIPSI BANGUNAN',
            'KONDISI',
            'TANGGAL PENGADAAN',
            'SUMBER ASET',
            'HARGA PEROLEHAN',
            'KETERANGAN'

        ];
    }
}
