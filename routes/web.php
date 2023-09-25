<?php

use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\CetakKodeController as AdminCetakKodeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InventarisBarangController as AdminInventarisBarangController;
use App\Http\Controllers\Admin\KategoriBarangController as AdminKategoriBarangController;
use App\Http\Controllers\Admin\Laporan\LaporanAsetController as LaporanLaporanAsetController;
use App\Http\Controllers\Admin\Laporan\LaporanPeminjamanBarangController as LaporanLaporanPeminjamanBarangController;
use App\Http\Controllers\Admin\Laporan\LaporanPerawatanBarangController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\PeminjamanBarangController as AdminPeminjamanBarangController;
use App\Http\Controllers\Admin\PengadaanBarangController as AdminPengadaanBarangController;
use App\Http\Controllers\Admin\PengembalianBarangController as AdminPengembalianBarangController;
use App\Http\Controllers\Admin\PerawatanBarangController as AdminPerawatanBarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\AlokasiBarang\MutasiBarangController;
use App\Http\Controllers\SuperAdmin\AlokasiBarang\PenempatanBarangController;
use App\Http\Controllers\SuperAdmin\CetakKodeController;
use App\Http\Controllers\superAdmin\PenggunaController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\DataInventaris\InventarisBangunanController;
use App\Http\Controllers\superAdmin\DataInventaris\InventarisBarangController;
use App\Http\Controllers\SuperAdmin\DataInventaris\InventarisTanahController;
use App\Http\Controllers\SuperAdmin\DataMaster\BangunanController;
use App\Http\Controllers\SuperAdmin\DataMaster\BarangController;
use App\Http\Controllers\SuperAdmin\DataMaster\KategoriBarangController;
use App\Http\Controllers\SuperAdmin\DataMaster\RuanganController;
use App\Http\Controllers\SuperAdmin\DataMaster\TanahController;
use App\Http\Controllers\SuperAdmin\DepresiasiApresiasi\PenyusutanBangunanController;
use App\Http\Controllers\SuperAdmin\DepresiasiApresiasi\PenyusutanBarangController;
use App\Http\Controllers\Superadmin\Laporan\LaporanAsetController;
use App\Http\Controllers\Superadmin\Laporan\LaporanPeminjamanBarangController;
use App\Http\Controllers\Superadmin\Laporan\LaporanPengadaanAsetController;
use App\Http\Controllers\Superadmin\Laporan\LaporanPenghapusanAsetController;
use App\Http\Controllers\Superadmin\Laporan\LaporanPerawatanAsetController;
use App\Http\Controllers\SuperAdmin\PeminjamanBarang\PeminjamanBarangController;
use App\Http\Controllers\SuperAdmin\PeminjamanBarang\PengembalianBarangController;
use App\Http\Controllers\SuperAdmin\PengadaanAset\PengadaanBangunanController;
use App\Http\Controllers\SuperAdmin\PengadaanAset\PengadaanBarangController;
use App\Http\Controllers\SuperAdmin\PengadaanAset\PengadaanTanahController;
use App\Http\Controllers\SuperAdmin\PenghapusanAset\PenghapusanBangunanController;
use App\Http\Controllers\SuperAdmin\PenghapusanAset\PenghapusanBarangController;
use App\Http\Controllers\SuperAdmin\PenghapusanAset\PenghapusanTanahController;
use App\Http\Controllers\SuperAdmin\PerawatanAset\PerawatanBangunanController;
use App\Http\Controllers\SuperAdmin\PerawatanAset\PerawatanBarangController;
use App\Http\Controllers\SuperAdmin\ProfilController;
use App\Http\Controllers\User\BangunanController as UserBangunanController;
use App\Http\Controllers\User\BarangController as UserBarangController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\InventarisBangunanController as UserInventarisBangunanController;
use App\Http\Controllers\User\InventarisBarangController as UserInventarisBarangController;
use App\Http\Controllers\User\InventarisTanahController as UserInventarisTanahController;
use App\Http\Controllers\User\KategoriBarangController as UserKategoriBarangController;
use App\Http\Controllers\User\TanahController as UserTanahController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route login
Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');

//Log Out
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');


// Route Lupa sandi
Route::get('/reset-password', [AuthController::class, 'reset'])->name('auth.reset');
Route::post('/forgot', [AuthController::class, 'forgot'])->name('auth.forgot');

Route::post('/renew-password', [AuthController::class, 'renew'])->name('auth.renew');
Route::get('/renew-password/{email}/{remember_token}', [AuthController::class, 'password'])->name('auth.password');


