@extends('admin.layout.main')
@section('admin.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengembalian Barang</h1>
    <a href="{{route('admin.peminjaman_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="row">
    <div class="col-md-5">
        <form action="{{ route('admin.peminjaman_barang.storePengembalian', $peminjamanBarang->id_peminjaman_barang) }}" method="POST">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label for="kode_pengembalian_barang">Kode Pengembalian Barang</label>
                        <input type="text" name="kode_pengembalian_barang" value="{{ old('kode_pengembalian_barang', $nextKodePengembalianBarang) }}" class="form-control" id="kode_pengembalian_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal Pengembalian</label>
                        <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" autofocus required>
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless ">
                        <tr>
                            <th>Kode Peminjaman </th>
                            <td>: {{ $peminjamanBarang->kode_peminjaman_barang}}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Peminjaman </th>
                            <td>: {{ $peminjamanBarang->tanggal}}</td>
                        </tr>
                        <tr>
                            <th>Nama Peminjaman </th>
                            <td>: {{ $peminjamanBarang->nama_peminjam}}</td>
                        </tr>
                        <tr>
                            <th>Telp/WA Peminjaman </th>
                            <td>: {{ $peminjamanBarang->kontak}}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $peminjamanBarang->alamat}}</td>
                        </tr>
                        <tr>
                            <th>Status Peminjaman</th>
                            <td>:
                                @if($peminjamanBarang->status == 0)
                                <span class=" badge badge-danger">Belum Dikembalikan</span>
                                @else
                                <span class="badge badge-success">Sudah Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="table-responsive p-3">
                <h5 class="mb-3">
                    List Barang Dipinjam
                </h5>
                <table class="table mb-3">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->kode_item_barang }}</td>
                            <td>{{ $row->nama_item_barang }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    {{ $items->links() }}
                </table>
            </div>
        </div>
    </div>
</div>

@endsection