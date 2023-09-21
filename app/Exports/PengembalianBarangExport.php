<?php

namespace App\Exports;

use App\Models\PengembalianBarang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengembalianBarangExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;
    public function query()
    {

        return PengembalianBarang::query()->select(
            "pengembalian_barangs.*",
            'peminjaman_barangs.kode_peminjaman_barang as kode',
            'peminjaman_barangs.nama_peminjam as nama',
        )
            ->join('peminjaman_barangs', 'peminjaman_barangs.id_peminjaman_barang', '=', 'pengembalian_barangs.id_peminjaman_barang')
            ->latest();
    }
    public function map($pengembalianBarang): array
    {
        return [
            $pengembalianBarang->kode_pengembalian_barang,
            $pengembalianBarang->nama,
            $pengembalianBarang->tanggal,
            $pengembalianBarang->status,
            $pengembalianBarang->keterangan,
        ];
    }


    public function headings(): array
    {
        return [
            'Kode Pengembalian Barang',
            'Nama Peminjam',
            'Tanggal Peminjaman',
            'Status',
            'Keterangan',

        ];
    }
}
