<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Exports\PerawatanBarangExport;
use App\Http\Controllers\Controller;
use App\Models\ItemBarang;
use App\Models\PerawatanBarang;
use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPerawatanBarangController extends Controller
{
    public function perawatan()
    {
        $title = 'Laporan Perawatan Aset';
        $itemBarang = ItemBarang::all();
        $perawatanBarang = PerawatanBarang::select("perawatan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'perawatan_barangs.id_item_barang')
            ->latest()->get();


        return view('admin.content.laporan.perawatan', compact('title',  'perawatanBarang', 'itemBarang'));
    }
    //PDF ======================================================================================================================

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

        $pdf = Pdf::loadView('sa.content.laporan.perawatan.perawatanBarangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }
    // EXCEL ========================================================================================================
    public function perawatanBarangExcel()
    {
        $tahun = date('Y');
        $perawatanBarang = new PerawatanBarangExport(null, null, null, null);
        return Excel::download($perawatanBarang, 'LAPORAN INVENTARIS PERAWATAN BARANG ' . $tahun . '.xlsx');
    }

    // Filter =====================================================================================================================

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

            $pdf = PDF::loadView('admin.content.laporan.perawatan.perawatanBarangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
}
