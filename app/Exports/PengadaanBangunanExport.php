<?php

namespace App\Exports;

use App\Models\PengadaanBangunan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengadaanBangunanExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $id_tanah;
    protected $sumber;
    protected $kondisi;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($id_tanah, $sumber, $kondisi, $tanggal_awal, $tanggal_akhir)
    {
        $this->id_tanah = $id_tanah;
        $this->kondisi = $kondisi;
        $this->sumber = $sumber;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function query()
    {

        $query = PengadaanBangunan::query()->select(
            'tanahs.nama_tanah',
            'pengadaan_bangunans.kode_pengadaan_bangunan',
            'pengadaan_bangunans.kode_bangunan',
            'pengadaan_bangunans.nama_bangunan',
            'pengadaan_bangunans.lokasi',
            'pengadaan_bangunans.deskripsi',
            'pengadaan_bangunans.kondisi',
            'pengadaan_bangunans.tanggal_pengadaan',
            'pengadaan_bangunans.sumber',
            'pengadaan_bangunans.harga_perolehan',
            'pengadaan_bangunans.keterangan',
        )
            ->join('tanahs', 'tanahs.id_tanah', '=', 'pengadaan_bangunans.id_tanah');

        if ($this->id_tanah) {
            $query->where('pengadaan_bangunans.id_tanah', $this->id_tanah);
        }
        if ($this->sumber) {
            $query->where('pengadaan_bangunans.sumber', $this->sumber);
        }
        if ($this->kondisi) {
            $query->where('pengadaan_bangunans.kondisi', $this->kondisi);
        }

        if ($this->tanggal_awal) {
            $query->whereDate('pengadaan_bangunans.tanggal_pengadaan', '>=', $this->tanggal_awal);
        }

        if ($this->tanggal_akhir) {
            $query->whereDate('pengadaan_bangunans.tanggal_pengadaan', '<=', $this->tanggal_akhir);
        }

        return $query;
    }
    public function map($pengadaanBangunan): array
    {
        if ($pengadaanBangunan->sumber === 'pembangunan') {
            $sumber = 'Pembangunan';
        } elseif ($pengadaanBangunan->sumber === 'pembelian') {
            $sumber = 'Pembelian';
        } elseif ($pengadaanBangunan->sumber === 'hibah') {
            $sumber = 'Hibah';
        }

        if ($pengadaanBangunan->kondisi === 'baik') {
            $kondisi = 'Baik';
        } elseif ($pengadaanBangunan->kondisi === 'rusak_ringan') {
            $kondisi = 'Rusak Ringan';
        } elseif ($pengadaanBangunan->kondisi === 'rusak_berat') {
            $kondisi = 'Rusak Berat';
        }

        return [
            $pengadaanBangunan->kode_pengadaan_bangunan,
            $pengadaanBangunan->kode_bangunan,
            $pengadaanBangunan->nama_bangunan,
            $pengadaanBangunan->nama_tanah,
            $pengadaanBangunan->lokasi,
            $pengadaanBangunan->deskripsi,
            $kondisi,
            $pengadaanBangunan->tanggal_pengadaan,
            $sumber,
            $pengadaanBangunan->harga_perolehan,
            $pengadaanBangunan->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            'KODE PENGADAAN BANGUNAN',
            'KODE BANGUNAN',
            'NAMA BANGUNAN',
            'TANAH BERDIRINYA BANGUNAN',
            'lOKASI',
            'DESKRIPSI',
            'KONDISI',
            'TANGGAL PENGADAAN',
            'SUMBER',
            'HARGA PEROLEHAN',
            'KETERANGAN',
        ];
    }
}
