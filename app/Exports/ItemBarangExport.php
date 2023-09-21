<?php

namespace App\Exports;

use App\Models\ItemBarang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemBarangExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $id_barang;
    protected $kondisi;
    protected $sumber;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($id_barang, $kondisi, $sumber, $tanggal_awal, $tanggal_akhir)
    {
        $this->id_barang = $id_barang;
        $this->kondisi = $kondisi;
        $this->sumber = $sumber;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {
        $query = ItemBarang::query()
            ->select(
                'item_barangs.kode_item_barang',
                'item_barangs.nama_item_barang',
                'item_barangs.merk',
                'item_barangs.kondisi',
                'item_barangs.sumber',
                'item_barangs.tanggal_pengadaan',
                'item_barangs.harga_perolehan',
                'item_barangs.keterangan',
                'barangs.nama_barang'
            )
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->where('status', 1);

        if ($this->id_barang) {
            $query->where('item_barangs.id_barang', $this->id_barang);
        }
        if ($this->kondisi) {
            $query->where('item_barangs.kondisi', $this->kondisi);
        }
        if ($this->sumber) {
            $query->where('item_barangs.sumber', $this->sumber);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('item_barangs.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('item_barangs.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }

    public function map($itemBarang): array
    {

        if ($itemBarang->sumber === 'pembelian') {
            $sumber = 'Pembelian';
        } elseif ($itemBarang->sumber === 'hibah') {
            $sumber = 'Hibah';
        }

        if ($itemBarang->kondisi === 'baik') {
            $kondisi = 'Baik';
        } elseif ($itemBarang->kondisi === 'rusak_ringan') {
            $kondisi = 'Rusak Ringan';
        } elseif ($itemBarang->kondisi === 'rusak_berat') {
            $kondisi = 'Rusak Berat';
        }

        return [
            $itemBarang->nama_barang,
            $itemBarang->kode_item_barang,
            $itemBarang->nama_item_barang,
            $itemBarang->merk,
            $kondisi,
            $sumber,
            $itemBarang->tanggal_pengadaan,
            $itemBarang->harga_perolehan,
            $itemBarang->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            'BARANG',
            'KODE ITEM BARANG',
            'NAMA ITEM BARANG',
            'MERK',
            'KONDISI',
            'SUMBER',
            'TANGGAL PENGADAAN',
            'HARGA PEROLEHAN',
            'KETERANGAN',
        ];
    }
}
