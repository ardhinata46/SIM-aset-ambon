<?php

namespace App\Exports;

use App\Models\PenghapusanTanah;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenghapusanTanahExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
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

        $query = PenghapusanTanah::query()->select("penghapusan_tanahs.*", 'tanahs.nama_tanah as tanah')
            ->join(
                'tanahs',
                'tanahs.id_tanah',
                '=',
                'penghapusan_tanahs.id_tanah'
            )
            ->latest();

        if ($this->tindakan) {
            $query->where('penghapusan_tanahs.tindakan', $this->tindakan);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('penghapusan_tanahs.tanggal', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('penghapusan_tanahs.tanggal', '<=', $this->tanggal_akhir);
        }

        return $query;
    }
    public function map($penghapusanTanah): array
    {

        if ($penghapusanTanah->tindakan === 'jual') {
            $tindakan = 'Dijual';
        } elseif ($penghapusanTanah->tindakan === 'hibah') {
            $tindakan = 'Dihibahkan';
        } elseif ($penghapusanTanah->tindakan === 'dihanguskan') {
            $tindakan = 'Dihanguskan';
        }

        return [
            $penghapusanTanah->kode_penghapusan_tanah,
            $penghapusanTanah->tanah,
            $penghapusanTanah->tanggal,
            $tindakan,
            $penghapusanTanah->harga,
            $penghapusanTanah->keterangan,
        ];
    }


    public function headings(): array
    {
        return [
            'Kode Penghapusan Tanah',
            'Nama Tanah',
            'Tanggal Penghapusan',
            'Tindakan Penghapusan',
            'Harga',
            'Keterangan'

        ];
    }
}
