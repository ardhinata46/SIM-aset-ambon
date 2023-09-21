<?php

namespace App\Http\Controllers\Superadmin\Laporan;

use App\Exports\PenghapusanBangunanExport;
use App\Exports\PenghapusanBarangExport;
use App\Exports\PenghapusanTanahExport;
use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\PenghapusanBangunan;
use App\Models\PenghapusanBarang;
use App\Models\PenghapusanTanah;
use App\Models\Profil;
use App\Models\Tanah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenghapusanAsetController extends Controller
{
    public function penghapusan()
    {
        $title = 'Laporan Penghapusan Aset ';
        $tanah = Tanah::all();
        $bangunan = Bangunan::all();
        $itemBarang = ItemBarang::all();
        $penghapusanTanah = PenghapusanTanah::select("penghapusan_tanahs.*", 'tanahs.nama_tanah as tanah')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'penghapusan_tanahs.id_tanah')->latest()->get();

        $penghapusanBangunan = PenghapusanBangunan::select("penghapusan_bangunans.*", 'bangunans.nama_bangunan as bangunan')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'penghapusan_bangunans.id_bangunan')->latest()->get();

        $penghapusanBarang = PenghapusanBarang::select("penghapusan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'penghapusan_barangs.id_item_barang')->latest()->get();

        return view('sa.content.laporan.penghapusan', compact('title', 'penghapusanTanah', 'penghapusanBangunan', 'penghapusanBarang', 'tanah', 'bangunan', 'itemBarang'));
    }


    // PDF =======================================================================================================================================================
    public function penghapusanTanahPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $penghapusanTanah = PenghapusanTanah::select("penghapusan_tanahs.*", 'tanahs.nama_tanah as tanah')
            ->join(
                'tanahs',
                'tanahs.id_tanah',
                '=',
                'penghapusan_tanahs.id_tanah'
            )
            ->latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PENGHAPUSAN ASET TANAH ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'penghapusanTanah' => $penghapusanTanah,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PENGHAPUSAN ASET TANAH ' . $tahun
        ];

        $pdf = Pdf::loadView('sa.content.laporan.penghapusan.penghapusanTanahCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    public function penghapusanBangunanPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $penghapusanBangunan = PenghapusanBangunan::select("penghapusan_bangunans.*", 'bangunans.nama_bangunan as bangunan')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'penghapusan_bangunans.id_bangunan')
            ->latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PENGHAPUSAN ASET BANGUNAN ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'penghapusanBangunan' => $penghapusanBangunan,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' =>  'LAPORAN INVENTARIS PENGHAPUSAN ASET BANGUNAN ' . $tahun
        ];

        $pdf = PDF::loadView('sa.content.laporan.penghapusan.penghapusanBangunanCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    public function penghapusanBarangPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $penghapusanBarang = PenghapusanBarang::select("penghapusan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'penghapusan_barangs.id_item_barang')
            ->latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PENGHAPUSAN ASET BARANG ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'penghapusanBarang' => $penghapusanBarang,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PENGHAPUSAN ASET BARANG ' . $tahun
        ];

        $pdf = PDF::loadView('sa.content.laporan.penghapusan.penghapusanBarangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    // EXCEL ============================================================================================================
    public function penghapusanTanahExcel()
    {
        $tahun = date('Y');
        $penghapusanTanahExport = new PenghapusanTanahExport(null, null, null);
        return Excel::download($penghapusanTanahExport, 'LAPORAN INVENTARIS PENGHAPUSAN TANAH ' . $tahun . '.xlsx');
    }

    public function penghapusanBangunanExcel()
    {
        $tahun = date('Y');
        $penghapusanBangunanExport = new PenghapusanBangunanExport(null, null, null);
        return Excel::download($penghapusanBangunanExport, 'LAPORAN INVENTARIS PENGHAPUSAN BANGUNAN ' . $tahun . '.xlsx');
    }
    public function penghapusanBarangExcel()
    {
        $tahun = date('Y');
        $penghapusanBarangExport = new PenghapusanBarangExport(null, null, null, null);
        return Excel::download($penghapusanBarangExport, 'LAPORAN INVENTARIS PENGHAPUSAN BARANG ' . $tahun . '.xlsx');
    }

    // Filter ====================================================================================================================

    public function filterPenghapusanTanah(Request $request)
    {
        $tindakan = $request->input('tindakan');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $penghapusanTanah = new PenghapusanTanahExport($tindakan, $tanggal_awal, $tanggal_akhir);
            return Excel::download($penghapusanTanah, 'LAPORAN INVENTARIS PENGHAPUSAN TANAH ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $penghapusanTanah = PenghapusanTanah::select("penghapusan_tanahs.*", 'tanahs.nama_tanah as tanah')
                ->join(
                    'tanahs',
                    'tanahs.id_tanah',
                    '=',
                    'penghapusan_tanahs.id_tanah'
                )
                ->latest();

            if ($tindakan) {
                $penghapusanTanah->where('penghapusan_tanahs.tindakan', $tindakan);
            }


            if ($tanggal_awal && $tanggal_akhir) {
                $penghapusanTanah->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal', '>=', $tanggal_awal)
                        ->whereDate('tanggal', '<=', $tanggal_akhir);
                });
            }

            $penghapusanTanah = $penghapusanTanah->latest()->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PENGHAPUSAN ASET TANAH ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'penghapusanTanah' => $penghapusanTanah,
                'alamat' => $alamat,
                'email' => $email,
                'nama' => $nama,
                'namaFile' => 'LAPORAN INVENTARIS PENGHAPUSAN ASET TANAH ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.penghapusan.penghapusanTanahCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
    public function filterPenghapusanBangunan(Request $request)
    {
        $tindakan = $request->input('tindakan');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $penghapusanBangunanExport = new PenghapusanBangunanExport($tindakan, $tanggal_awal, $tanggal_akhir);
            return Excel::download($penghapusanBangunanExport, 'LAPORAN INVENTARIS PENGHAPUSAN BANGUNAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $penghapusanBangunan = PenghapusanBangunan::select("penghapusan_bangunans.*", 'bangunans.nama_bangunan as bangunan')
                ->join('bangunans', 'bangunans.id_bangunan', '=', 'penghapusan_bangunans.id_bangunan')
                ->latest();


            if ($tindakan) {
                $penghapusanBangunan->where('penghapusan_bangunans.tindakan', $tindakan);
            }

            $penghapusanBarang = PenghapusanBarang::select("penghapusan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
                ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'penghapusan_barangs.id_item_barang')
                ->latest()->get();


            if ($tanggal_awal && $tanggal_akhir) {
                $penghapusanBangunan->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal', '>=', $tanggal_awal)
                        ->whereDate('tanggal', '<=', $tanggal_akhir);
                });
            }

            $penghapusanBangunan = $penghapusanBangunan->latest()->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PENGHAPUSAN ASET BANGUNAN ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'penghapusanBangunan' => $penghapusanBangunan,
                'alamat' => $alamat,
                'email' => $email,
                'nama' => $nama,
                'namaFile' =>  'LAPORAN INVENTARIS PENGHAPUSAN ASET BANGUNAN ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.penghapusan.penghapusanBangunanCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }

    public function filterPenghapusanBarang(Request $request)
    {
        $tindakan = $request->input('tindakan');
        $alasan = $request->input('alasan');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $penghapusanBarangExport = new PenghapusanBarangExport($alasan, $tindakan, $tanggal_awal, $tanggal_akhir);
            return Excel::download($penghapusanBarangExport, 'LAPORAN INVENTARIS PENGHAPUSAN BANGUNAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $penghapusanBarang = PenghapusanBarang::select("penghapusan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
                ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'penghapusan_barangs.id_item_barang')
                ->latest();


            if ($tindakan) {
                $penghapusanBarang->where('penghapusan_barangs.tindakan', $tindakan);
            }
            if ($alasan) {
                $penghapusanBarang->where('penghapusan_barangs.alasan', $alasan);
            }


            if ($tanggal_awal && $tanggal_akhir) {
                $penghapusanBarang->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal', '>=', $tanggal_awal)
                        ->whereDate('tanggal', '<=', $tanggal_akhir);
                });
            }

            $penghapusanBarang = $penghapusanBarang->latest()->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PENGHAPUSAN ASET BARANG ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'penghapusanBarang' => $penghapusanBarang,
                'alamat' => $alamat,
                'email' => $email,
                'nama' => $nama,
                'namaFile' => 'LAPORAN INVENTARIS PENGHAPUSAN ASET BARANG ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.penghapusan.penghapusanBarangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
}
