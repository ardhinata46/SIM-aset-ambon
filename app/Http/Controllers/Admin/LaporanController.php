<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\KategoriBarang;
use App\Models\PeminjamanBarang;
use App\Models\PengadaanBarang;
use App\Models\PengembalianBarang;
use App\Models\PerawatanBarang;
use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class LaporanController extends Controller
{

    // Laporan============================================================================================================================================


    public function pengadaan()
    {
        $title = 'Laporan Pengadaan Aset';

        $pengadaanBarang = PengadaanBarang::latest()->get();

        return view('admin.content.laporan.pengadaan', compact('title', 'pengadaanBarang'));
    }
    public function pengadaanBarangPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $pengadaanBarang = PengadaanBarang::latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PENGADAAN ASET BARANG ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'pengadaanBarang' => $pengadaanBarang,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PENGADAAN ASET BARANG ' . $tahun
        ];

        $pdf = PDF::loadView('admin.content.laporan.pengadaan.pengadaanBarangCetak', $data);

        return $pdf->download($namaFile);
        //return $pdf->stream($namaFile);
    }

    public function filterPengadaanBarangPDF(Request $request)
    {
        // Dapatkan nilai filter dari permintaan
        $idBarang = $request->input('id_barang');
        $sumber = $request->input('sumber');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Dapatkan informasi profil
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        // Buat query dasar
        $pengadaanBarang = PengadaanBarang::query();

        if ($sumber) {
            $pengadaanBarang->where('pengadaan_barangs.sumber', $sumber);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $pengadaanBarang->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                $query->whereDate('tanggal_pengadaan', '>=', $tanggal_awal)
                    ->whereDate('tanggal_pengadaan', '<=', $tanggal_akhir);
            });
        }

        // Dapatkan data yang difilter
        $pengadaanBarang = $pengadaanBarang->latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PENGADAAN ASET BARANG ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'pengadaanBarang' => $pengadaanBarang,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PENGADAAN ASET BARANG ' . $tahun
        ];

        $pdf = PDF::loadView('admin.content.laporan.pengadaan.pengadaanBarangCetak', $data);

        return $pdf->download($namaFile);
        //return $pdf->stream($namaFile);
    }
}
