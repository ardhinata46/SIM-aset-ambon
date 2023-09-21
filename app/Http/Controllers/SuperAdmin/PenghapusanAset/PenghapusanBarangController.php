<?php

namespace App\Http\Controllers\SuperAdmin\PenghapusanAset;

use App\Http\Controllers\Controller;
use App\Models\ItemBarang;
use App\Models\PenghapusanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenghapusanBarangController extends Controller
{
    public function index()
    {
        $title = 'Penghapusan Aset Barang';
        $penghapusanBarang = PenghapusanBarang::select("penghapusan_barangs.*", 'item_barangs.nama_item_barang as barang', 'item_barangs.kode_item_barang as kode')
            ->join('item_barangs', 'item_barangs.id_item_barang', '=', 'penghapusan_barangs.id_item_barang')
            ->latest()->get();

        return view('sa.content.penghapusan-barang.list', compact('title', 'penghapusanBarang'));
    }

    public function add()
    {
        $title = 'Penghapusan Aset Barang';
        $barang = ItemBarang::where('status', 1)->get();
        $nextKodePenghapusanBarang = PenghapusanBarang::generateKodePenghapusanBarang();


        return view('sa.content.penghapusan-barang.add', compact('title', 'barang', 'nextKodePenghapusanBarang'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'tanggal' => 'required',
            'id_item_barang' => 'required',
            'tindakan' => 'required',
            'alasan' => 'required',
            'keterangan' => 'nullable',
            'harga' => 'nullable',
        ], [
            'id_item_barang.required' => 'Bangunan harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
            'alasan.required' => 'Alasan harus dipilih',
        ]);

        $nextKodePenghapusanBarang = PenghapusanBarang::generateKodePenghapusanBarang();
        $barang = ItemBarang::findOrFail($request->id_item_barang);

        try {
            DB::beginTransaction();

            $penghapusanBarang = new PenghapusanBarang();
            $barangSebelumnya = $penghapusanBarang->id_tanah;
            $kembalikanStatus = 1;

            $penghapusanBarang->id_item_barang  = $request->id_item_barang;
            $penghapusanBarang->kode_penghapusan_barang = $nextKodePenghapusanBarang;
            $penghapusanBarang->tanggal = $request->tanggal;
            $penghapusanBarang->tindakan = $request->tindakan;
            $penghapusanBarang->alasan = $request->alasan;
            $penghapusanBarang->keterangan = $request->keterangan;
            $penghapusanBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            if ($request->tindakan !== 'jual') {
                $penghapusanBarang->harga = null;
            } else {
                $penghapusanBarang->harga = $request->harga;
            }

            $penghapusanBarang->save();

            DB::commit();
            return redirect(route('superadmin.penghapusan_barang.index'))->with('success', 'Penghapusan Barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.penghapusan_barang.index'))->with('error', 'Penghapusan Barang gagal ditambah!');
        }
    }

    public function delete($id_penghapusan_barang)
    {
        try {
            DB::beginTransaction();
            $penghapusanBarang = PenghapusanBarang::findOrFail($id_penghapusan_barang);
            $barang = ItemBarang::findOrFail($penghapusanBarang->id_item_barang);

            $penghapusanBarang->delete();

            // Mengupdate status barang menjadi 1
            $barang->status = 1;
            $barang->save();

            DB::commit();
            return redirect(route('superadmin.penghapusan_barang.index'))->with('success', 'Penghapusan Barang berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.penghapusan_barang.index'))->with('error', 'Penghapusan Barang gagal diubah!');
        }
    }

    public function edit($id_penghapusan_barang)
    {
        $title = 'Ubah Penghapusan Aset Barang';
        $penghapusanBarang = PenghapusanBarang::findOrFail($id_penghapusan_barang);
        $barang = ItemBarang::whereIn('status', [1]) // Memanggil barang dengan status 1
            ->orWhere(function ($query) use ($penghapusanBarang) {
                $query->whereIn('status', [0])
                    ->whereIn('id_item_barang', [$penghapusanBarang->id_item_barang]);
            })
            ->get();

        return view('sa.content.penghapusan-barang.edit', compact('title', 'barang', 'penghapusanBarang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required',
            'id_item_barang' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'nullable',
        ], [
            'id_item_barang.required' => 'barang harus dipilih',
            'tindakan.required' => 'Tindakan harus dipilih',
        ]);

        try {
            DB::beginTransaction();

            $penghapusanBarang = PenghapusanBarang::findOrFail($id);
            $barangSebelumnya = ItemBarang::findOrFail($penghapusanBarang->id_item_barang);
            $barangTerpilih = ItemBarang::findOrFail($request->id_item_barang);

            // Mengubah status barang sebelumnya menjadi 1
            $barangSebelumnya->status = 1;
            $barangSebelumnya->save();

            // Mengubah status barang yang dipilih menjadi 0
            $barangTerpilih->status = 0;
            $barangTerpilih->save();

            // Memperbarui data penghapusan barang
            $penghapusanBarang->tanggal = $request->tanggal;
            $penghapusanBarang->id_item_barang = $request->id_item_barang;
            $penghapusanBarang->tindakan = $request->tindakan;
            $penghapusanBarang->alasan = $request->alasan;
            $penghapusanBarang->keterangan = $request->keterangan;
            $penghapusanBarang->created_by = $request->created_by;
            $penghapusanBarang->updated_by = Auth::guard('superadmin')->user()->id_pengguna;
            $penghapusanBarang->save();

            DB::commit();
            return redirect(route('superadmin.penghapusan_barang.index'))->with('success', 'Penghapusan Barang berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('superadmin.penghapusan_barang.index'))->with('error', 'Penghapusan Barang gagal dihapus!');
        }
    }
}
