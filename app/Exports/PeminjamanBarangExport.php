<?php

namespace App\Exports;

use App\Models\PeminjamanBarang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanBarangExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $status;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($status, $tanggal_awal, $tanggal_akhir)
    {
        $this->status = $status;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {
        $query = PeminjamanBarang::query()->select("peminjaman_barangs.*")
            ->orderBy('peminjaman_barangs.id_peminjaman_barang', 'ASC');

        if ($this->status !== null) {
            $query->where('peminjaman_barangs.status', $this->status);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('peminjaman_barangs.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('peminjaman_barangs.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }

    public function map($peminjamanBarang): array
    {
        if ($peminjamanBarang->status === 0) {
            $status = 'Belum Dikembalikan';
        } elseif ($peminjamanBarang->status === 1) {
            $status = 'Sudah Dikembalikan';
        }

        return [
            $peminjamanBarang->kode_peminjaman_barang,
            $peminjamanBarang->nama_peminjam,
            $peminjamanBarang->tanggal,
            $peminjamanBarang->kontak,
            $peminjamanBarang->alamat,
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            'KODE PEMINJAMAN BARANG',
            'NAMA PEMINJAMAN',
            'TANGGAL PEMINJAMAN',
            'TELP/WA',
            'ALAMAT',
            'STATUS PEMINJAMAN'

        ];
    }
}
