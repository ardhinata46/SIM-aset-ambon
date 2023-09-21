<?php

namespace App\Exports;

use App\Models\PerawatanBangunan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PerawatanBangunanExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $id_bangunan;
    protected $kondisi;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($id_bangunan, $kondisi, $tanggal_awal, $tanggal_akhir)
    {
        $this->id_bangunan = $id_bangunan;
        $this->kondisi = $kondisi;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {

        $query = PerawatanBangunan::query()->select("perawatan_bangunans.*", 'bangunans.nama_bangunan')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'perawatan_bangunans.id_bangunan')
            ->latest();

        if ($this->id_bangunan) {
            $query->where('perawatan_bangunans.id_bangunan', $this->id_bangunan);
        }

        if ($this->kondisi) {
            $query->where('perawatan_bangunans.kondisi_sesudah', $this->kondisi);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('perawatan_bangunans.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('perawatan_bangunans.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }


        return $query;
    }
    public function map($perawatanBangunan): array
    {
        if ($perawatanBangunan->kondisi_sesudah === 'baik') {
            $kondisi = 'Baik';
        } elseif ($perawatanBangunan->kondisi_sesudah === 'rusak_ringan') {
            $kondisi = 'Rusak Ringan';
        } elseif ($perawatanBangunan->kondisi_sesudah === 'rusak_berat') {
            $kondisi = 'Rusak Berat';
        }

        return [
            $perawatanBangunan->kode_perawatan_bangunan,
            $perawatanBangunan->nama_bangunan,
            $perawatanBangunan->tanggal_perawatan,
            $kondisi,
            $perawatanBangunan->deskripsi,
            $perawatanBangunan->biaya,
            $perawatanBangunan->keterangan,
        ];
    }


    public function headings(): array
    {
        return [
            'Kode Perawatan Bangunan',
            'nama Bangunan',
            'Tanggal Perawatan',
            'Kondisi Setelah Perawatan',
            'Deskripsi',
            'Biaya',
            'Keterangan'

        ];
    }
}
