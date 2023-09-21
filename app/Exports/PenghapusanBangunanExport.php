<?php

namespace App\Exports;

use App\Models\PenghapusanBangunan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenghapusanBangunanExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $tindakan;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($tindakan, $tanggal_awal, $tanggal_akhir)
    {
        $this->tindakan = $tindakan;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {

        $query = PenghapusanBangunan::query()->select("penghapusan_bangunans.*", 'bangunans.nama_bangunan as bangunan')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'penghapusan_bangunans.id_bangunan')
            ->latest();

        if ($this->tindakan) {
            $query->where('penghapusan_bangunans.tindakan', $this->tindakan);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('penghapusan_bangunans.tanggal', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('penghapusan_bangunans.tanggal', '<=', $this->tanggal_akhir);
        }

        return $query;
    }
    public function map($penghapusanBangunan): array
    {

        if ($penghapusanBangunan->tindakan === 'jual') {
            $tindakan = 'Dijual';
        } elseif ($penghapusanBangunan->tindakan === 'hibah') {
            $tindakan = 'Dihibahkan';
        } elseif ($penghapusanBangunan->tindakan === 'dihanguskan') {
            $tindakan = 'Dihanguskan';
        }

        return [
            $penghapusanBangunan->kode_penghapusan_bangunan,
            $penghapusanBangunan->bangunan,
            $penghapusanBangunan->tanggal,
            $tindakan,
            $penghapusanBangunan->harga,
            $penghapusanBangunan->keterangan,
        ];
    }


    public function headings(): array
    {
        return [
            'Kode Penghapusan Banngunan',
            'Nama Bangunan',
            'Tanggal Penghapusan',
            'Tindakan Penghapusan',
            'Harga',
            'Keterangan'

        ];
    }
}
