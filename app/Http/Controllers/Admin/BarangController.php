<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\KategoriBarang;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $title = 'Data Barang ';
        $KategoriBarang = KategoriBarang::get();
        $barang = Barang::select('barangs.*', 'kategori_barangs.nama_kategori_barang as nama', 'kategori_barangs.kode_kategori_barang as kode')
            ->join('kategori_barangs', 'kategori_barangs.id_kategori_barang', '=', 'barangs.id_kategori_barang')
            ->withCount(['item_barang' => function ($query) {
                $query->where('status', 1);
            }])
            ->latest()->get();

        return view('admin.content.barang.list', compact('title', 'barang', 'KategoriBarang'));
    }

    public function add()
    {
        $title = 'Tambah Data Barang ';
        $kategoriBarang = KategoriBarang::get();
        $nextKodeBarang = Barang::generateKodeBarang();

        return view('admin.content.barang.add', compact('title', 'kategoriBarang', 'nextKodeBarang'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_kategori_barang'    => 'required',
                'nama_barang'           => 'required',
            ],
            [
                'id_kategori_barang.required'       => 'Kategori harus dipilih',
                'nama_barang.required'      => 'Nama Barang harus dipilih',
            ]
        );

        $nextKodeBarang = Barang::generateKodeBarang();

        $barang = new Barang();
        $barang->kode_barang        = $nextKodeBarang;
        $barang->id_kategori_barang = $request->id_kategori_barang;
        $barang->nama_barang        = $request->nama_barang;
        $barang->created_by         = Auth::guard('admin')->user()->id_pengguna;

        try {
            $barang->save();
            return redirect(route('admin.barang.index'))->with('success', 'Barang berhasil ditambah!');
        } catch (\Exception $e) {

            return redirect(route('admin.barang.index'))->with('error', 'Barang gagal ditambah!');
        }
    }

    public function edit($id_barang)
    {
        $title = 'Ubah Data Barang ';
        $kategoriBarang = KategoriBarang::get();
        $barang = Barang::findOrFail($id_barang);
        return view('admin.content.barang.edit', compact('title', 'kategoriBarang', 'barang'));
    }

    public function update(Request $request, $id_barang)
    {
        $request->validate(
            [
                'id_kategori_barang'    => 'required',
                'nama_barang'           => 'required',
            ],
            [
                'id_kategori_barang.required'       => 'Kategori harus dipilih',
                'nama_barang.required'      => 'Nama Barang harus dipilih',
            ]
        );

        $nextKodeBarang = Barang::generateKodeBarang();

        $barang = Barang::findOrFail($id_barang);
        $barang->kode_barang        = $nextKodeBarang;
        $barang->id_kategori_barang = $request->id_kategori_barang;
        $barang->nama_barang        = $request->nama_barang;
        $barang->created_by         = $request->created_by;
        $barang->updated_by         = Auth::guard('admin')->user()->id_pengguna;

        try {
            $barang->save();
            return redirect(route('admin.barang.index'))->with('success', 'Barang berhasil ditambah!');
        } catch (\Exception $e) {

            return redirect(route('admin.barang.index'))->with('error', 'Barang gagal ditambah!');
        }
    }

    public function delete($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);

        try {
            $barang->delete();
            return redirect(route('admin.barang.index'))->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('admin.barang.index'))->with('error', 'Barang gagal dihapus!');
        }
    }

    public function detail($id_barang)
    {
        $title = 'Detail Barang ';
        $barang = Barang::select('barangs.*', 'kategori_barangs.kode_kategori_barang', 'kategori_barangs.nama_kategori_barang as nama', 'kategori_barangs.kode_kategori_barang as kode')
            ->join('kategori_barangs', 'kategori_barangs.id_kategori_barang', '=', 'barangs.id_kategori_barang')
            ->where('barangs.id_barang', $id_barang)
            ->first();

        $itemBarang = ItemBarang::where('id_barang', $id_barang)
            ->where('status', 1)
            ->latest()->get();

        return view('admin.content.barang.detail', compact('title', 'barang', 'itemBarang'));
    }

    public function addKategori()
    {

        $title = 'Tambah Kategori Barang ';
        $nextKodeKategoriBarang = KategoriBarang::generateKodeKategoriBarang();

        return view('admin.content.barang.addKategori', compact('title', 'nextKodeKategoriBarang'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori_barang' => 'required',
        ]);

        $nextKodeKategoriBarang = KategoriBarang::generateKodeKategoriBarang();
        $kategoriBarang = new KategoriBarang();
        $kategoriBarang->kode_kategori_barang = $nextKodeKategoriBarang;
        $kategoriBarang->nama_kategori_barang = $request->nama_kategori_barang;
        $kategoriBarang->created_by = Auth::guard('admin')->user()->id_pengguna;

        try {
            $kategoriBarang->save();
            return redirect(route('admin.barang.add'))->with('success', 'Kategori berhasil ditambah!');
        } catch (\Exception $e) {
            return redirect(route('admin.barang.add'))->with('error', 'Kategori gagal ditambah!');
        }
    }

    public function addItem($id_barang)
    {
        $title = 'Tambah Item Barang | Inventaris GPIBI';
        $barang = Barang::findOrfail($id_barang);

        return view('admin.content.barang.addItem', compact('title', 'barang'));
    }

    public function storeItem(Request $request, $id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        try {
            DB::beginTransaction();

            $barang = $barang->id_barang;
            $namaItemBarang = $request->input('nama_item_barang');
            $merk = $request->input('merk');
            $kondisi = $request->input('kondisi');
            $sumber = $request->input('sumber');
            $tanggalPengadaan = $request->input('tanggal_pengadaan');
            $hargaPerolehan = str_replace('.', '', $request->harga_perolehan);
            $umurManfaat = $request->input('umur_manfaat');
            $nilaiResidu = str_replace('.', '', $request->nilai_residu);
            $keterangan = $request->input('keterangan');
            $created_by = Auth::guard('admin')->user()->id_pengguna;

            $jumlah = $request->input('jumlah');

            // Simpan data sebanyak jumlah
            for ($i = 0; $i < $jumlah; $i++) {

                // Membuat kode barang unik
                $nextKodeItemBarang = ItemBarang::generateKodeItemBarang();
                ItemBarang::create([
                    'id_barang' => $barang,
                    'kode_item_barang' => $nextKodeItemBarang,
                    'nama_item_barang' => $namaItemBarang,
                    'merk' => $merk,
                    'kondisi' => $kondisi,
                    'sumber' => $sumber,
                    'tanggal_pengadaan' => $tanggalPengadaan,
                    'harga_perolehan' => $hargaPerolehan,
                    'umur_manfaat' => $umurManfaat,
                    'nilai_residu' => $nilaiResidu,
                    'keterangan' => $keterangan,
                    'created_by' => $created_by,
                ]);
            }

            DB::commit();
            return redirect(route('admin.barang.detail', $id_barang))->with('success', 'Item barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('admin.barang.detail', $id_barang))->with('error', 'Item barang gagal ditambah!');
        }
    }

    public function detailItem($id_item_barang)
    {
        $title = 'Detail Item Barang | Inventaris GPIB AA';
        $itemBarang = ItemBarang::select('item_barangs.*', 'barangs.nama_barang as nama_barang', 'barangs.kode_barang as kode_barang')
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->where('item_barangs.status', 1)
            ->first();

        $id_barang = $itemBarang->id_barang;
        return view('admin.content.barang.detailItem', compact('title', 'itemBarang', 'id_barang'));
    }

    public function editItem($id_item_barang)
    {
        $title = 'Ubah Item Barang | Inventaris GPIB AA';
        $barang = Barang::get();
        $itemBarang = ItemBarang::select('item_barangs.*', 'barangs.nama_barang as nama_barang', 'barangs.kode_barang as kode_barang')
            ->join('barangs', 'barangs.id_barang', '=', 'item_barangs.id_barang')
            ->where('item_barangs.id_item_barang', $id_item_barang)
            ->where('item_barangs.status', 1)
            ->first();

        $id_barang = $itemBarang->id_barang;
        return view('admin.content.barang.editItem', compact('title', 'itemBarang', 'id_barang', 'barang'));
    }

    public function updateItem(Request $request, $id_item_barang)
    {
        $itemBarang = ItemBarang::findOrFail($id_item_barang);
        $id_barang = $itemBarang->id_barang;

        $request->validate([
            'id_barang'             => 'required',
            'nama_item_barang'      => 'required',
            'merk'                  => 'nullable',
            'kondisi'               => 'required',
            'sumber'                => 'required',
            'tanggal_pengadaan'     => 'required',
            'harga_perolehan'       => 'required',
            'umur_manfaat'          => 'required',
            'nilai_residu'          => 'required',
            'keterangan'            => 'nullable',
        ], [
            'sumber.required'       => 'Sumber harus dipilih',
            'kondisi.required'      => 'kondisi harus dipilih',
        ]);

        $itemBarang->id_barang              = $request->id_barang;
        $itemBarang->kode_item_barang       = $request->kode_item_barang;
        $itemBarang->nama_item_barang       = $request->nama_item_barang;
        $itemBarang->merk                   = $request->merk;
        $itemBarang->kondisi                = $request->kondisi;
        $itemBarang->sumber                 = $request->sumber;
        $itemBarang->tanggal_pengadaan      = $request->tanggal_pengadaan;
        $itemBarang->harga_perolehan        = str_replace('.', '', $request->harga_perolehan);
        $itemBarang->umur_manfaat           = $request->umur_manfaat;
        $itemBarang->nilai_residu           = str_replace('.', '', $request->nilai_residu);
        $itemBarang->keterangan             = $request->keterangan;
        $itemBarang->created_by             = $request->created_by;
        $itemBarang->updated_by             = Auth::guard('admin')->user()->id_pengguna;

        try {
            $itemBarang->save();
            return redirect(route('admin.barang.detail', $id_barang))->with('success', 'Item barang berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('admin.barang.detail', $id_barang))->with('error', 'Item barang gagal diubah!');
        }
    }

    public function deleteItem($id_item_barang)
    {
        $itemBarang = ItemBarang::findOrFail($id_item_barang);
        $id_barang = $itemBarang->id_barang;
        try {
            $itemBarang->delete();
            return redirect(route('admin.barang.detail', $id_barang))->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('admin.barang.detail', $id_barang))->with('error', 'Barang gagal dihapus!');
        }
    }
}

// dd($e->getMessage());
