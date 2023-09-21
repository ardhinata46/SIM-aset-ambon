@extends('sa.layout.main')

@section('sa.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Peminjaman Barang</h1>
    <a href="{{route('superadmin.peminjaman_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('superadmin.peminjaman_barang.update', $peminjamanBarang->id_peminjaman_barang)}}">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_peminjaman_barang">Kode Peminjaman Barang</label>
                        <input type="text" name="kode_peminjaman_barang" value="{{ $peminjamanBarang->kode_peminjaman_barang }}" class="form-control @error('kode_peminjaman_barang') is-invalid @enderror" id="kode_peminjaman_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_peminjam">Nama Peminjaman<span style="color: red">*</span></label>
                        <input type="text" name="nama_peminjam" value="{{ $peminjamanBarang->nama_peminjam }}" class="form-control @error('nama_peminjam') is-invalid @enderror" id="nama_peminjam" required>
                        @error('nama_peminjam')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat<span style="color: red">*</span></label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" required>{{ $peminjamanBarang->alamat }}</textarea>
                    </div>
                    @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Peminjaman<span style="color: red">*</span></label>
                        <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ $peminjamanBarang->tanggal }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required>
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kontak">Telp/WA<span style="color: red">*</span></label>
                        <input type="number" name="kontak" value="{{ $peminjamanBarang->kontak }}" class="form-control @error('kontak') is-invalid @enderror" id="kontak" required>
                        @error('kontak')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jaminan">Jaminan<span style="color: red">*</span></label>
                        <input type="text" name="jaminan" value="{{ $peminjamanBarang->jaminan }}" class="form-control @error('jaminan') is-invalid @enderror" id="jaminan" required>
                        @error('jaminan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
    </div>

</form>


@endsection