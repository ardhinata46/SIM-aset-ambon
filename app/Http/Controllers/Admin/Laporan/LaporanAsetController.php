<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Exports\BarangExport;
use App\Exports\ItemBarangExport;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\KategoriBarang;
use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanAsetController extends Controller
{
    public function index()
    {
        $title = 'Data Laporan Aset';

        $kategoriBarang = KategoriBarang::get();

        $pilihBarang = Barang::get();

        $barang = Barang::select('barangs.*', 'kategori_barangs.nama_kategori_barang as nama', 'kategori_barangs.kode_kategori_barang as kode')
            ->join('kategori_barangs', 'kategori_barangs.id_kategori_barang', '=', 'barangs.id_kategori_barang')
            ->withCount(['item_barang' => function ($query) {
                $query->where('status', 1);
            }])
            ->latest()->get();

        $itemBarang = ItemBarang::select('item_barangs.*', 'barangs.nama_barang as barang', 'barangs.kode_barang as kode')
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->where('status', 1)
            ->latest()->get();

        return view('admin.content.laporan.index', compact('title', 'kategoriBarang', 'barang', 'itemBarang', 'pilihBarang'));
    }


    public function barangPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $barang = Barang::select('barangs.*', 'kategori_barangs.nama_kategori_barang as nama', 'kategori_barangs.kode_kategori_barang as kode')
            ->join('kategori_barangs', 'kategori_barangs.id_kategori_barang', '=', 'barangs.id_kategori_barang')
            ->withCount(['item_barang' => function ($query) {
                $query->where('status', 1);
            }])
            ->latest()->get();


        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS ASET BARANG ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'barang' => $barang,
            'alamat' => $alamat,
            'nama' => $nama,
            'email' => $email,
            'namaFile' => 'LAPORAN INVENTARIS ASET BARANG ' . $tahun
        ];

        $pdf = Pdf::loadView('admin.content.laporan.aset.barangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    public function itemBarangPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $barang = Barang::get();
        $itemBarang = ItemBarang::select('item_barangs.*', 'barangs.nama_barang as barang', 'barangs.kode_barang as kode')
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->where('status', 1)->latest()->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS ITEM BARANG ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'barang' => $barang,
            'itemBarang' => $itemBarang,
            'alamat' => $alamat,
            'nama' => $nama,
            'email' => $email,
            'namaFile' => 'LAPORAN INVENTARIS ITEM BARANG ' . $tahun
        ];

        $pdf = PDF::loadView('admin.content.laporan.aset.itemBarangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    //Excel ======================================================================================


    public function barangExcel()
    {
        $tahun = date('Y');
        $barangExport = new BarangExport(null);
        return Excel::download($barangExport, 'LAPORAN INVENTARIS ASET BARANG ' . $tahun . '.xlsx');
    }

    public function itemBarangExcel()
    {
        $tahun = date('Y');
        $itemBarangExport = new ItemBarangExport(null, null, null, null, null);
        return Excel::download($itemBarangExport, 'LAPORAN INVENTARIS ASET ITEM BARANG ' . $tahun . '.xlsx');
    }

    //Filter======================================================================================

    public function filterBarang(Request $request)
    {
        $id_kategori_barang = $request->id_kategori_barang;

        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $barangExport = new BarangExport($id_kategori_barang);
            return Excel::download($barangExport, 'LAPORAN INVENTARIS ASET BARANG ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $barang = Barang::select('barangs.*', 'kategori_barangs.nama_kategori_barang as nama', 'kategori_barangs.kode_kategori_barang as kode')
                ->join('kategori_barangs', 'kategori_barangs.id_kategori_barang', '=', 'barangs.id_kategori_barang')
                ->withCount(['item_barang' => function ($query) {
                    $query->where('status', 1);
                }])
                ->when($id_kategori_barang, function ($query) use ($id_kategori_barang) {
                    $query->where('barangs.id_kategori_barang', $id_kategori_barang);
                })
                ->latest()
                ->get();

            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS ASET BARANG ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'barang' => $barang,
                'alamat' => $alamat,
                'nama' => $nama,
                'email' => $email,
                'namaFile' => 'LAPORAN INVENTARIS ASET BARANG ' . $tahun
            ];

            $pdf = PDF::loadView('admin.content.laporan.aset.barangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
    public function filterItemBarang(Request $request)
    {
        $id_barang = $request->id_barang;
        $nama_item_barang = $request->nama_item_barang;
        $kondisi = $request->input('kondisi');
        $sumber = $request->input('sumber');
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

            $itemBarangExport = new ItemBarangExport($id_barang, $kondisi, $sumber, $tanggal_awal, $tanggal_akhir);

            return Excel::download($itemBarangExport, 'LAPORAN INVENTARIS ASET ITEM BARANG ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $itemBarang = ItemBarang::select('item_barangs.*', 'barangs.nama_barang as barang', 'barangs.kode_barang as kode')
                ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
                ->where('item_barangs.status', 1);

            if ($id_barang) {
                $itemBarang->where('item_barangs.id_barang', $id_barang);
            }

            if ($nama_item_barang) {
                $itemBarang->where('item_barangs.nama_item_barang', 'LIKE', '%' . $nama_item_barang . '%');
            }

            if ($kondisi) {
                $itemBarang->where('item_barangs.kondisi', $kondisi);
            }

            if ($sumber) {
                $itemBarang->where('item_barangs.sumber', $sumber);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $itemBarang->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal_pengadaan', '>=', $tanggal_awal)
                        ->whereDate('tanggal_pengadaan', '<=', $tanggal_akhir);
                });
            }

            $itemBarang = $itemBarang->latest()->get();


            $tahun = date('Y');
            $namaFile = 'LAPORAN INVENTARIS ITEM BARANG ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'itemBarang' => $itemBarang,
                'alamat' => $alamat,
                'nama' => $nama,
                'email' => $email,
                'namaFile' => 'LAPORAN INVENTARIS ITEM BARANG ' . $tahun
            ];

            $pdf = PDF::loadView('admin.content.laporan.aset.itemBarangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
}