//Route Super Admin ==================================================================================================================================
Route::group(
    ['middleware' => 'auth:superadmin'],
    function () {
        Route::prefix('superadmin')->group(function () {

            // Route kelola dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard.index');

            // Route kelola dashboard
            Route::get('/profil-sttii', [ProfilController::class, 'index'])->name('superadmin.profil.index');
            Route::get('/profil-sttii/edit', [ProfilController::class, 'edit'])->name('superadmin.profil.edit');
            Route::post('/profil-sttii/update', [ProfilController::class, 'update'])->name('superadmin.profil.update');

            // Route kelola Pengguna
            Route::get('/pengguna', [PenggunaController::class, 'index'])->name('superadmin.pengguna.index');
            Route::get('/add', [PenggunaController::class, 'add'])->name('superadmin.pengguna.add');
            Route::post('/store', [PenggunaController::class, 'store'])->name('superadmin.pengguna.store');
            Route::get('/edit{id_pengguna}', [PenggunaController::class, 'edit'])->name('superadmin.pengguna.edit');
            Route::post('/update{id_pengguna}', [PenggunaController::class, 'update'])->name('superadmin.pengguna.update');
            Route::get('/detail/{id_pengguna}', [PenggunaController::class, 'detail'])->name('superadmin.pengguna.detail');
            Route::delete('/delete/{id_pengguna}', [PenggunaController::class, 'delete'])->name('superadmin.pengguna.delete');


            Route::get('/pengguna/profil', [PenggunaController::class, 'profil'])->name('superadmin.pengguna.profil');
            Route::get('/pengguna/profil/update', [PenggunaController::class, 'profilUpdate'])->name('superadmin.pengguna.profilUpdate');


            // Route kelola Bangunan
            Route::get('/aset-bangunan', [BangunanController::class, 'index'])->name('superadmin.bangunan.index');
            Route::get('/aset-bangunan/add', [BangunanController::class, 'add'])->name('superadmin.bangunan.add');
            Route::post('/aset-bangunan/store', [BangunanController::class, 'store'])->name('superadmin.bangunan.store');
            Route::get('/aset-bangunan/detail/{id_bangunan}', [BangunanController::class, 'detail'])->name('superadmin.bangunan.detail');
            Route::get('/aset-bangunan/edit/{id_bangunan}', [BangunanController::class, 'edit'])->name('superadmin.bangunan.edit');
            Route::post('/aset-bangunan/update{id_bangunan}', [BangunanController::class, 'update'])->name('superadmin.bangunan.update');
            Route::delete('/aset-bangunan/delete/{id_bangunan}', [BangunanController::class, 'delete'])->name('superadmin.bangunan.delete');


            // Route kelola Tanah
            Route::get('/aset-tanah', [TanahController::class, 'index'])->name('superadmin.tanah.index');
            Route::get('/aset-tanah/add', [TanahController::class, 'add'])->name('superadmin.tanah.add');
            Route::post('/aset-tanah/store', [TanahController::class, 'store'])->name('superadmin.tanah.store');
            Route::get('/aset-tanah/detail/{id_tanah}', [TanahController::class, 'detail'])->name('superadmin.tanah.detail');
            Route::get('/aset-tanah/edit/{id_tanah}', [TanahController::class, 'edit'])->name('superadmin.tanah.edit');
            Route::post('/aset-tanah/update{id_tanah}', [TanahController::class, 'update'])->name('superadmin.tanah.update');
            Route::delete('/aset-tanah/delete/{id_tanah}', [TanahController::class, 'delete'])->name('superadmin.tanah.delete');


            // Route kelola Kategori Barang
            Route::get('/kategori_barang', [KategoriBarangController::class, 'index'])->name('superadmin.kategori_barang.index');
            Route::get('/kategori_barang/add', [KategoriBarangController::class, 'add'])->name('superadmin.kategori_barang.add');
            Route::post('/kategori_barang/store', [KategoriBarangController::class, 'store'])->name('superadmin.kategori_barang.store');
            Route::get('/kategori_barang/edit/{id_kategori_barang}', [KategoriBarangController::class, 'edit'])->name('superadmin.kategori_barang.edit');
            Route::post('/kategori_barang/update{id_kategori_barang}', [KategoriBarangController::class, 'update'])->name('superadmin.kategori_barang.update');
            Route::get('/kategori_barang/detail/{id_kategori_barang}', [KategoriBarangController::class, 'detail'])->name('superadmin.kategori_barang.detail');
            Route::delete('/kategori_barang/delete/{id_kategori_barang}', [KategoriBarangController::class, 'delete'])->name('superadmin.kategori_barang.delete');

            // Route kelola Barang
            Route::get('/barang', [BarangController::class, 'index'])->name('superadmin.barang.index');
            Route::get('/barang/add', [BarangController::class, 'add'])->name('superadmin.barang.add');
            Route::post('/barang/store', [BarangController::class, 'store'])->name('superadmin.barang.store');
            Route::get('/barang/edit/{id_barang}', [BarangController::class, 'edit'])->name('superadmin.barang.edit');
            Route::post('/barang/update{id_barang}', [BarangController::class, 'update'])->name('superadmin.barang.update');
            Route::delete('/barang/delete/{id_barang}', [BarangController::class, 'delete'])->name('superadmin.barang.delete');
            Route::get('/barang/detail/{id_barang}', [BarangController::class, 'detail'])->name('superadmin.barang.detail');

            Route::get('/barang/add-item/{id_barang}', [BarangController::class, 'addItem'])->name('superadmin.barang.add_item_barang');
            Route::post('/barang/store-item{id_barang}', [BarangController::class, 'storeItem'])->name('superadmin.barang.store_item_barang');
            Route::get('/barang/detail-item/{id_item_barang}', [BarangController::class, 'detailItem'])->name('superadmin.barang.detail_item_barang');
            Route::get('/barang/edit-item/{id_item_barang}', [BarangController::class, 'editItem'])->name('superadmin.barang.edit_item_barang');
            Route::post('/barang/update-item/{id_item_barang}', [BarangController::class, 'updateItem'])->name('superadmin.barang.update_item_barang');
            Route::delete('/barang/delete-item/{id_item_barang}', [BarangController::class, 'deleteItem'])->name('superadmin.barang.delete_item_barang');

            Route::get('/barang/kategori-barang/add', [BarangController::class, 'addKategori'])->name('superadmin.barang.addKategori');
            Route::post('/barang/kategori-barang/store', [BarangController::class, 'storeKategori'])->name('superadmin.barang.storeKategori');


            // Route kelola ruangan
            Route::get('/ruangan', [RuanganController::class, 'index'])->name('superadmin.ruangan.index');
            Route::get('/tambah-ruangan', [RuanganController::class, 'add'])->name('superadmin.ruangan.add');
            Route::post('/tambah-ruangan', [RuanganController::class, 'store'])->name('superadmin.ruangan.store');
            Route::get('/ruangan/detail/{id_ruangan}', [RuanganController::class, 'detail'])->name('superadmin.ruangan.detail');
            Route::get('/ruangan/edit/{id_ruangan}', [RuanganController::class, 'edit'])->name('superadmin.ruangan.edit');
            Route::post('/ruangan/update{id_ruangan}', [RuanganController::class, 'update'])->name('superadmin.ruangan.update');
            Route::delete('/ruangan/delete/{id_ruangan}', [RuanganController::class, 'delete'])->name('superadmin.ruangan.delete');
            Route::get('/ruangan/cetak-semua-kode', [RuanganController::class, 'cetakAll'])->name('superadmin.ruangan.cetakAll');
            Route::get('/ruangan/cetak-kode-item/{id_ruangan}', [RuanganController::class, 'cetakKodePerItem'])->name('superadmin.ruangan.cetakKodePerItem');
            Route::get('/ruangan/cetak-detail-ruangan/{id_ruangan}', [RuanganController::class, 'cetakDetailRuangan'])->name('superadmin.ruangan.cetakDetailRuangan');
            Route::delete('/ruangan/delete-item-barang/{id_item_penempatan_barang}', [RuanganController::class, 'deleteItem'])->name('superadmin.ruangan.delete_item');

            Route::get('/ruangan/mutasi-barang/{id_item_barang}', [RuanganController::class, 'mutasi'])->name('superadmin.ruangan.mutasi_barang');
            Route::post('/ruangan/mutasi-barang/{id_item_barang}', [RuanganController::class, 'storeMutasi'])->name('superadmin.ruangan.storeMutasi');


            //Pengadaan Tanah Baru
            Route::get('/pengadaan-tanah', [PengadaanTanahController::class, 'index'])->name('superadmin.pengadaan_tanah.index');
            Route::get('/tambah-pengadaan-tanah', [PengadaanTanahController::class, 'add'])->name('superadmin.pengadaan_tanah.add');
            Route::post('/tambah-pengadaan-tanah', [PengadaanTanahController::class, 'store'])->name('superadmin.pengadaan_tanah.store');
            Route::get('/pengadaan-tanah/edit/{id_pengadaan_tanah}',  [PengadaanTanahController::class, 'edit'])->name('superadmin.pengadaan_tanah.edit');
            Route::post('/pengadaan-tanah/update{id_pengadaan_tanah}', [PengadaanTanahController::class, 'update'])->name('superadmin.pengadaan_tanah.update');
            Route::delete('/pengadaan-tanah/hapus{id_pengadaan_tanah}', [PengadaanTanahController::class, 'delete'])->name('superadmin.pengadaan_tanah.delete');
            Route::get('/pengadaan-tanah/detail{id_pengadaan_tanah}', [PengadaanTanahController::class, 'detail'])->name('superadmin.pengadaan_tanah.detail');

            //Pengadaan bangunan Baru
            Route::get('/pengadaan-bangunan', [PengadaanBangunanController::class, 'index'])->name('superadmin.pengadaan_bangunan.index');
            Route::get('/pengadaan-bangunan/tambah', [PengadaanBangunanController::class, 'add'])->name('superadmin.pengadaan_bangunan.add');
            Route::post('/pengadaan-bangunan/tambah', [PengadaanBangunanController::class, 'store'])->name('superadmin.pengadaan_bangunan.store');
            Route::get('/pengadaan-bangunan/ubah/{id_pengadaan_bangunan}', [PengadaanBangunanController::class, 'edit'])->name('superadmin.pengadaan_bangunan.edit');
            Route::post('/pengadaan-bangunan/ubah/{id_pengadaan_bangunan}', [PengadaanBangunanController::class, 'update'])->name('superadmin.pengadaan_bangunan.update');
            Route::delete('/pengadaan-bangunan/hapus/{id_pengadaan_bangunan}', [PengadaanBangunanController::class, 'delete'])->name('superadmin.pengadaan_bangunan.delete');
            Route::get('/pengadaan-bangunan/detail/{id_pengadaan_bangunan}', [PengadaanBangunanController::class, 'detail'])->name('superadmin.pengadaan_bangunan.detail');


            //Pengadaan barang Baru
            Route::get('/pengadaan-barang', [PengadaanBarangController::class, 'index'])->name('superadmin.pengadaan_barang.index');
            Route::get('/tambah-pengadaan-barang', [PengadaanBarangController::class, 'add'])->name('superadmin.pengadaan_barang.add');
            Route::post('/tambah-pengadaan-barang', [PengadaanBarangController::class, 'store'])->name('superadmin.pengadaan_barang.store');
            Route::get('/pengadaan-barang/detail/{id_pengadaan_barang}', [PengadaanBarangController::class, 'detail'])->name('superadmin.pengadaan_barang.detail');
            Route::get('/pengadaan-barang/edit/{id_pengadaan_barang}', [PengadaanBarangController::class, 'edit'])->name('superadmin.pengadaan_barang.edit');
            Route::post('/pengadaan-barang/update{id_pengadaan_barang}', [PengadaanBarangController::class, 'update'])->name('superadmin.pengadaan_barang.update');
            Route::delete('/pengadaan-barang/delete/{id_pengadaan_barang}', [PengadaanBarangController::class, 'delete'])->name('superadmin.pengadaan_barang.delete');
            Route::get('/pengadaan-barang/tambah-barang', [PengadaanBarangController::class, 'addBarang'])->name('superadmin.pengadaan_barang.add_barang');
            Route::post('/pengadaan-barang/tambah-barang', [PengadaanBarangController::class, 'storeBarang'])->name('superadmin.pengadaan_barang.store_barang');


            // Route kelola Penempatan Barang
            Route::get('/penempatan-barang', [PenempatanBarangController::class, 'index'])->name('superadmin.penempatan_barang.index');
            Route::get('/penempatan/add', [PenempatanBarangController::class, 'add'])->name('superadmin.penempatan_barang.add');
            Route::post('/penempatan/store', [PenempatanBarangController::class, 'store'])->name('superadmin.penempatan_barang.store');
            Route::get('/penempatan-barang/edit/{id_penempatan_barang}', [PenempatanBarangController::class, 'edit'])->name('superadmin.penempatan_barang.edit');
            Route::post('/penempatan-barang/update{id_penempatan_barang}', [PenempatanBarangController::class, 'update'])->name('superadmin.penempatan_barang.update');
            Route::get('/detail-penempatan-barang/{id_penempatan_barang}', [PenempatanBarangController::class, 'detail'])->name('superadmin.penempatan_barang.detail');
            Route::delete('/penempatan-barang/delete/{id_penempatan_barang}', [PenempatanBarangController::class, 'delete'])->name('superadmin.penempatan_barang.delete');

            // Route kelola mutasi Barang
            Route::get('/mutasi-barang', [MutasiBarangController::class, 'index'])->name('superadmin.mutasi_barang.index');
            Route::get('/mutasi/add', [MutasiBarangController::class, 'add'])->name('superadmin.mutasi_barang.add');
            Route::post('/mutasi/store', [MutasiBarangController::class, 'store'])->name('superadmin.mutasi_barang.store');
            Route::get('/mutasi-barang/edit/{id_mutasi_barang}', [MutasiBarangController::class, 'edit'])->name('superadmin.mutasi_barang.edit');
            Route::post('/mutasi-barang/update{id_mutasi_barang}', [MutasiBarangController::class, 'update'])->name('superadmin.mutasi_barang.update');
            Route::get('/detail-mutasi-barang/{id_mutasi_barang}', [MutasiBarangController::class, 'detail'])->name('superadmin.mutasi_barang.detail');
            Route::delete('/mutasi-barang/delete/{id_mutasi_barang}', [MutasiBarangController::class, 'delete'])->name('superadmin.mutasi_barang.delete');

            // Route kelola Peminnjaman Barang
            Route::get('/peminjaman-barang', [PeminjamanBarangController::class, 'index'])->name('superadmin.peminjaman_barang.index');
            Route::get('/peminjaman-barang/detail/{id_peminjaman_barang}', [PeminjamanBarangController::class, 'detail'])->name('superadmin.peminjaman_barang.detail');
            Route::get('/peminjaman_barang/add', [PeminjamanBarangController::class, 'add'])->name('superadmin.peminjaman_barang.add');
            Route::post('/peminjaman_barang/store', [PeminjamanBarangController::class, 'store'])->name('superadmin.peminjaman_barang.store');
            Route::get('/peminjaman_barang/edit/{id_peminjaman_barang}', [PeminjamanBarangController::class, 'edit'])->name('superadmin.peminjaman_barang.edit');
            Route::post('/peminjaman_barang/update/{id_peminjaman_barang}', [PeminjamanBarangController::class, 'update'])->name('superadmin.peminjaman_barang.update');
            Route::delete('/peminjaman_barang/delete/{id_peminjaman_barang}', [PeminjamanBarangController::class, 'delete'])->name('superadmin.peminjaman_barang.delete');
            Route::get('pengembalian-barang/{id_peminjaman_barang}', [PeminjamanBarangController::class, 'pengembalian'])->name('superadmin.peminjaman_barang.pengembalian');
            Route::post('/pengembalian-barang/store/{id_peminjaman_barang}', [PeminjamanBarangController::class, 'storePengembalian'])->name('superadmin.peminjaman_barang.storePengembalian');
            Route::get('/peminjaman-barang/belum-kembali', [PeminjamanBarangController::class, 'belumKembali'])->name('superadmin.peminjaman_barang.belumKembali');

            // Route kelola pengembalian Barang
            Route::get('/pengembalian-barang', [PengembalianBarangController::class, 'index'])->name('superadmin.pengembalian_barang.index');
            Route::get('/pengembalian_barang/add', [PengembalianBarangController::class, 'add'])->name('superadmin.pengembalian_barang.add');
            Route::post('/pengealian-mbbarang/store', [PengembalianBarangController::class, 'store'])->name('superadmin.pengembalian_barang.store');
            Route::get('/pengembalian-barang/edit/{id_pengembalian_barang}', [PengembalianBarangController::class, 'edit'])->name('superadmin.pengembalian_barang.edit');
            Route::post('/pengealian-mbbarang/update/{id_pengembalian_barang}', [PengembalianBarangController::class, 'update'])->name('superadmin.pengembalian_barang.update');
            Route::delete('/pengembalian-barang/delete/{id_pengembalian_barang}', [PengembalianBarangController::class, 'delete'])->name('superadmin.pengembalian_barang.delete');

            //Route Perawatan Bangunan
            Route::get('/perawatan-bangunan', [PerawatanBangunanController::class, 'index'])->name('superadmin.perawatan_bangunan.index');
            Route::get('/tambah-perawatan-bangunan', [PerawatanBangunanController::class, 'add'])->name('superadmin.perawatan_bangunan.add');
            Route::post('/tambah-perawatan-bangunan', [PerawatanBangunanController::class, 'store'])->name('superadmin.perawatan_bangunan.store');
            Route::get('/perawatan-bangunan/detail/{id_perawatan_bangunan}', [PerawatanBangunanController::class, 'detail'])->name('superadmin.perawatan_bangunan.detail');
            Route::get('/perawatan-bangunan/edit/{id_perawatan_bangunan}', [PerawatanBangunanController::class, 'edit'])->name('superadmin.perawatan_bangunan.edit');
            Route::post('/perawatan-bangunan/update{id_perawatan_bangunan}', [PerawatanBangunanController::class, 'update'])->name('superadmin.perawatan_bangunan.update');
            Route::delete('/perawatan-bangunan/delete/{id_perawatan_bangunan}', [PerawatanBangunanController::class, 'delete'])->name('superadmin.perawatan_bangunan.delete');
            Route::get('/perawatan-bangunan/detail/{id_perawatan_bangunan}', [PerawatanBangunanController::class, 'detail'])->name('superadmin.perawatan_bangunan.detail');

            //Route Perawatan barang
            Route::get('/perawatan-barang', [PerawatanBarangController::class, 'index'])->name('superadmin.perawatan_barang.index');
            Route::get('/tambah-perawatan-barang', [PerawatanBarangController::class, 'add'])->name('superadmin.perawatan_barang.add');
            Route::post('/tambah-perawatan-barang', [PerawatanBarangController::class, 'store'])->name('superadmin.perawatan_barang.store');
            Route::get('/perawatan-barang/detail/{id_perawatan_barang}', [PerawatanBarangController::class, 'detail'])->name('superadmin.perawatan_barang.detail');
            Route::get('/perawatan-barang/edit/{id_perawatan_barang}', [PerawatanBarangController::class, 'edit'])->name('superadmin.perawatan_barang.edit');
            Route::post('/perawatan-barang/update{id_perawatan_barang}', [PerawatanBarangController::class, 'update'])->name('superadmin.perawatan_barang.update');
            Route::delete('/perawatan-barang/delete/{id_perawatan_barang}', [PerawatanBarangController::class, 'delete'])->name('superadmin.perawatan_barang.delete');
            Route::get('/perawatan-barang/detail/{id_perawatan_barang}', [PerawatanBarangController::class, 'detail'])->name('superadmin.perawatan_barang.detail');


            //Penghapusan Tanah
            Route::get('/penghapusan-tanah', [PenghapusanTanahController::class, 'index'])->name('superadmin.penghapusan_tanah.index');
            Route::get('/tambah-penghapusan-tanah', [PenghapusanTanahController::class, 'add'])->name('superadmin.penghapusan_tanah.add');
            Route::post('/tambah-penghapusan-tanah', [PenghapusanTanahController::class, 'store'])->name('superadmin.penghapusan_tanah.store');
            Route::get('/penghapusan-tanah/edit/{id_penghapusan_tanah}', [PenghapusanTanahController::class, 'edit'])->name('superadmin.penghapusan_tanah.edit');
            Route::post('/penghapusan-tanah/update/{id_penghapusan_tanah}', [PenghapusanTanahController::class, 'update'])->name('superadmin.penghapusan_tanah.update');
            Route::delete('/penghapusan-tanah/delete/{id_penghapusan_tanah}', [PenghapusanTanahController::class, 'delete'])->name('superadmin.penghapusan_tanah.delete');


            //Penghapusan bangunan
            Route::get('/penghapusan-bangunan', [PenghapusanBangunanController::class, 'index'])->name('superadmin.penghapusan_bangunan.index');
            Route::get('/tambah-penghapusan-bangunan', [PenghapusanBangunanController::class, 'add'])->name('superadmin.penghapusan_bangunan.add');
            Route::post('/tambah-penghapusan-bangunan', [PenghapusanBangunanController::class, 'store'])->name('superadmin.penghapusan_bangunan.store');
            Route::get('/penghapusan-bangunan/edit/{id_penghapusan_bangunan}', [PenghapusanBangunanController::class, 'edit'])->name('superadmin.penghapusan_bangunan.edit');
            Route::post('/penghapusan-bangunan/update{id_penghapusan_bangunan}', [PenghapusanBangunanController::class, 'update'])->name('superadmin.penghapusan_bangunan.update');
            Route::delete('/penghapusan-bangunan/delete/{id_penghapusan_bangunan}', [PenghapusanBangunanController::class, 'delete'])->name('superadmin.penghapusan_bangunan.delete');


            //Penghapusan Barang
            Route::get('/penghapusan-barang', [PenghapusanBarangController::class, 'index'])->name('superadmin.penghapusan_barang.index');
            Route::get('/tambah-penghapusan-barang', [PenghapusanBarangController::class, 'add'])->name('superadmin.penghapusan_barang.add');
            Route::post('/tambah-penghapusan-barang', [PenghapusanBarangController::class, 'store'])->name('superadmin.penghapusan_barang.store');
            Route::get('/penghapusan-barang/edit/{id_penghapusan_barang}', [PenghapusanBarangController::class, 'edit'])->name('superadmin.penghapusan_barang.edit');
            Route::post('/penghapusan-barang/update{id_penghapusan_barang}', [PenghapusanBarangController::class, 'update'])->name('superadmin.penghapusan_barang.update');
            Route::delete('/penghapusan-barang/delete/{id_penghapusan_barang}', [PenghapusanBarangController::class, 'delete'])->name('superadmin.penghapusan_barang.delete');

            //Penyusutan bangunan
            Route::get('/penyusutan-nilai-bangunan', [PenyusutanBangunanController::class, 'index'])->name('superadmin.penyusutan_bangunan.index');
            Route::get('//penyusutan-nilai-bangunan/detail/{id_bangunan}', [PenyusutanBangunanController::class, 'detail'])->name('superadmin.penyusutan_bangunan.detail');


            //Penyusutan barang
            Route::get('/penyusutan-nilai-barang', [PenyusutanBarangController::class, 'index'])->name('superadmin.penyusutan_barang.index');
            Route::get('/penyusutan-nilai-barang/detail/{id_item_barang}', [PenyusutanBarangController::class, 'detail'])->name('superadmin.penyusutan_barang.detail');


            //Cetak Laporan PDF
            Route::prefix('/laporan')->group(function () {

                Route::prefix('/aset')->group(function () {
                    Route::get('/', [LaporanAsetController::class, 'index'])->name('superadmin.laporan.index');

                    Route::get('/tanah-pdf', [LaporanAsetController::class, 'tanahPDF'])->name('superadmin.laporan.tanahPDF');
                    Route::get('/tanah-excel', [LaporanAsetController::class, 'tanahExcel'])->name('superadmin.laporan.tanahExcel');
                    Route::post('/filter-tanah', [LaporanAsetController::class, 'filterTanah'])->name('superadmin.laporan.filterTanah');

                    Route::get('/bangunan-pdf', [LaporanAsetController::class, 'bangunanPDF'])->name('superadmin.laporan.bangunanPDF');
                    Route::get('/bangunan-excel', [LaporanAsetController::class, 'bangunanExcel'])->name('superadmin.laporan.bangunanExcel');
                    Route::post('/filter-bangunan', [LaporanAsetController::class, 'filterBangunan'])->name('superadmin.laporan.filterBangunan');

                    Route::get('/barang-pdf', [LaporanAsetController::class, 'barangPDF'])->name('superadmin.laporan.barangPDF');
                    Route::get('/barang-excel', [LaporanAsetController::class, 'barangExcel'])->name('superadmin.laporan.barangExcel');
                    Route::post('/filter-barang', [LaporanAsetController::class, 'filterBarang'])->name('superadmin.laporan.filterBarang');

                    Route::get('/item-barang-pdf', [LaporanAsetController::class, 'itemBarangPDF'])->name('superadmin.laporan.itemBarangPDF');
                    Route::get('/item-barang-excel', [LaporanAsetController::class, 'itemBarangExcel'])->name('superadmin.laporan.itemBarangExcel');
                    Route::post('/filter-item-barang', [LaporanAsetController::class, 'filterItemBarang'])->name('superadmin.laporan.filterItemBarang');
                });

                Route::prefix('/pengadaan-aset')->group(function () {
                    Route::get('/', [LaporanPengadaanAsetController::class, 'pengadaan'])->name('superadmin.laporan.pengadaan');

                    Route::get('/pengadaan-tanah-pdf', [LaporanPengadaanAsetController::class, 'pengadaanTanahPDF'])->name('superadmin.laporan.pengadaanTanahPDF');
                    Route::get('/pengadaan-tanah-excel', [LaporanPengadaanAsetController::class, 'pengadaanTanahExcel'])->name('superadmin.laporan.pengadaanTanahExcel');
                    Route::post('/filter-pengadaan-tanah', [LaporanPengadaanAsetController::class, 'filterPengadaanTanah'])->name('superadmin.laporan.filterPengadaanTanah');

                    Route::get('/pengadaan-bangunan-pdf', [LaporanPengadaanAsetController::class, 'pengadaanBangunanPDF'])->name('superadmin.laporan.pengadaanBangunanPDF');
                    Route::get('/pengadaan-bangunan-excel', [LaporanPengadaanAsetController::class, 'pengadaanBangunanExcel'])->name('superadmin.laporan.pengadaanBangunanExcel');
                    Route::post('/filter-pengadaan-bangunan', [LaporanPengadaanAsetController::class, 'filterPengadaanBangunan'])->name('superadmin.laporan.filterPengadaanBangunan');

                    Route::get('/pengadaan-barang-pdf', [LaporanPengadaanAsetController::class, 'pengadaanBarangPDF'])->name('superadmin.laporan.pengadaanBarangPDF');
                    Route::get('/pengadaan-barang-excel', [LaporanPengadaanAsetController::class, 'pengadaanBarangExcel'])->name('superadmin.laporan.pengadaanBarangExcel');
                    Route::post('/filter-pengadaan-barang', [LaporanPengadaanAsetController::class, 'filterPengadaanBarang'])->name('superadmin.laporan.filterPengadaanBarang');
                });

                Route::prefix('/perawatan-aset')->group(function () {
                    Route::get('/', [LaporanPerawatanAsetController::class, 'perawatan'])->name('superadmin.laporan.perawatan');

                    Route::get('/perawatan-bangunan-pdf', [LaporanPerawatanAsetController::class, 'perawatanBangunanPDF'])->name('superadmin.laporan.perawatanBangunanPDF');
                    Route::get('/perawatan-bangunan-Excel', [LaporanPerawatanAsetController::class, 'perawatanBangunanExcel'])->name('superadmin.laporan.perawatanBangunanExcel');
                    Route::post('/filter-perawatan-bangunan', [LaporanPerawatanAsetController::class, 'filterPerawatanBangunan'])->name('superadmin.laporan.filterPerawatanBangunan');

                    Route::get('/perawatan-barang-pdf', [LaporanPerawatanAsetController::class, 'perawatanBarangPDF'])->name('superadmin.laporan.perawatanBarangPDF');
                    Route::get('/perawatan-barang-excel', [LaporanPerawatanAsetController::class, 'perawatanBarangExcel'])->name('superadmin.laporan.perawatanBarangExcel');
                    Route::post('/filter-perawatan-barang', [LaporanPerawatanAsetController::class, 'filterPerawatanBarang'])->name('superadmin.laporan.filterPerawatanBarang');
                });

                Route::prefix('/peminjaman-barang')->group(function () {
                    Route::get('/', [LaporanPeminjamanBarangController::class, 'peminjaman'])->name('superadmin.laporan.peminjaman');

                    Route::get('/peminjaman-barang-excel', [LaporanPeminjamanBarangController::class, 'peminjamanBarangExcel'])->name('superadmin.laporan.peminjamanExcel');
                    Route::get('/peminjaman-barang-pdf', [LaporanPeminjamanBarangController::class, 'peminjamanPDF'])->name('superadmin.laporan.peminjamanPDF');
                    Route::post('/filter-peminjaman-barang', [LaporanPeminjamanBarangController::class, 'filterPeminjaman'])->name('superadmin.laporan.filterPeminjaman');

                    Route::get('/barang-belum-kembali-excel', [LaporanPeminjamanBarangController::class, 'belumKembaliExcel'])->name('superadmin.laporan.belumKembaliExcel');
                    Route::get('/barang-belum-kembali-pdf', [LaporanPeminjamanBarangController::class, 'belumKembaliPDF'])->name('superadmin.laporan.belumKembaliPDF');
                    Route::post('filter-barang-belum-kembali', [LaporanPeminjamanBarangController::class, 'filterBelumKembali'])->name('superadmin.laporan.filterBelumKembali');
                });


                Route::prefix('/penghapusan-aset')->group(function () {
                    Route::get('/', [LaporanPenghapusanAsetController::class, 'penghapusan'])->name('superadmin.laporan.penghapusan');

                    Route::get('/penghapusan-tanah-pdf', [LaporanPenghapusanAsetController::class, 'penghapusanTanahPDF'])->name('superadmin.laporan.penghapusanTanahPDF');
                    Route::get('/penghapusan-tanah-excel', [LaporanPenghapusanAsetController::class, 'penghapusanTanahExcel'])->name('superadmin.laporan.penghapusanTanahExcel');
                    Route::post('/filter-penghapusan-tanah', [LaporanPenghapusanAsetController::class, 'filterPenghapusanTanah'])->name('superadmin.laporan.filterPenghapusanTanah');

                    Route::get('/penghapusan-bangunan-pdf', [LaporanPenghapusanAsetController::class, 'penghapusanBangunanPDF'])->name('superadmin.laporan.penghapusanBangunanPDF');
                    Route::get('/penghapusan-bangunan-excel', [LaporanPenghapusanAsetController::class, 'penghapusanBangunanExcel'])->name('superadmin.laporan.penghapusanBangunanExcel');
                    Route::post('/filter-penghapusan-bangunan', [LaporanPenghapusanAsetController::class, 'filterPenghapusanBangunan'])->name('superadmin.laporan.filterPenghapusanBangunan');

                    Route::get('/penghapusan-barang-pdf', [LaporanPenghapusanAsetController::class, 'penghapusanBarangPDF'])->name('superadmin.laporan.penghapusanBarangPDF');
                    Route::get('/penghapusan-barang-excel', [LaporanPenghapusanAsetController::class, 'penghapusanBarangExcel'])->name('superadmin.laporan.penghapusanBarangExcel');
                    Route::post('/filter-penghapusan-barang', [LaporanPenghapusanAsetController::class, 'filterPenghapusanBarang'])->name('superadmin.laporan.filterPenghapusanBarang');
                });
            });


            //Inventaris
            Route::prefix('/inventaris')->group(function () {

                Route::prefix('/barang')->group(function () {
                    Route::get('/', [InventarisBarangController::class, 'index'])->name('superadmin.inventaris_barang.index');
                    Route::get('/filter-barang', [InventarisBarangController::class, 'filterInventarisBarangPDF'])->name('superadmin.inventaris_barang.filterInventarisBarangPDF');
                    Route::get('/detail/{id_item_barang}', [InventarisBarangController::class, 'detail'])->name('superadmin.inventaris_barang.detail');
                    Route::get('/perawatan/{id_item_barang}', [InventarisBarangController::class, 'perawatan'])->name('superadmin.inventaris_barang.perawatan');
                    Route::Post('/store-perawatan/{id_item_barang}', [InventarisBarangController::class, 'storePerawatan'])->name('superadmin.inventaris_barang.store_perawatan');
                    Route::get('/nonaktif/{id_item_barang}', [InventarisBarangController::class, 'nonaktif'])->name('superadmin.inventaris_barang.nonaktif');
                    Route::Post('/store-penghapusan/{id_item_barang}', [InventarisBarangController::class, 'storePenghapusan'])->name('superadmin.inventaris_barang.store_penghapusan');
                    //link dari dashboard
                    Route::get('/rusak-ringan', [InventarisBarangController::class, 'rusakRingan'])->name('superadmin.inventaris_barang.rusak_ringan');
                    Route::get('/rusak-berat', [InventarisBarangController::class, 'rusakBerat'])->name('superadmin.inventaris_barang.rusak_berat');
                });

                Route::prefix('/tanah')->group(function () {
                    Route::get('/', [InventarisTanahController::class, 'index'])->name('superadmin.inventaris_tanah.index');
                    Route::get('/filter-tanah', [InventarisTanahController::class, 'filterInventarisTanah'])->name('superadmin.inventaris_tanah.filterInventarisTanah');
                    Route::get('/detail/{id_tanah}', [InventarisTanahController::class, 'detail'])->name('superadmin.inventaris_tanah.detail');
                    Route::get('/nonaktif/{id_tanah}', [InventarisTanahController::class, 'nonaktif'])->name('superadmin.inventaris_tanah.nonaktif');
                    Route::Post('/store-penghapusan/{id_tanah}', [InventarisTanahController::class, 'storePenghapusan'])->name('superadmin.inventaris_tanah.store_penghapusan');
                });

                Route::prefix('/bangunan')->group(function () {
                    Route::get('/', [InventarisBangunanController::class, 'index'])->name('superadmin.inventaris_bangunan.index');
                    Route::get('/filter-bangunan', [InventarisBangunanController::class, 'filterInventarisBangunan'])->name('superadmin.inventaris_bangunan.filterInventarisBangunan');
                    Route::get('/detail/{id_item_bangunan}', [InventarisBangunanController::class, 'detail'])->name('superadmin.inventaris_bangunan.detail');
                    Route::get('/perawatan/{id_item_bangunan}', [InventarisBangunanController::class, 'perawatan'])->name('superadmin.inventaris_bangunan.perawatan');
                    Route::Post('/store-perawatan/{id_item_bangunan}', [InventarisBangunanController::class, 'storePerawatan'])->name('superadmin.inventaris_bangunan.store_perawatan');
                    Route::get('/nonaktif/{id_item_bangunan}', [InventarisBangunanController::class, 'nonaktif'])->name('superadmin.inventaris_bangunan.nonaktif');
                    Route::Post('/store-penghapusan/{id_item_bangunan}', [InventarisBangunanController::class, 'storePenghapusan'])->name('superadmin.inventaris_bangunan.store_penghapusan');
                });
            });

            //cetak Kode
            Route::prefix('/cetak-kode')->group(function () {
                Route::get('/data', [CetakKodeController::class, 'index'])->name('superadmin.cetak_kode.index');

                //item barang
                Route::post('/item-barang', [CetakKodeController::class, 'itemBarang'])->name('superadmin.cetak_kode.itemBarang');
                Route::get('/peritem-barang/{id_item_barang}', [CetakKodeController::class, 'perItemBarang'])->name('superadmin.cetak_kode.perItemBarang');

                //ruangan
                Route::get('/ruangan', [CetakKodeController::class, 'ruangan'])->name('superadmin.cetak_kode.ruangan');
                Route::get('/perruangan/{id_ruangan}', [CetakKodeController::class, 'perRuangan'])->name('superadmin.cetak_kode.perRuangan');
            });
        });
    }
);


