<?php

namespace App\Http\Controllers\Superadmin\Laporan;

use App\Exports\PerawatanBangunanExport;
use App\Exports\PerawatanBarangExport;
use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\PerawatanBangunan;
use App\Models\PerawatanBarang;
use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPerawatanAsetController extends Controller
{

    public function perawatan()
    {
        $title = 'Laporan Perawatan Aset';
        $bangunan = Bangunan::all();
        $itemBarang = ItemBarang::all();
        $perawatanBangunan = PerawatanBangunan::select("perawatan_bangunans.*", 'bangunans.nama_bangunan as bangunan', 'bangunans.kode_bangunan as kode')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'perawatan_bangunans.id_bangunan')
            ->latest()->get();
        $perawatanBarang = PerawatanBarang::select("perawatan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'perawatan_barangs.id_item_barang')
            ->latest()->get();


        return view('sa.content.laporan.perawatan', compact('title', 'perawatanBangunan', 'perawatanBarang', 'bangunan', 'itemBarang'));
    }

    //PDF ======================================================================================================================


    public function perawatanBangunanPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $perawatanBangunan = PerawatanBangunan::select("perawatan_bangunans.*", 'bangunans.nama_bangunan as bangunan', 'bangunans.kode_bangunan as kode')
            ->join('bangunans', 'bangunans.id_bangunan', '=', 'perawatan_bangunans.id_bangunan')
            ->latest()->get();


        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PERAWATAN BANGUNAN ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'perawatanBangunan' => $perawatanBangunan,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PERAWATAN BANGUNAN ' . $tahun
        ];

        $pdf = Pdf::loadView('sa.content.laporan.perawatan.perawatanBangunanCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    public function perawatanBarangPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $perawatanBarang = PerawatanBarang::select("perawatan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'perawatan_barangs.id_item_barang')
            ->latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PERAWATAN ASET BARANG ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'perawatanBarang' => $perawatanBarang,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PERAWATAN ASET BARANG ' . $tahun
        ];

        $pdf = PDF::loadView('sa.content.laporan.perawatan.perawatanBarangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }
    // EXCEL ========================================================================================================

    public function perawatanBangunanExcel()
    {
        $tahun = date('Y');
        $perawatanBangunan = new PerawatanBangunanExport(null, null, null, null);
        return Excel::download($perawatanBangunan, 'LAPORAN INVENTARIS PERAWATAN BANGUNAN ' . $tahun . '.xlsx');
    }
    public function perawatanBarangExcel()
    {
        $tahun = date('Y');
        $perawatanBarang = new PerawatanBarangExport(null, null, null, null);
        return Excel::download($perawatanBarang, 'LAPORAN INVENTARIS PERAWATAN BARANG ' . $tahun . '.xlsx');
    }

    // Filter =====================================================================================================================

    public function filterPerawatanBangunan(Request $request)
    {
        $id_bangunan = $request->id_bangunan;
        $kondisi = $request->input('kondisi');
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

            $perawatanBangunan = new PerawatanBangunanExport($id_bangunan, $kondisi, $tanggal_awal, $tanggal_akhir);
            return Excel::download($perawatanBangunan, 'LAPORAN INVENTARIS BARANG BELUM DIKEMBALIKAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $perawatanBangunan = PerawatanBangunan::select("perawatan_bangunans.*", 'bangunans.nama_bangunan as bangunan', 'bangunans.kode_bangunan as kode')
                ->join('bangunans', 'bangunans.id_bangunan', '=', 'perawatan_bangunans.id_bangunan')
                ->latest();

            if ($id_bangunan) {
                $perawatanBangunan->where('perawatan_bangunans.id_bangunan', $id_bangunan);
            }

            if ($kondisi) {
                $perawatanBangunan->where('perawatan_bangunans.kondisi_sesudah', $kondisi);
            }


            if ($tanggal_awal && $tanggal_akhir) {
                $perawatanBangunan->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal_perawatan', '>=', $tanggal_awal)
                        ->whereDate('tanggal_perawatan', '<=', $tanggal_akhir);
                });
            }

            $perawatanBangunan = $perawatanBangunan->latest()->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PERAWATAN BANGUNAN ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'perawatanBangunan' => $perawatanBangunan,
                'alamat' => $alamat,
                'email' => $email,
                'nama' => $nama,
                'namaFile' => 'LAPORAN INVENTARIS PERAWATAN BANGUNAN ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.perawatan.perawatanBangunanCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
    public function filterPerawatanBarang(Request $request)
    {
        $id_item_barang = $request->id_item_barang;
        $kondisi = $request->input('kondisi');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $perawatanBarang = new PerawatanBarangExport($id_item_barang, $kondisi, $tanggal_awal, $tanggal_akhir);
            return Excel::download($perawatanBarang, 'LAPORAN INVENTARIS BARANG BELUM DIKEMBALIKAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $perawatanBarang = PerawatanBarang::select("perawatan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
                ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'perawatan_barangs.id_item_barang')
                ->latest();

            if ($id_item_barang) {
                $perawatanBarang->where('perawatan_barangs.id_item_barang', $id_item_barang);
            }

            if ($kondisi) {
                $perawatanBarang->where('perawatan_barangs.kondisi_sesudah', $kondisi);
            }


            if (
                $tanggal_awal && $tanggal_akhir
            ) {
                $perawatanBarang->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal_perawatan', '>=', $tanggal_awal)
                        ->whereDate('tanggal_perawatan', '<=', $tanggal_akhir);
                });
            }

            $perawatanBarang = $perawatanBarang->latest()->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PERAWATAN BARANG ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'perawatanBarang' => $perawatanBarang,
                'alamat' => $alamat,
                'email' => $email,
                'nama' => $nama,
                'namaFile' => 'LAPORAN INVENTARIS PERAWATAN BARANG ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.perawatan.perawatanBarangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
}
