<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BelumKembaliExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $nama_peminjam;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($nama_peminjam, $tanggal_awal, $tanggal_akhir)
    {
        $this->nama_peminjam = $nama_peminjam;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {
        $query = DB::table('item_barangs')
            ->leftJoin('item_peminjaman_barangs', 'item_barangs.id_item_barang', '=', 'item_peminjaman_barangs.id_item_barang')
            ->leftJoin('peminjaman_barangs', 'item_peminjaman_barangs.id_peminjaman_barang', '=', 'peminjaman_barangs.id_peminjaman_barang')
            ->select('item_barangs.kode_item_barang', 'item_barangs.nama_item_barang', 'peminjaman_barangs.*')
            ->where('peminjaman_barangs.status', 0)
            ->orderBy('peminjaman_barangs.kode_peminjaman_barang');

        if ($this->nama_peminjam) {
            $query->where('nama_peminjam', 'like', '%' . $this->nama_peminjam . '%');
        }

        if ($this->tanggal_awal) {
            $query->whereDate('tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }

    public function map($itemBarang): array
    {
        return [
            $itemBarang->kode_item_barang,
            $itemBarang->nama_item_barang,
            $itemBarang->kode_peminjaman_barang,
            $itemBarang->nama_peminjam,
            $itemBarang->tanggal,
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Item Barang',
            'Nama Item Barang',
            'Kode Peminjaman Barang',
            'Nama Peminjam',
            'Tanggal Peminjaman',
        ];
    }
}
