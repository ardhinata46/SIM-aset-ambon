<?php

namespace App\Http\Controllers\SuperAdmin\PeminjamanBarang;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemPeminjamanBarang;
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

        return view('sa.content.pengembalian-barang.list', compact('title', 'pengembalianBarang'));
    }

    public function add()
    {
        $peminjaman = PeminjamanBarang::select(
            'peminjaman_barangs.*',
            'peminjaman_barangs.kode_peminjaman_barang',
            'peminjaman_barangs.status as status_barang',
            'item_peminjaman_barangs.*',
            'item_barangs.*')
            ->join('item_peminjaman_barangs', 'item_peminjaman_barangs.id_peminjaman_barang', '=', 'peminjaman_barangs.id_peminjaman_barang')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'item_peminjaman_barangs.id_item_barang')
            ->where('peminjaman_barangs.status', 0)->get();

        $dataPeminjaman = [];

        foreach ($peminjaman as $row) {
            $idPeminjaman = $row->id_peminjaman_barang;

            if (!isset($dataPeminjaman[$idPeminjaman])) {
                $dataPeminjaman[$idPeminjaman] = [
                    'id_peminjaman_barang' => $row->id_peminjaman_barang,
                    'kode_peminjaman_barang' => $row->kode_peminjaman_barang,
                    'tanggal' => $row->tanggal,
                    'status_barang' => $row->status_barang,
                    'nama_peminjam' => $row->nama_peminjam,
                    'kontak' => $row->kontak,
                    'alamat' => $row->alamat,
                    'jaminan' => $row->jaminan,
                    'item_barang' => [
                        [
                            'kode_item_barang' => $row->kode_item_barang,
                            'nama_item_barang' => $row->nama_item_barang,
                            'merk_item_barang' => $row->merk
                        ],
                    ],
                ];
            } else {
                $dataPeminjaman[$idPeminjaman]['item_barang'][] = [
                    'kode_item_barang' => $row->kode_item_barang,
                    'nama_item_barang' => $row->nama_item_barang,
                    'merk_item_barang' => $row->merk
                ];
            }
        }

        $dataPeminjaman = array_values($dataPeminjaman);

        $title = 'Tambah Pengambalian Barang ';

        $nextKodePengembalianBarang = PengembalianBarang::generateKodePengembalianBarang();

        return view('sa.content.pengembalian-barang.add', compact('title', 'peminjaman', 'nextKodePengembalianBarang', 'dataPeminjaman'));
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
            $pengembalianBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            $pengembalianBarang->save();

            // Perbarui status peminjaman
            $statusPeminjaman = PeminjamanBarang::find($request->id_peminjaman_barang);
            $statusPeminjaman->status = $pengembalianBarang->status ?? 1;
            $statusPeminjaman->save();

            DB::commit();
            return redirect(route('superadmin.pengembalian_barang.index'))->with('success', 'Pengembalian barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.pengembalian_barang.index'))->with('error', 'Pengembalian barang gagal ditambah!');
        }
    }

    public function delete($id_pengembalian_barang)
    {
        try {
            DB::beginTransaction();
            $pengembalianBarang = PengembalianBarang::findOrFail($id_pengembalian_barang);

            // Simpan ID peminjaman barang sebelum menghapus pengembalian
            $id_peminjaman_barang = $pengembalianBarang->id_peminjaman_barang;

            $pengembalianBarang->delete();

            // Perbarui status peminjaman
            $statusPeminjaman = PeminjamanBarang::find($id_peminjaman_barang);
            $statusPeminjaman->status = 0; // Set status peminjaman kembali ke 0k
            $statusPeminjaman->save();

            DB::commit();
            return redirect(route('superadmin.pengembalian_barang.index'))->with('success', 'Pengembalian barang berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.pengembalian_barang.index'))->with('error', 'Pengembalian barang gagal dihapus!');
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


        return view('sa.content.pengembalian-barang.edit', compact('title', 'pengembalianBarang', 'peminjaman'));
    }

    public function update(Request $request, $id_pengembalian_barang)
    {
        $pengembalianBarang = PengembalianBarang::findOrFail($id_pengembalian_barang);

        $peminjamanSebelumnya = PeminjamanBarang::findOrFail($pengembalianBarang->id_peminjaman_barang);
        $peminjamanSekarang = PeminjamanBarang::findOrFail($request->id_peminjaman_barang);
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
            $pengembalianBarang->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

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
            return redirect(route('superadmin.pengembalian_barang.index'))->with('success', 'Pengembalian barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.pengembalian_barang.index'))->with('error', 'Pengembalian barang gagal ditambah!');
        }
    }
}

//dd($e->getMessage());
