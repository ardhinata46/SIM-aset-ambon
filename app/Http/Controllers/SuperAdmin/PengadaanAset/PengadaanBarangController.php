<?php

namespace App\Http\Controllers\SuperAdmin\PengadaanAset;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemBarang;
use App\Models\ItemPengadaanBarang;
use App\Models\KategoriBarang;
use App\Models\PengadaanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PengadaanBarangController extends Controller
{
    public function index()
    {
        $title = "Pengadaan Aset Barang ";
        $pengadaanBarang = PengadaanBarang::all();

        return view('sa.content.pengadaan-barang.list', compact('title', 'pengadaanBarang'));
    }

    public function addBarang()
    {
        $title = 'Tambah Data Barang ';
        $kategoriBarang = KategoriBarang::get();
        $nextKodeBarang = Barang::generateKodeBarang();

        return view('sa.content.pengadaan-barang.addBarang', compact('title', 'kategoriBarang', 'nextKodeBarang'));
    }

    public function storeBarang(Request $request)
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
        $barang->created_by         = Auth::guard('superadmin')->user()->id_pengguna;

        try {
            $barang->save();
            return redirect(route('superadmin.pengadaan_barang.add'))->with('success', 'Barang berhasil ditambah!');
        } catch (\Exception $e) {

            return redirect(route('superadmin.pengadaan_barang.add'))->with('error', 'Barang gagal ditambah!');
        }
    }

    public function add()
    {
        $kategoriBarang = KategoriBarang::get();
        $title = 'Pengadaan Barang Inventaris ';
        $barang = Barang::all();
        $nextKodePengadaanBarang = PengadaanBarang::generateKodePengadaanBarang();

        return view('sa.content.pengadaan-barang.add', compact('title', 'nextKodePengadaanBarang', 'kategoriBarang', 'barang'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'tanggal_pengadaan' => 'required',
            'sumber' => 'required',
            'keterangan' => 'nullable',
            'nota' => 'nullable',
        ], [
            'tanggal_pengadaan.required' => 'Tanggal Pengadaan harus diisi.',
            'sumber.required' => 'Sumber harus dipilih.',
        ]);

        try {
            DB::beginTransaction();

            $nextKodePengadaanBarang = PengadaanBarang::generateKodePengadaanBarang();
            $pengadaanBarang = new PengadaanBarang();
            $pengadaanBarang->kode_pengadaan_barang = $nextKodePengadaanBarang;

            $pengadaanBarang->tanggal_pengadaan = $request->tanggal_pengadaan;
            $pengadaanBarang->sumber = $request->sumber;
            $pengadaanBarang->keterangan = $request->keterangan;
            $pengadaanBarang->created_by = Auth::guard('superadmin')->user()->id_pengguna;

            // Cek apakah ada file foto yang diunggah
            if ($request->hasFile('nota')) {
                $nota = $request->file('nota');
                $notaPath = public_path('nota');

                if (!File::exists($notaPath)) {
                    File::makeDirectory($notaPath, 0777, true, true);
                }

                $notaName = time() . '.' . $nota->getClientOriginalExtension();
                $nota->move($notaPath, $notaName);
                $pengadaanBarang->nota = 'nota/' . $notaName;
            }

            $pengadaanBarang->save();

            $itemBarangs = $request->input('nama_item_barang', []);
            $merk = $request->input('merk', []);
            $jumlah = $request->input('jumlah', []);
            $idBarang = $request->input('id_barang', []);
            $hargaPerolehan = $request->input('harga_perolehan', []);
            $umurManfaat = $request->input('umur_manfaat', []);
            $nilaiResidu = $request->input('nilai_residu', []);

            // Menghapus tanda titik dari harga perolehan
            $hargaPerolehan = array_map(function ($harga) {
                return str_replace('.', '', $harga);
            }, $hargaPerolehan);

            // Menghapus tanda titik dari nilai residu
            $nilaiResidu = array_map(function ($nilai) {
                return str_replace('.', '', $nilai);
            }, $nilaiResidu);

            foreach ($itemBarangs as $index => $namaItemBarang) {
                $itemBarang = new ItemPengadaanBarang();
                $itemBarang->id_pengadaan_barang = $pengadaanBarang->id_pengadaan_barang;
                $itemBarang->id_barang = $idBarang[$index];
                $itemBarang->nama_item_barang = $namaItemBarang;
                $itemBarang->merk = $merk[$index];
                $itemBarang->harga_perolehan = $hargaPerolehan[$index];
                $itemBarang->umur_manfaat = $umurManfaat[$index];
                $itemBarang->nilai_residu = $nilaiResidu[$index];
                $itemBarang->jumlah = $jumlah[$index];
                $itemBarang->save();
            }

            // Input ke tabel item barang sebanyak jumlah
            foreach ($itemBarangs as $index => $namaItemBarang) {
                for ($i = 0; $i < $jumlah[$index]; $i++) {
                    $nextKodeItemBarang = ItemBarang::generateKodeItemBarang();
                    ItemBarang::create([
                        'id_pengadaan_barang' => $pengadaanBarang->id_pengadaan_barang,
                        'id_barang' => $idBarang[$index],
                        'kode_item_barang' => $nextKodeItemBarang,
                        'nama_item_barang' => $namaItemBarang,
                        'merk' => $merk[$index],
                        'sumber' => $request->sumber,
                        'tanggal_pengadaan' => $request->tanggal_pengadaan,
                        'harga_perolehan' => $hargaPerolehan[$index],
                        'umur_manfaat' => $umurManfaat[$index],
                        'nilai_residu' => $nilaiResidu[$index],
                        'keterangan' => $request->keterangan,
                        'created_by' => Auth::guard('superadmin')->user()->id_pengguna,
                    ]);
                }
            }

            DB::commit();

            return redirect(route('superadmin.pengadaan_barang.index'))->with('success', 'Pengadaan barang berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect(route('superadmin.pengadaan_barang.index'))->with('error', 'Pengadaan barang gagal ditambah!');
        }
    }


    public function detail($id_pengadaan_barang)
    {
        $title = 'Detail Pengadaan Barang Inventaris ';
        $detail = PengadaanBarang::findOrFail($id_pengadaan_barang);
        $item = ItemPengadaanBarang::select('item_pengadaan_barangs.*', 'barangs.nama_barang as nama_barang')
            ->join('barangs', 'barangs.id_barang', '=', 'item_pengadaan_barangs.id_barang')
            ->where('id_pengadaan_barang', $id_pengadaan_barang)
            ->get();

        return view('sa.content.pengadaan-barang.detail', compact('title', 'detail', 'item'));
    }


    public function delete($id_pengadaan_barang)
    {
        $pengadaanBarang = PengadaanBarang::findOrFail($id_pengadaan_barang);

        try {
            $pengadaanBarang->delete();
            return redirect(route('superadmin.pengadaan_barang.index'))->with('success', 'Pengadaan barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.pengadaan_barang.index'))->with('error', 'Pengadaan barang gagal dihapus!');
        }
    }

    public function edit($id_pengadaan_barang)
    {
        $title = "Ubah Pengadan Barang ";
        $pengadaanBarang = PengadaanBarang::findOrFail($id_pengadaan_barang);

        return view('sa.content.pengadaan-barang.edit', compact('title', 'pengadaanBarang'));
    }

    public function update(Request $request, $id_pengadaan_barang)
    {

        $pengadaanBarang = PengadaanBarang::findOrFail($id_pengadaan_barang);
        $created = $pengadaanBarang->created_by;
        $pengadaanBarang->tanggal_pengadaan = $request->tanggal_pengadaan;
        $pengadaanBarang->sumber = $request->sumber;
        $pengadaanBarang->keterangan = $request->keterangan;
        $pengadaanBarang->created_by = $created;
        $pengadaanBarang->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

        // Upload file nota
        if ($request->hasFile('nota')) {
            $nota = $request->file('nota');
            $notaPath = public_path('nota');

            if (!File::exists($notaPath)) {
                File::makeDirectory($notaPath, 0777, true, true);
            }

            $notaName = time() . '.' . $nota->getClientOriginalExtension();
            $nota->move($notaPath, $notaName);
            $pengadaanBarang->nota = 'nota/' . $notaName;
        } else {
            // Gunakan nota lama jika tidak ada nota baru yang diunggah
            $pengadaanBarang->nota = $pengadaanBarang->nota;
        }
        try {
            $pengadaanBarang->save();
            return redirect(route('superadmin.pengadaan_barang.index'))->with('success', 'Pengadaan barang berhasil diubah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.pengadaan_barang.index'))->with('error', 'Pengadaan barang gagal diubah!');
        }
    }
}
