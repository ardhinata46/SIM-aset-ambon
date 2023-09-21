<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BarangExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $id_kategori_barang;

    public function __construct($id_kategori_barang)
    {
        $this->id_kategori_barang = $id_kategori_barang;
    }

    public function query()
    {
        $query = Barang::query()
            ->select(
                'barangs.id_kategori_barang',
                'barangs.kode_barang',
                'barangs.nama_barang',
                'kategori_barangs.nama_kategori_barang',
            )
            ->join('kategori_barangs', 'kategori_barangs.id_kategori_barang', '=', 'barangs.id_kategori_barang')
            ->withCount(['item_barang' => function ($query) {
                $query->where('status', 1);
            }]);

        if ($this->id_kategori_barang) {
            $query->where('barangs.id_kategori_barang', $this->id_kategori_barang);
        }
        return $query;
    }

    public function map($barang): array
    {
        return [
            $barang->nama_kategori_barang,
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->item_barang_count
        ];
    }

    public function headings(): array
    {
        return [
            'KATEGORI BARANG',
            'KODE BARANG',
            'NAMA BARANG',
            'JUMLAH ITEM'
        ];
    }
}
