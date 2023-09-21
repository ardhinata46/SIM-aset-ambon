<?php

namespace App\Http\Controllers\Superadmin\Laporan;

use App\Exports\BelumKembaliExport;
use App\Exports\PeminjamanBarangExport;
use App\Http\Controllers\Controller;
use App\Models\PeminjamanBarang;
use App\Models\PengembalianBarang;
use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPeminjamanBarangController extends Controller
{
    public function peminjaman()
    {
        $title = 'Laporan Peminjaman Aset ';
        $filter = PeminjamanBarang::select('peminjaman_barangs.kode_peminjaman_barang')
            ->where('status', 0)->get();
        $peminjamanBarang = PeminjamanBarang::latest()->get();
        $items = DB::table('item_barangs')
            ->leftJoin('item_peminjaman_barangs', 'item_barangs.id_item_barang', '=', 'item_peminjaman_barangs.id_item_barang')
            ->leftJoin('peminjaman_barangs', 'item_peminjaman_barangs.id_peminjaman_barang', '=', 'peminjaman_barangs.id_peminjaman_barang')
            ->select('item_barangs.kode_item_barang', 'item_barangs.nama_item_barang', 'peminjaman_barangs.*')
            ->where('peminjaman_barangs.status', 0)
            ->get();

        return view('sa.content.laporan.peminjaman', compact('title', 'peminjamanBarang', 'items', 'filter'));
    }

    public function belumKembaliPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $items = DB::table('item_barangs')
            ->leftJoin('item_peminjaman_barangs', 'item_barangs.id_item_barang', '=', 'item_peminjaman_barangs.id_item_barang')
            ->leftJoin('peminjaman_barangs', 'item_peminjaman_barangs.id_peminjaman_barang', '=', 'peminjaman_barangs.id_peminjaman_barang')
            ->select('item_barangs.kode_item_barang', 'item_barangs.nama_item_barang', 'peminjaman_barangs.*')
            ->where('peminjaman_barangs.status', 0)
            ->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS BARANG BELUM DIKEMBALIKAN ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'items' => $items,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS BARANG BELUM DIKEMBALIKAN ' . $tahun
        ];

        $pdf = Pdf::loadView('sa.content.laporan.peminjaman.belumKembaliCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }
    public function peminjamanPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $email = $profil->email;
        $nama = $profil->nama_organisasi;

        $peminjamanBarang = PeminjamanBarang::latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'peminjamanBarang' => $peminjamanBarang,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'namaFile' => 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun
        ];

        $pdf = Pdf::loadView('sa.content.laporan.peminjaman.peminjamanBarangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }


    //END PDF ==================================================================================================================




    //EXCEL==================================================================================================================

    public function peminjamanBarangExcel()
    {
        $tahun = date('Y');
        $peminjamanBarangExport = new PeminjamanBarangExport(null, null, null);
        return Excel::download($peminjamanBarangExport, 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun . '.xlsx');
    }

    public function belumKembaliExcel()
    {
        $tahun = date('Y');
        $belumKembaliExport = new BelumKembaliExport(null, null, null);
        return Excel::download($belumKembaliExport, 'LAPORAN INVENTARIS BARANG BELUM DIKEMBALIKAN ' . $tahun . '.xlsx');
    }

    //Filter ====================================================================================================================

    public function filterPeminjaman(Request $request)
    {
        $status = $request->input('status');
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

            $peminjamanBarangExport = new PeminjamanBarangExport($status, $tanggal_awal, $tanggal_akhir);
            return Excel::download($peminjamanBarangExport, 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $peminjamanBarang = PeminjamanBarang::select('peminjaman_barangs.*');

            if ($status !== null) {
                $peminjamanBarang->where('peminjaman_barangs.status', $status);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $peminjamanBarang->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal', '>=', $tanggal_awal)
                        ->whereDate('tanggal', '<=', $tanggal_akhir);
                });
            }

            $peminjamanBarang = $peminjamanBarang->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'peminjamanBarang' => $peminjamanBarang,
                'alamat' => $alamat,
                'nama' => $nama,
                'email' => $email,
                'namaFile' => 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.peminjaman.peminjamanBarangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }

    public function filterBelumKembali(Request $request)
    {
        $nama_peminjam = $request->input('nama_peminjam');
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

            $belumKembaliExport = new BelumKembaliExport($nama_peminjam, $tanggal_awal, $tanggal_akhir);
            return Excel::download($belumKembaliExport, 'LAPORAN INVENTARIS BARANG BELUM DIKEMBALIKAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $items = DB::table('item_barangs')
                ->leftJoin('item_peminjaman_barangs', 'item_barangs.id_item_barang', '=', 'item_peminjaman_barangs.id_item_barang')
                ->leftJoin('peminjaman_barangs', 'item_peminjaman_barangs.id_peminjaman_barang', '=', 'peminjaman_barangs.id_peminjaman_barang')
                ->select('item_barangs.kode_item_barang', 'item_barangs.nama_item_barang', 'peminjaman_barangs.*')
                ->where('peminjaman_barangs.status', 0);

            if ($nama_peminjam) {
                $items->where(
                    'peminjaman_barangs.nama_peminjam',
                    'LIKE',
                    '%' . $nama_peminjam . '%'
                );
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $items->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal', '>=', $tanggal_awal)
                        ->whereDate('tanggal', '<=', $tanggal_akhir);
                });
            }

            $items = $items->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'items' => $items,
                'alamat' => $alamat,
                'nama' => $nama,
                'email' => $email,
                'namaFile' => 'LAPORAN INVENTARIS PEMINJAMAN BARANG ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.peminjaman.belumKembaliCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
}
