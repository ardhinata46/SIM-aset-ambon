<?php

namespace App\Http\Controllers\Superadmin\Laporan;

use App\Exports\PengadaanBangunanExport;
use App\Exports\PengadaanBarangExport;
use App\Exports\PengadaanTanahExport;
use App\Http\Controllers\Controller;
use App\Models\PengadaanBangunan;
use App\Models\PengadaanBarang;
use App\Models\PengadaanTanah;
use App\Models\Profil;
use App\Models\Tanah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPengadaanAsetController extends Controller
{
    public function pengadaan()
    {
        $title = 'Laporan Pengadaan Aset ';

        $pengadaanTanah = PengadaanTanah::select(
            'pengadaan_tanahs.kode_pengadaan_tanah',
            'pengadaan_tanahs.kode_tanah',
            'pengadaan_tanahs.nama_tanah',
            'pengadaan_tanahs.lokasi',
            'pengadaan_tanahs.tanggal_pengadaan',
            'pengadaan_tanahs.sumber',
            'pengadaan_tanahs.harga_perolehan',
            'pengadaan_tanahs.luas',
            'pengadaan_tanahs.keterangan',
        )
            ->get();

        $pengadaanBangunan = PengadaanBangunan::select(
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
            ->join('tanahs', 'tanahs.id_tanah', '=', 'pengadaan_bangunans.id_tanah')
            ->get();
        $pengadaanBarang = PengadaanBarang::latest()->get();
        $tanah = Tanah::all();

        return view('sa.content.laporan.pengadaan', compact('title', 'pengadaanTanah', 'pengadaanBangunan', 'pengadaanBarang', 'tanah'));
    }

    //PDF ==============================================================================================================================================================
    public function pengadaanTanahPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $pengadaanTanah = PengadaanTanah::latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PENGADAAN ASET TANAH ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'pengadaanTanah' => $pengadaanTanah,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PENGADAAN ASET TANAH ' . $tahun
        ];

        $pdf = Pdf::loadView('sa.content.laporan.pengadaan.pengadaanTanahCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
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

        $pdf = PDF::loadView('sa.content.laporan.pengadaan.pengadaanBarangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    public function pengadaanBangunanPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $pengadaanBangunan = PengadaanBangunan::select(
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
            ->join('tanahs', 'tanahs.id_tanah', '=', 'pengadaan_bangunans.id_tanah')
            ->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PENGADAAN ASET BANGUNAN ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'pengadaanBangunan' => $pengadaanBangunan,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PENGADAAN ASET BANGUNAN ' . $tahun
        ];

        $pdf = PDF::loadView('sa.content.laporan.pengadaan.pengadaanBangunanCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }




    //EXCEL ==================================================================================================================================

    public function pengadaanTanahExcel()
    {
        $tahun = date('Y');
        $pengadaanTanahExport = new PengadaanTanahExport(null, null, null, null);
        return Excel::download($pengadaanTanahExport, 'LAPORAN INVENTARIS PENGADAAN TANAH ' . $tahun . '.xlsx');
    }

    public function pengadaanBangunanExcel()
    {
        $tahun = date('Y');
        $pengadaanBangunanExport = new PengadaanBangunanExport(null, null, null, null, null);
        return Excel::download($pengadaanBangunanExport, 'LAPORAN INVENTARIS PENGADAAN BANGUNAN ' . $tahun . '.xlsx');
    }

    public function pengadaanBarangExcel()
    {
        $tahun = date('Y');
        $pengadaanBarangExport = new PengadaanBarangExport(null, null, null);
        return Excel::download($pengadaanBarangExport, 'LAPORAN INVENTARIS PENGADAAN BARANG ' . $tahun . '.xlsx');
    }

    //Filter ====================================================================================================================

    public function filterPengadaanTanah(Request $request)
    {
        // Dapatkan nilai filter dari permintaan
        $lokasi = $request->input('lokasi');
        $sumber = $request->input('sumber');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Dapatkan informasi profil
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $pengadaanTanahExport = new PengadaanTanahExport($lokasi, $sumber, $tanggal_awal, $tanggal_akhir);

            return Excel::download($pengadaanTanahExport, 'LAPORAN INVENTARIS PENGADAAN TANAH ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {
            $pengadaanTanah = PengadaanTanah::select(
                'pengadaan_tanahs.kode_pengadaan_tanah',
                'pengadaan_tanahs.kode_tanah',
                'pengadaan_tanahs.nama_tanah',
                'pengadaan_tanahs.lokasi',
                'pengadaan_tanahs.tanggal_pengadaan',
                'pengadaan_tanahs.sumber',
                'pengadaan_tanahs.harga_perolehan',
                'pengadaan_tanahs.luas',
                'pengadaan_tanahs.keterangan',
            );

            if ($lokasi) {
                $pengadaanTanah->where('pengadaan_tanahs.lokasi', 'LIKE', '%' . $lokasi . '%');
            }

            if ($sumber) {
                $pengadaanTanah->where('pengadaan_tanahs.sumber', $sumber);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $pengadaanTanah->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal_pengadaan', '>=', $tanggal_awal)
                        ->whereDate('tanggal_pengadaan', '<=', $tanggal_akhir);
                });
            }

            $pengadaanTanah = $pengadaanTanah->get();

            $namaFile = 'LAPORAN INVENTARIS PENGADAAN ASET TANAH ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'pengadaanTanah' => $pengadaanTanah,
                'alamat' => $alamat,
                'email' => $email,
                'nama' => $nama,
                'namaFile' => 'LAPORAN INVENTARIS PENGADAAN ASET TANAH ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.pengadaan.pengadaanTanahCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }

    public function filterPengadaanBangunan(Request $request)
    {
        // Dapatkan nilai filter dari permintaan
        $id_tanah = $request->input('id_tanah');
        $sumber = $request->input('sumber');
        $kondisi = $request->input('kondisi');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Dapatkan informasi profil
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $pengadaanBangunanExport = new PengadaanBangunanExport($id_tanah, $sumber, $kondisi, $tanggal_awal, $tanggal_akhir);

            return Excel::download($pengadaanBangunanExport, 'LAPORAN INVENTARIS PENGADAAN BANGUNAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $pengadaanBangunan = PengadaanBangunan::select(
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

            if ($id_tanah) {
                $pengadaanBangunan->where('pengadaan_bangunans.id_tanah', $id_tanah);
            }

            if ($sumber) {
                $pengadaanBangunan->where('pengadaan_bangunans.sumber', $sumber);
            }


            if ($kondisi) {
                $pengadaanBangunan->where('pengadaan_bangunans.kondisi', $kondisi);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $pengadaanBangunan->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal_pengadaan', '>=', $tanggal_awal)
                        ->whereDate('tanggal_pengadaan', '<=', $tanggal_akhir);
                });
            }

            $pengadaanBangunan = $pengadaanBangunan->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PENGADAAN ASET BANGUNAN ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'pengadaanBangunan' => $pengadaanBangunan,
                'alamat' => $alamat,
                'nama' => $nama,
                'email' => $email,
                'namaFile' => 'LAPORAN INVENTARIS PENGADAAN ASET BANGUNAN ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.pengadaan.pengadaanBangunanCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }

    public function filterPengadaanBarang(Request $request)
    {
        $sumber = $request->input('sumber');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Dapatkan informasi profil
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $pengadaanBarangExport = new PengadaanBarangExport($sumber, $tanggal_awal, $tanggal_akhir);

            return Excel::download($pengadaanBarangExport, 'LAPORAN INVENTARIS PENGADAAN BANGUNAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $pengadaanBarang = PengadaanBarang::latest();

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
            $pengadaanBarang = $pengadaanBarang->get();

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

            $pdf = PDF::loadView('sa.content.laporan.pengadaan.pengadaanBarangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
}
