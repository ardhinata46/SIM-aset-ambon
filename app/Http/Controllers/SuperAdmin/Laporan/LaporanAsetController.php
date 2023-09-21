<?php

namespace App\Http\Controllers\Superadmin\Laporan;

use App\Exports\BangunanExport;
use App\Exports\BarangExport;
use App\Exports\ItemBarangExport;
use App\Exports\TanahExport;
use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\KategoriBarang;
use App\Models\Profil;
use App\Models\Tanah;
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

        $tanah = Tanah::where('status', 1)->latest()->get();

        $bangunan = Bangunan::select('bangunans.*', 'tanahs.nama_tanah')
            ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
            ->where('bangunans.status', '=', 1)
            ->latest()
            ->get();

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

        return view('sa.content.laporan.index', compact('title', 'tanah', 'bangunan', 'kategoriBarang', 'barang', 'itemBarang', 'pilihBarang'));
    }

    //PDF ====================================================================================================================================================================================
    public function tanahPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;
        $tanah = Tanah::where('status', 1)->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS ASET TANAH ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'alamat' => $alamat,
            'email' => $email,
            'nama' => $nama,
            'tanah' => $tanah,
            'namaFile' => 'LAPORAN INVENTARIS ASET TANAH ' . $tahun
        ];

        $pdf = PDF::loadView('sa.content.laporan.aset.tanahCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    public function bangunanPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;
        $bangunan = Bangunan::select(
            'tanahs.nama_tanah',
            'bangunans.kode_bangunan',
            'bangunans.nama_bangunan',
            'bangunans.deskripsi',
            'bangunans.harga_perolehan',
            'bangunans.kondisi',
            'bangunans.id_tanah',
            'bangunans.lokasi',
            'bangunans.sumber',
            'bangunans.tanggal_pengadaan',
            'bangunans.keterangan'
        )
            ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
            ->where('bangunans.status', '=', 1)
            ->get();

        $tahun = date('Y');
        $namaFile = 'LAPORAN INVENTARIS ASET BANGUNAN ' . $tahun . '.pdf';

        $data = [
            'logoProfil' => $logoProfil,
            'bangunan' => $bangunan,
            'alamat' => $alamat,
            'nama' => $nama,
            'email' => $email,
            'namaFile' => 'LAPORAN INVENTARIS ASET BANGUNAN ' . $tahun
        ];

        $pdf = PDF::loadView('sa.content.laporan.aset.bangunanCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }


    public function barangPDF()
    {
        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $KategoriBarang = KategoriBarang::get();
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

        $pdf = PDF::loadView('sa.content.laporan.aset.barangCetak', $data);
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

        $pdf = PDF::loadView('sa.content.laporan.aset.itemBarangCetak', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($namaFile);
    }

    //END PDF ====================================================================================================================================================



    //EXCEL=====================================================================================================================================================

    public function tanahExcel()
    {

        $tahun = date('Y');
        $tanahExport = new TanahExport(null, null, null, null);
        return Excel::download($tanahExport, 'LAPORAN INVENTARIS ASET TANAH ' . $tahun . '.xlsx');
    }

    public function bangunanExcel()
    {
        $tahun = date('Y');
        $bangunanExport = new BangunanExport(null, null, null, null, null, null);
        return Excel::download($bangunanExport, 'LAPORAN INVENTARIS ASET Bangunan ' . $tahun . '.xlsx');
    }

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


    //Filter Export ================================================================================================

    public function filterTanah(Request $request)
    {
        $lokasi = $request->lokasi;
        $sumber = $request->sumber;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $exportType = $request->input('export_type');
        $tahun = date('Y');
        if ($exportType === 'excel') {

            $tanahExport = new TanahExport($lokasi, $sumber, $tanggal_awal, $tanggal_akhir);

            return Excel::download($tanahExport, 'DATA_ASET_TANAH_FILTERED.xlsx');
        }

        if ($exportType === 'pdf') {
            $tanah = Tanah::select(
                'tanahs.kode_tanah',
                'tanahs.nama_tanah',
                'tanahs.lokasi',
                'tanahs.sumber',
                'tanahs.luas',
                'tanahs.tanggal_pengadaan',
                'tanahs.harga_perolehan',
                'tanahs.keterangan',
            )
                ->where('tanahs.status', 1);

            if ($lokasi) {
                $tanah->where(
                    'lokasi',
                    'LIKE',
                    '%' . $lokasi . '%'
                );
            }

            if ($sumber) {
                $tanah->where('sumber', $sumber);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $tanah->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal_pengadaan', '>=', $tanggal_awal)
                        ->whereDate('tanggal_pengadaan', '<=', $tanggal_akhir);
                });
            }

            $tanah = $tanah->get();
            $namaFile = 'LAPORAN INVENTARIS ASET TANAH ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'alamat' => $alamat,
                'email' => $email,
                'nama' => $nama,
                'tanah' => $tanah,
                'namaFile' => 'LAPORAN INVENTARIS ASET TANAH ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.aset.tanahCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }

    public function filterBangunan(Request $request)
    {
        $kondisi = $request->kondisi;
        $id_tanah = $request->id_tanah;
        $sumber = $request->sumber;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $profil = Profil::first();
        $logoProfil = $profil->logo;
        $alamat = $profil->alamat;
        $nama = $profil->nama_organisasi;
        $email = $profil->email;

        $tahun = date('Y');
        $exportType = $request->input('export_type');

        if ($exportType === 'excel') {

            $bangunanExport = new BangunanExport($kondisi, $id_tanah,  $sumber, $tanggal_awal, $tanggal_akhir);

            return Excel::download($bangunanExport, 'LAPORAN INVENTARIS ASET BANGUNAN ' . $tahun . '.xlsx');
        }

        if ($exportType === 'pdf') {

            $bangunanQuery = Bangunan::select(
                'tanahs.nama_tanah',
                'bangunans.kode_bangunan',
                'bangunans.nama_bangunan',
                'bangunans.deskripsi',
                'bangunans.harga_perolehan',
                'bangunans.kondisi',
                'bangunans.id_tanah',
                'bangunans.lokasi',
                'bangunans.sumber',
                'bangunans.tanggal_pengadaan',
                'bangunans.keterangan'
            )
                ->join('tanahs', 'tanahs.id_tanah', '=', 'bangunans.id_tanah')
                ->where('bangunans.status', '=', 1);

            if ($id_tanah) {
                $bangunanQuery->where('bangunans.id_tanah', $id_tanah);
            }

            if ($kondisi) {
                $bangunanQuery->where('kondisi', $kondisi);
            }

            if ($sumber) {
                $bangunanQuery->where('sumber', $sumber);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $bangunanQuery->where(function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    $query->whereDate('tanggal_pengadaan', '>=', $tanggal_awal)
                        ->whereDate('tanggal_pengadaan', '<=', $tanggal_akhir);
                });
            }

            $bangunan = $bangunanQuery->get();

            $namaFile = 'LAPORAN INVENTARIS ASET BANGUNAN ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'bangunan' => $bangunan,
                'alamat' => $alamat,
                'nama' => $nama,
                'email' => $email,
                'namaFile' => 'LAPORAN INVENTARIS ASET BANGUNAN ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.aset.bangunanCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
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

            $barangQuery = Barang::select(
                'barangs.kode_barang',
                'barangs.nama_barang',
                'kategori_barangs.nama_kategori_barang as nama',
                'kategori_barangs.kode_kategori_barang as kode'
            )
                ->join('kategori_barangs', 'kategori_barangs.id_kategori_barang', '=', 'barangs.id_kategori_barang')
                ->withCount(['item_barang' => function ($query) {
                    $query->where('status', 1);
                }]);

            if ($id_kategori_barang) {
                $barangQuery->where('barangs.id_kategori_barang', $id_kategori_barang);
            }
            $barang = $barangQuery->get();

            $namaFile = 'LAPORAN INVENTARIS ASET BARANG ' . $tahun . '.pdf';

            $data = [
                'logoProfil' => $logoProfil,
                'barang' => $barang,
                'alamat' => $alamat,
                'nama' => $nama,
                'email' => $email,
                'namaFile' => 'LAPORAN INVENTARIS ASET BARANG ' . $tahun
            ];

            $pdf = PDF::loadView('sa.content.laporan.aset.barangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
    public function filterItemBarang(Request $request)
    {
        $id_barang = $request->id_barang;
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

            $itemBarang = ItemBarang::select(
                'item_barangs.kode_item_barang',
                'item_barangs.nama_item_barang',
                'item_barangs.merk',
                'item_barangs.kondisi',
                'item_barangs.sumber',
                'item_barangs.tanggal_pengadaan',
                'item_barangs.harga_perolehan',
                'item_barangs.keterangan',
                'barangs.nama_barang'
            )
                ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
                ->where('item_barangs.status', 1);

            if ($id_barang) {
                $itemBarang->where('item_barangs.id_barang', $id_barang);
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

            $itemBarang = $itemBarang->get();


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

            $pdf = PDF::loadView('sa.content.laporan.aset.itemBarangCetak', $data);
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download($namaFile);
        }
    }
}
