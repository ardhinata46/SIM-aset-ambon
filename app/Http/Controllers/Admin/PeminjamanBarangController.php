<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemBarang;
use App\Models\ItemPeminjamanBarang;
use App\Models\PeminjamanBarang;
use App\Models\PengembalianBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanBarangController extends Controller
{
    public function index()
    {
        $title = 'Peminjaman Barang | Invetaris GPIBI AA';
        $peminjamanBarang = PeminjamanBarang::with('pengembalianBarang')->orderBy('status', 'asc')->latest()->get();

        return view('admin.content.peminjaman-barang.list', compact('title', 'peminjamanBarang'));
    }

    public function add()
    {
        $title = 'Tambah Peminjaman Barang | Invetaris GPIBI AA';
        //tampilkan semua item barang, kecuali item barang yang sudah di pinjam dan status peminjaman belum dikembalikan (0)
        $itemBarang = ItemBarang::whereNotIn('id_item_barang', function ($query) {
            $query->select('id_item_barang')
                ->from('item_peminjaman_barangs')
                ->join('peminjaman_barangs', 'item_peminjaman_barangs.id_peminjaman_barang', '=', 'peminjaman_barangs.id_peminjaman_barang')
                ->where('peminjaman_barangs.status', 0);
        })->get();

        $nextKodePeminjamanBarang = PeminjamanBarang::generateKodePeminjamanBarang();

        return view('admin.content.peminjaman-barang.add', compact('title', 'nextKodePeminjamanBarang', 'itemBarang'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'kontak' => ['required', 'regex:/^(\+62|0)[0-9]{9,}$/'],
        ], [
            'kontak.regex' => 'Format telp salah',
        ]);

        $nextKodePeminjamanBarang = PeminjamanBarang::generateKodePeminjamanBarang();
        try {

            DB::beginTransaction();
            // Simpan data peminjaman barang
            $peminjamanBarang = new PeminjamanBarang;
            $peminjamanBarang->kode_peminjaman_barang = $nextKodePeminjamanBarang;
            $peminjamanBarang->nama_peminjam = $request->nama_peminjam;
            $peminjamanBarang->kontak = $request->kontak;
            $peminjamanBarang->tanggal = $request->tanggal;
            $peminjamanBarang->alamat = $request->alamat;
            $peminjamanBarang->jaminan = $request->jaminan;
            $peminjamanBarang->created_by = Auth::guard('admin')->user()->id_pengguna;

            $peminjamanBarang->save();

            // Simpan item barang
            $idPeminjamanBarang = $peminjamanBarang->id_peminjaman_barang;
            $idItemBarangSelect = $request->idItemBarangSelect;

            foreach ($idItemBarangSelect as $idItemBarang) {
                $itemPeminjaman = new ItemPeminjamanBarang();
                $itemPeminjaman->id_peminjaman_barang = $idPeminjamanBarang;
                $itemPeminjaman->id_item_barang = $idItemBarang;
                $itemPeminjaman->save();
            }

            DB::commit();
            return redirect(route('admin.peminjaman_barang.index'))->with('success', 'Peminjaman barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('admin.peminjaman_barang.index'))->with('error', 'Peminjaman barang gagal ditambah!');
        }
    }

    public function detail($id_peminjaman_barang)
    {
        $title = 'Detail Peminjaman Barang';
        $detail = PeminjamanBarang::findOrFail($id_peminjaman_barang);
        $items = ItemPeminjamanBarang::join('item_barangs', 'item_peminjaman_barangs.id_item_barang', '=', 'item_barangs.id_item_barang')
            ->where('item_peminjaman_barangs.id_peminjaman_barang', $id_peminjaman_barang)
            ->select('item_peminjaman_barangs.*', 'item_barangs.nama_item_barang', 'item_barangs.kode_item_barang')
            ->get();


        return view('admin.content.peminjaman-barang.detail', compact('title', 'detail', 'items'));
    }

    public function edit($id_peminjaman_barang)
    {
        $title = "Ubah Peminjaman Barang";

        $peminjamanBarang = PeminjamanBarang::findOrFail($id_peminjaman_barang);

        return view('admin.content.peminjaman-barang.edit', compact('peminjamanBarang', 'title'));
    }

    public function update(Request $request, $id_peminjaman_barang)
    {
        $request->validate([
            'kontak' => ['required', 'regex:/^(\+62|0)[0-9]{9,}$/'],
        ], [
            'kontak.regex' => 'Format telp salah',
        ]);

        // Simpan data peminjaman barang
        $peminjamanBarang = PeminjamanBarang::findOrFail($id_peminjaman_barang);
        $created = $peminjamanBarang->created_by;
        $peminjamanBarang->kode_peminjaman_barang = $request->kode_peminjaman_barang;
        $peminjamanBarang->nama_peminjam = $request->nama_peminjam;
        $peminjamanBarang->kontak = $request->kontak;
        $peminjamanBarang->tanggal = $request->tanggal;
        $peminjamanBarang->alamat = $request->alamat;
        $peminjamanBarang->jaminan = $request->jaminan;
        $peminjamanBarang->created_by = $created;
        $peminjamanBarang->updated_by = Auth::guard('admin')->user()->id_pengguna;

        try {
            $peminjamanBarang->save();
            return redirect(route('admin.peminjaman_barang.index'))->with('success', 'Peminjaman barang berhasil diubah!');
        } catch (\Exception $e) {
            return redirect(route('admin.peminjaman_barang.index'))->with('error', 'Peminjaman barang gagal diubah!');
        }
    }

    public function pengembalian($id_peminjaman_barang)
    {
        $title = 'Pengembalian Barang';

        $peminjamanBarang = PeminjamanBarang::findOrFail($id_peminjaman_barang);
        $items = ItemPeminjamanBarang::join('item_barangs', 'item_peminjaman_barangs.id_item_barang', '=', 'item_barangs.id_item_barang')
            ->where('item_peminjaman_barangs.id_peminjaman_barang', $id_peminjaman_barang)
            ->select('item_peminjaman_barangs.*', 'item_barangs.nama_item_barang', 'item_barangs.kode_item_barang')
            ->simplePaginate(10);

        $nextKodePengembalianBarang = PengembalianBarang::generateKodePengembalianBarang();

        return view('admin.content.peminjaman-barang.addPengembalian', compact('title', 'nextKodePengembalianBarang', 'peminjamanBarang', 'items'));
    }

    public function storePengembalian(Request $request, $id_peminjaman_barang)
    {
        $request->validate([
            'kode_pengembalian_barang' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'nullable',
        ], [
            'id_peminjaman_barang.required' => 'Peminjaman harus dipilih',
        ]);

        $peminjamanBarang = PeminjamanBarang::findOrFail($id_peminjaman_barang);
        $idPeminjamanBarang = $peminjamanBarang->id_peminjaman_barang;

        try {
            DB::beginTransaction();

            $nextKodePengembalianBarang = PengembalianBarang::generateKodePengembalianBarang();

            $pengembalianBarang = new PengembalianBarang();
            $pengembalianBarang->kode_pengembalian_barang = $nextKodePengembalianBarang;
            $pengembalianBarang->id_peminjaman_barang = $idPeminjamanBarang;
            $pengembalianBarang->tanggal = $request->tanggal;
            $pengembalianBarang->keterangan = $request->keterangan;
            $pengembalianBarang->created_by = Auth::guard('admin')->user()->id_pengguna;

            $pengembalianBarang->save();

            // Perbarui status peminjaman 
            $statusPeminjaman = PeminjamanBarang::findOrFail($id_peminjaman_barang);
            $statusPeminjaman->status = $pengembalianBarang->status ?? 1;
            $statusPeminjaman->save();

            DB::commit();
            return redirect(route('admin.peminjaman_barang.index'))->with('success', 'Pengembalian barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('admin.peminjaman_barang.index'))->with('error', 'Pengembalian barang gagal ditambah!');
        }
    }

    public function belumKembali()
    {
        $title = 'Barang Belum Dikembalikan';

        $items = DB::table('item_barangs')
            ->leftJoin('item_peminjaman_barangs', 'item_barangs.id_item_barang', '=', 'item_peminjaman_barangs.id_item_barang')
            ->leftJoin('peminjaman_barangs', 'item_peminjaman_barangs.id_peminjaman_barang', '=', 'peminjaman_barangs.id_peminjaman_barang')
            ->select('item_barangs.kode_item_barang', 'item_barangs.nama_item_barang', 'peminjaman_barangs.*')
            ->where('peminjaman_barangs.status', 0)
            ->get();

        return view('admin.content.peminjaman-barang.belumKembali', compact('title', 'items'));
    }
}

//dd($e->getMessage());