//====================================================================================================================================================


//Route Admin===================================================================================================================================
Route::group(
    ['middleware' => 'auth:admin'],
    function () {
        Route::prefix('admin')->group(function () {

            // Route kelola dashboard
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');

            // Route kelola Kategori Barang
            Route::prefix('kategori-barang')->group(function () {
                Route::get('/', [AdminKategoriBarangController::class, 'index'])->name('admin.kategori_barang.index');
                Route::get('/add', [AdminKategoriBarangController::class, 'add'])->name('admin.kategori_barang.add');
                Route::post('/store', [AdminKategoriBarangController::class, 'store'])->name('admin.kategori_barang.store');
                Route::get('/edit/{id_kategori_barang}', [AdminKategoriBarangController::class, 'edit'])->name('admin.kategori_barang.edit');
                Route::post('/update{id_kategori_barang}', [AdminKategoriBarangController::class, 'update'])->name('admin.kategori_barang.update');
                Route::get('/detail/{id_kategori_barang}', [AdminKategoriBarangController::class, 'detail'])->name('admin.kategori_barang.detail');
                Route::delete('/delete/{id_kategori_barang}', [AdminKategoriBarangController::class, 'delete'])->name('admin.kategori_barang.delete');
            });


            //Pengadaan barang Baru
            Route::get('/pengadaan-barang', [AdminPengadaanBarangController::class, 'index'])->name('admin.pengadaan_barang.index');
            Route::get('/tambah-pengadaan-barang', [AdminPengadaanBarangController::class, 'add'])->name('admin.pengadaan_barang.add');
            Route::post('/tambah-pengadaan-barang', [AdminPengadaanBarangController::class, 'store'])->name('admin.pengadaan_barang.store');
            Route::get('/pengadaan-barang/detail/{id_pengadaan_barang}', [AdminPengadaanBarangController::class, 'detail'])->name('admin.pengadaan_barang.detail');
            Route::get('/pengadaan-barang/edit/{id_pengadaan_barang}', [AdminPengadaanBarangController::class, 'edit'])->name('admin.pengadaan_barang.edit');
            Route::post('/pengadaan-barang/update{id_pengadaan_barang}', [AdminPengadaanBarangController::class, 'update'])->name('admin.pengadaan_barang.update');
            Route::get('/pengadaan-barang/tambah-barang', [AdminPengadaanBarangController::class, 'addBarang'])->name('admin.pengadaan_barang.add_barang');
            Route::post('/pengadaan-barang/tambah-barang', [AdminPengadaanBarangController::class, 'storeBarang'])->name('admin.pengadaan_barang.store_barang');


            // Route kelola Barang
            Route::prefix('barang')->group(function () {
                Route::get('/', [AdminBarangController::class, 'index'])->name('admin.barang.index');
                Route::get('/add', [AdminBarangController::class, 'add'])->name('admin.barang.add');
                Route::post('/store', [AdminBarangController::class, 'store'])->name('admin.barang.store');
                Route::get('/edit/{id_barang}', [AdminBarangController::class, 'edit'])->name('admin.barang.edit');
                Route::post('/update{id_barang}', [AdminBarangController::class, 'update'])->name('admin.barang.update');
                Route::delete('/delete/{id_barang}', [AdminBarangController::class, 'delete'])->name('admin.barang.delete');
                Route::get('/detail/{id_barang}', [AdminBarangController::class, 'detail'])->name('admin.barang.detail');

                Route::get('/add-item/{id_barang}', [AdminBarangController::class, 'addItem'])->name('admin.barang.add_item_barang');
                Route::post('/store-item{id_barang}', [AdminBarangController::class, 'storeItem'])->name('admin.barang.store_item_barang');
                Route::get('/detail-item/{id_item_barang}', [AdminBarangController::class, 'detailItem'])->name('admin.barang.detail_item_barang');
                Route::get('/edit-item/{id_item_barang}', [AdminBarangController::class, 'editItem'])->name('admin.barang.edit_item_barang');
                Route::post('/update-item/{id_item_barang}', [AdminBarangController::class, 'updateItem'])->name('admin.barang.update_item_barang');
                Route::delete('/delete-item/{id_item_barang}', [AdminBarangController::class, 'deleteItem'])->name('admin.barang.delete_item_barang');

                Route::get('/kategori-barang/add', [AdminBarangController::class, 'addKategori'])->name('admin.barang.addKategori');
                Route::post('/kategori-barang/store', [AdminBarangController::class, 'storeKategori'])->name('admin.barang.storeKategori');
            });

            Route::prefix('/inventaris-barang')->group(function () {

                Route::get('/', [AdminInventarisBarangController::class, 'index'])->name('admin.inventaris_barang.index');

                Route::get('/filter-barang', [AdminInventarisBarangController::class, 'filterInventarisBarangPDF'])->name('admin.inventaris_barang.filterInventarisBarangPDF');
                Route::get('/detail/{id_item_barang}', [AdminInventarisBarangController::class, 'detail'])->name('admin.inventaris_barang.detail');

                Route::get('/perawatan/{id_item_barang}', [AdminInventarisBarangController::class, 'perawatan'])->name('admin.inventaris_barang.perawatan');
                Route::Post('/store-perawatan/{id_item_barang}', [AdminInventarisBarangController::class, 'storePerawatan'])->name('admin.inventaris_barang.store_perawatan');

                //link dari dashboard
                Route::get('/rusak-ringan', [AdminInventarisBarangController::class, 'rusakRingan'])->name('admin.inventaris_barang.rusak_ringan');
                Route::get('/rusak-berat', [AdminInventarisBarangController::class, 'rusakBerat'])->name('admin.inventaris_barang.rusak_berat');
            });

            // Route kelola Peminnjaman Barang
            Route::prefix('/peminjaman-barang')->group(function () {
                Route::get('/', [AdminPeminjamanBarangController::class, 'index'])->name('admin.peminjaman_barang.index');
                Route::get('/add', [AdminPeminjamanBarangController::class, 'add'])->name('admin.peminjaman_barang.add');
                Route::post('/store', [AdminPeminjamanBarangController::class, 'store'])->name('admin.peminjaman_barang.store');
                Route::get('/edit/{id_peminjaman_barang}', [AdminPeminjamanBarangController::class, 'edit'])->name('admin.peminjaman_barang.edit');
                Route::post('/update/{id_peminjaman_barang}', [AdminPeminjamanBarangController::class, 'update'])->name('admin.peminjaman_barang.update');
                Route::get('/detail/{id_peminjaman_barang}', [AdminPeminjamanBarangController::class, 'detail'])->name('admin.peminjaman_barang.detail');
                Route::delete('/delete/{id_peminjaman_barang}', [AdminPeminjamanBarangController::class, 'delete'])->name('admin.peminjaman_barang.delete');
                Route::get('pengembalian-barang/{id_peminjaman_barang}', [AdminPeminjamanBarangController::class, 'pengembalian'])->name('admin.peminjaman_barang.pengembalian');
                Route::post('/pengembalian-barang/store/{id_peminjaman_barang}', [AdminPeminjamanBarangController::class, 'storePengembalian'])->name('admin.peminjaman_barang.storePengembalian');
                Route::get('/peminjaman-barang/belum-kembali', [AdminPeminjamanBarangController::class, 'belumKembali'])->name('admin.peminjaman_barang.belumKembali');
            });

            // Route kelola pengembalian Barang
            Route::get('/pengembalian-barang', [AdminPengembalianBarangController::class, 'index'])->name('admin.pengembalian_barang.index');
            Route::get('/pengembalian-barang/add', [AdminPengembalianBarangController::class, 'add'])->name('admin.pengembalian_barang.add');
            Route::post('/pengembalian-barang/store', [AdminPengembalianBarangController::class, 'store'])->name('admin.pengembalian_barang.store');
            Route::get('/pengembalian-barang/edit/{id_pengembalian_barang}', [AdminPengembalianBarangController::class, 'edit'])->name('admin.pengembalian_barang.edit');
            Route::post('/pengembalian-barang/update/{id_pengembalian_barang}', [AdminPengembalianBarangController::class, 'update'])->name('admin.pengembalian_barang.update');
            Route::delete('/pengembalian-barang/delete/{id_pengembalian_barang}', [AdminPengembalianBarangController::class, 'delete'])->name('admin.pengembalian_barang.delete');


            //Route Perawatan barang
            Route::get('/perawatan-barang', [AdminPerawatanBarangController::class, 'index'])->name('admin.perawatan_barang.index');
            Route::get('/perawatan-barang/tambah', [AdminPerawatanBarangController::class, 'add'])->name('admin.perawatan_barang.add');
            Route::post('/perawatan-barang/store', [AdminPerawatanBarangController::class, 'store'])->name('admin.perawatan_barang.store');
            Route::get('/perawatan-barang/detail/{id_perawatan_barang}', [AdminPerawatanBarangController::class, 'detail'])->name('admin.perawatan_barang.detail');
            Route::get('/perawatan-barang/edit/{id_perawatan_barang}', [AdminPerawatanBarangController::class, 'edit'])->name('admin.perawatan_barang.edit');
            Route::post('/perawatan-barang/update{id_perawatan_barang}', [AdminPerawatanBarangController::class, 'update'])->name('admin.perawatan_barang.update');
            Route::get('/perawatan-barang/detail/{id_perawatan_barang}', [AdminPerawatanBarangController::class, 'detail'])->name('admin.perawatan_barang.detail');


            //Cetak Laporan
            Route::prefix('/laporan')->group(function () {

                Route::prefix('/aset')->group(function () {
                    //laporan data aset
                    Route::get('/', [LaporanLaporanAsetController::class, 'index'])->name('admin.laporan.index');

                    Route::get('/barang-pdf', [LaporanLaporanAsetController::class, 'barangPDF'])->name('admin.laporan.barangPDF');
                    Route::get('/barang-excel', [LaporanLaporanAsetController::class, 'barangExcel'])->name('admin.laporan.barangExcel');
                    Route::post('/filter-barang', [LaporanLaporanAsetController::class, 'filterBarang'])->name('admin.laporan.filterBarang');
                    //laporan item barang
                    Route::get('/item-barang-pdf', [LaporanLaporanAsetController::class, 'itemBarangPDF'])->name('admin.laporan.itemBarangPDF');
                    Route::get('/item-barang-excel', [LaporanLaporanAsetController::class, 'itemBarangExcel'])->name('admin.laporan.itemBarangExcel');
                    Route::post('/filter-item-barang', [LaporanLaporanAsetController::class, 'filterItemBarang'])->name('admin.laporan.filterItemBarang');
                });

                Route::prefix('/pengadaan-aset')->group(function () {
                    Route::get('/', [AdminLaporanController::class, 'pengadaan'])->name('admin.laporan.pengadaan');

                    Route::get('/pengadaan-barang-pdf', [AdminLaporanController::class, 'pengadaanBarangPDF'])->name('admin.laporan.pengadaanBarangPDF');
                    Route::get('/pengadaan-barang-excel', [AdminLaporanController::class, 'pengadaanBarangExcel'])->name('admin.laporan.pengadaanBarangExcel');
                    Route::post('/filter-pengadaan-barang', [AdminLaporanController::class, 'filterPengadaanBarang'])->name('admin.laporan.filterPengadaanBarang');
                });

                Route::prefix('/perawatan-aset')->group(function () {
                    Route::get('/', [LaporanPerawatanBarangController::class, 'perawatan'])->name('admin.laporan.perawatan');
                    Route::get('/perawatan-barang-pdf', [LaporanPerawatanBarangController::class, 'perawatanBarangPDF'])->name('admin.laporan.perawatanBarangPDF');
                    Route::get('/perawatan-barang-excel', [LaporanPerawatanBarangController::class, 'perawatanBarangExcel'])->name('admin.laporan.perawatanBarangExcel');
                    Route::post('/filter-perawatan-barang', [LaporanPerawatanBarangController::class, 'filterPerawatanBarang'])->name('admin.laporan.filterPerawatanBarang');
                });

                Route::prefix('/peminjaman-barang')->group(function () {
                    Route::get('/', [LaporanLaporanPeminjamanBarangController::class, 'peminjaman'])->name('admin.laporan.peminjaman');

                    Route::get('/peminjaman-barang-pdf', [LaporanLaporanPeminjamanBarangController::class, 'peminjamanPDF'])->name('admin.laporan.peminjamanPDF');
                    Route::get('/peminjaman-barang-excel', [LaporanLaporanPeminjamanBarangController::class, 'peminjamanExcel'])->name('admin.laporan.peminjamanExcel');
                    Route::post('/filter-peminjaman-barang', [LaporanLaporanPeminjamanBarangController::class, 'filterPeminjaman'])->name('admin.laporan.filterPeminjaman');

                    Route::get('/barang-belum-kembali-excel', [LaporanLaporanPeminjamanBarangController::class, 'belumKembaliExcel'])->name('admin.laporan.belumKembaliExcel');
                    Route::get('/barang-belum-kembali-pdf', [LaporanLaporanPeminjamanBarangController::class, 'belumKembaliPDF'])->name('admin.laporan.belumKembaliPDF');
                    Route::post('filter-barang-belum-kembali', [LaporanLaporanPeminjamanBarangController::class, 'filterBelumKembali'])->name('admin.laporan.filterBelumKembali');
                });
            });

            //cetak Kode
            Route::prefix('/cetak-kode')->group(function () {
                Route::get('/data', [AdminCetakKodeController::class, 'index'])->name('admin.cetak_kode.index');

                //item barang
                Route::post('/item-barang', [AdminCetakKodeController::class, 'itemBarang'])->name('admin.cetak_kode.itemBarang');
                Route::get('/peritem-barang/{id_item_barang}', [AdminCetakKodeController::class, 'perItemBarang'])->name('admin.cetak_kode.perItemBarang');
                Route::post('/item-barang/barang/{id_barang}', [AdminCetakKodeController::class, 'perBarang'])->name('admin.cetak_kode.perBarang');
            });
        });
    }
);

// ======================================================================================================================================================


// Route Jemaat
Route::prefix('/')->group(function () {
    Route::get('/informasi-barang/{id_item_barang}', [UserInventarisBarangController::class, 'info'])->name('barang.info');

});
