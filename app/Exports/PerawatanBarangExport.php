<?php

namespace App\Exports;

use App\Models\PerawatanBarang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PerawatanBarangExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    use Exportable;

    protected $id_item_barang;
    protected $kondisi;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($id_item_barang, $kondisi, $tanggal_awal, $tanggal_akhir)
    {
        $this->id_item_barang = $id_item_barang;
        $this->kondisi = $kondisi;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {

        $query = PerawatanBarang::query()->select("perawatan_barangs.*", 'item_barangs.kode_item_barang', 'item_barangs.nama_item_barang')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'perawatan_barangs.id_item_barang')
            ->latest();

        if ($this->id_item_barang) {
            $query->where('perawatan_barangs.id_item_barang', $this->id_item_barang);
        }

        if ($this->kondisi) {
            $query->where('perawatan_barangs.kondisi_sesudah', $this->kondisi);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('perawatan_barangs.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('perawatan_barangs.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }


        return $query;
    }
    public function map($PerawatanBarang): array
    {
        if ($PerawatanBarang->kondisi_sesudah === 'baik') {
            $kondisi = 'Baik';
        } elseif ($PerawatanBarang->kondisi_sesudah === 'rusak_ringan') {
            $kondisi = 'Rusak Ringan';
        } elseif ($PerawatanBarang->kondisi_sesudah === 'rusak_berat') {
            $kondisi = 'Rusak Berat';
        }


        return [
            $PerawatanBarang->kode_perawatan_barang,
            $PerawatanBarang->kode_item_barang,
            $PerawatanBarang->nama_item_barang,
            $PerawatanBarang->tanggal_perawatan,
            $kondisi,
            $PerawatanBarang->deskripsi,
            $PerawatanBarang->biaya,
            $PerawatanBarang->keterangan,
        ];
    }


    public function headings(): array
    {
        return [
            'Kode Perawatan Barang',
            'Kode Item Barang',
            'Nama Item Barang',
            'Tanggal Perawatan',
            'Kondisi Setelah Perawatan',
            'Deskripsi',
            'Biaya',
            'Keterangan'

        ];
    }
}
