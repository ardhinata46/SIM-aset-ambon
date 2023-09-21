<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $title = 'Data Kategori Barang';
        $kategoriBarang = KategoriBarang::latest()->get();

        return view('sa.content.kategori-barang.list', compact('title', 'kategoriBarang'));
    }

    public function add()
    {
        $title = 'Tambah Kategori Barang';
        $nextKodeKategoriBarang = KategoriBarang::generateKodeKategoriBarang();

        return view('sa.content.kategori-barang.add', compact('title', 'nextKodeKategoriBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori_barang' => 'required',
        ]);

        $nextKodeKategoriBarang = KategoriBarang::generateKodeKategoriBarang();
        // Simpan data ke database dengan menggunakan $nextKodeKategoriBarang
        $kategoriBarang = new KategoriBarang();
        $kategoriBarang->kode_kategori_barang = $nextKodeKategoriBarang;
        $kategoriBarang->nama_kategori_barang = $request->nama_kategori_barang;
        $kategoriBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;


        try {
            $kategoriBarang->save();
            return redirect(route('superadmin.kategori_barang.index'))->with('success', 'Kategori berhasil ditambah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.kategori_barang.index'))->with('error', 'Kategori gagal ditambah!');
        }
    }

    public function edit($id_kategori_barang)
    {
        $title = 'Ubah Data Kategori Barang';
        $kategoriBarang = KategoriBarang::findOrFail($id_kategori_barang);

        return view('sa.content.kategori-barang.edit', compact('title', 'kategoriBarang'));
    }


    public function update(Request $request, $id_kategori_barang)
    {
        $kategoriBarang = KategoriBarang::find($id_kategori_barang); // Mengambil data barang yang akan diubah
        $kategoriBarang->kode_kategori_barang = $request->kode_kategori_barang;
        $kategoriBarang->nama_kategori_barang = $request->nama_kategori_barang;
        $kategoriBarang->created_by = $request->created_by;
        $kategoriBarang->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

        try {
            $kategoriBarang->save();
            return redirect(route('superadmin.kategori_barang.index'))->with('success', 'Kategori berhasil diubah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.kategori_barang.index'))->with('error', 'Kategori gagal diubah!');
        }
    }

    public function detail($id_kategori_barang)
    {

        $title = 'Detail Data Kategori Barang';
        $kategoriBarang = KategoriBarang::findOrFail($id_kategori_barang);
        $barang = Barang::where('id_kategori_barang', $id_kategori_barang)
            ->withCount(['item_barang' => function ($query) {
                $query->where('status', 1);
            }])
            ->latest()->get();

        return view('sa.content.kategori-barang.detail', compact('title', 'kategoriBarang', 'barang'));
    }

    public function delete($id_kategori_barang)
    {
        $kategoriBarang = KategoriBarang::findOrFail($id_kategori_barang);

        try {
            $kategoriBarang->delete();
            return redirect(route('superadmin.kategori_barang.index'))->with('success', 'Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.kategori_barang.index'))->with('error', 'Kategori gagal dihapus!');
        }
    }
}
