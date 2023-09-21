<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanBarang;
use App\Models\PengembalianBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianBarangController extends Controller
{
    public function index()
    {
        $title = 'Pengembalian Barang Pinjaman ';
        $pengembalianBarang = PengembalianBarang::select(
            "pengembalian_barangs.*",
            'peminjaman_barangs.kode_peminjaman_barang as kode',
            'peminjaman_barangs.tanggal as tanggal_peminjaman',
            'peminjaman_barangs.nama_peminjam as nama',
        )
            ->join('peminjaman_barangs', 'peminjaman_barangs.id_peminjaman_barang', '=', 'pengembalian_barangs.id_peminjaman_barang')
            ->latest()->get();

        return view('admin.content.pengembalian-barang.list', compact('title', 'pengembalianBarang'));
    }

    public function add()
    {

        $peminjaman = PeminjamanBarang::where('status', 0)->get();
        $title = 'Tambah Pengambalian Barang ';

        $nextKodePengembalianBarang = PengembalianBarang::generateKodePengembalianBarang();

        return view('admin.content.pengembalian-barang.add', compact('title', 'peminjaman', 'nextKodePengembalianBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pengembalian_barang' => 'required',
            'id_peminjaman_barang' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'nullable',
        ], [
            'id_peminjaman_barang.required' => 'Peminjaman harus dipilih',
        ]);
        try {
            DB::beginTransaction();

            $nextKodePengembalianBarang = PengembalianBarang::generateKodePengembalianBarang();

            $pengembalianBarang = new PengembalianBarang();
            $pengembalianBarang->kode_pengembalian_barang = $nextKodePengembalianBarang;
            $pengembalianBarang->id_peminjaman_barang = $request->id_peminjaman_barang;
            $pengembalianBarang->tanggal = $request->tanggal;
            $pengembalianBarang->keterangan = $request->keterangan;
            $pengembalianBarang->created_by = Auth::guard('admin')->user()->id_pengguna;

            $pengembalianBarang->save();

            // Perbarui status peminjaman 
            $statusPeminjaman = PeminjamanBarang::find($request->id_peminjaman_barang);
            $statusPeminjaman->status = $pengembalianBarang->status ?? 1;
            $statusPeminjaman->save();

            DB::commit();
            return redirect(route('admin.pengembalian_barang.index'))->with('success', 'Pengembalian barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('admin.pengembalian_barang.index'))->with('error', 'Pengembalian barang gagal ditambah!');
        }
    }
    public function edit(Request $request, $id_pengembalian_barang)
    {
        $title = 'Ubah Pengembalian Barang ';

        $pengembalianBarang = PengembalianBarang::findOrFail($id_pengembalian_barang);

        $peminjaman = PeminjamanBarang::where(function ($query) use ($pengembalianBarang) {
            $query->where('status', 0)
                ->orWhere('id_peminjaman_barang', $pengembalianBarang->id_peminjaman_barang);
        })
            ->get();


        return view('admin.content.pengembalian-barang.edit', compact('title', 'pengembalianBarang', 'peminjaman'));
    }

    public function update(Request $request, $id_pengembalian_barang)
    {

        $pengembalianBarang = PengembalianBarang::findOrFail($id_pengembalian_barang);

        $peminjamanSebelumnya = PeminjamanBarang::findOrFail($pengembalianBarang->id_peminjaman_barang);
        $peminjamanSekarang =  PeminjamanBarang::findOrFail($request->id_peminjaman_barang);
        $created = $pengembalianBarang->created_by;


        $request->validate([
            'kode_pengembalian_barang' => 'required',
            'id_peminjaman_barang' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ], [
            'id_peminjaman_barang.required' => 'Peminjaman harus dipilih',
        ]);
        try {
            DB::beginTransaction();
            $pengembalianBarang->kode_pengembalian_barang = $request->kode_pengembalian_barang;
            $pengembalianBarang->id_peminjaman_barang = $request->id_peminjaman_barang;
            $pengembalianBarang->tanggal = $request->tanggal;
            $pengembalianBarang->keterangan = $request->keterangan;
            $pengembalianBarang->created_by = $created;
            $pengembalianBarang->updated_by = Auth::guard('admin')->user()->id_pengguna;

            $pengembalianBarang->save();

            if ($peminjamanSekarang->id_peminjaman_barang == $peminjamanSebelumnya->id_peminjaman_barang) {
                // Ubah status peminjaman menjadi 1
                $peminjamanSebelumnya->status = 1;
                $peminjamanSebelumnya->save();
            } else {
                // Ubah status peminjaman sebelumnya menjadi 0
                $peminjamanSebelumnya->status = 0;
                $peminjamanSebelumnya->save();

                // Ubah status peminjaman sekarang menjadi 1
                $peminjamanSekarang->status = 1;
                $peminjamanSekarang->save();
            }


            DB::commit();
            return redirect(route('admin.pengembalian_barang.index'))->with('success', 'Pengembalian barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('admin.pengembalian_barang.index'))->with('error', 'Pengembalian barang gagal ditambah!');
        }
    }
}

//dd($e->getMessage());