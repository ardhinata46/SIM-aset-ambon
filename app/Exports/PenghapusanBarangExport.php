<?php

namespace App\Exports;

use App\Models\PenghapusanBarang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenghapusanBarangExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $tindakan;
    protected $alasan;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($alasan, $tindakan, $tanggal_awal, $tanggal_akhir)
    {
        $this->tindakan = $tindakan;
        $this->alasan = $alasan;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {
        $query  = PenghapusanBarang::query()->select("penghapusan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'penghapusan_barangs.id_item_barang')
            ->latest();

        if ($this->tindakan) {
            $query->where('penghapusan_barangs.tindakan', $this->tindakan);
        }
        if ($this->alasan) {
            $query->where('penghapusan_barangs.alasan', $this->alasan);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('penghapusan_barangs.tanggal', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('penghapusan_barangs.tanggal', '<=', $this->tanggal_akhir);
        }

        return $query;
    }

    public function map($penghapusanBarang): array
    {
        if ($penghapusanBarang->tindakan === 'jual') {
            $tindakan = 'Dijual';
        } elseif ($penghapusanBarang->tindakan === 'hibah') {
            $tindakan = 'Dihibahkan';
        } elseif ($penghapusanBarang->tindakan === 'dihanguskan') {
            $tindakan = 'Dihanguskan';
        }

        if ($penghapusanBarang->alasan === 'rusak') {
            $alasan = 'Rusak';
        } elseif ($penghapusanBarang->alasan === 'hilang') {
            $alasan = 'Hilang';
        } elseif ($penghapusanBarang->alasan === 'tidak_digunakan') {
            $alasan = 'Tidak Digunakan';
        }

        return [
            $penghapusanBarang->kode_penghapusan_barang,
            $penghapusanBarang->barang,
            $penghapusanBarang->tanggal,
            $tindakan,
            $alasan,
            $penghapusanBarang->harga,
            $penghapusanBarang->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Penghapusan Barang',
            'Nama Barang',
            'Tanggal Penghapusan',
            'Tindakan Penghapusan',
            'Alasan Penghapusan',
            'Harga',
            'Keterangan'

        ];
    }
}
