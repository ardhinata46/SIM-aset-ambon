@extends('admin.layout.main')
@section('admin.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Pengembalian Barang</h1>
    <a href="{{route('admin.pengembalian_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="row">
    <div class="col-md-5">
        <form action="{{ route('admin.pengembalian_barang.update', $pengembalianBarang->id_pengembalian_barang) }}" method="POST">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label for="kode_pengembalian_barang">Kode Pengembalian Barang</label>
                        <input type="text" name="kode_pengembalian_barang" value="{{  $pengembalianBarang->kode_pengembalian_barang }}" class="form-control" id="kode_pengembalian_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal Pengembalian</label>
                        <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ $pengembalianBarang->tanggal}}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" autofocus required>
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_peminjaman_barang">Peminjaman</label>
                        <select name="id_peminjaman_barang" id="id_peminjaman_barang" class="form-control @error('id_peminjaman_barang') is-invalid @enderror" required>
                            @foreach($peminjaman as $row)
                            <option value="{{ $row->id_peminjaman_barang }}" {{ $row->id_peminjaman_barang == $pengembalianBarang->id_peminjaman_barang ? 'selected' : '' }} data-kode="{{ $row->kode_peminjaman_barang }}" data-status="{{ $row->status }}" data-tanggal="{{ $row->tanggal }}" data-nama="{{ $row->nama_peminjam }}" data-kontak="{{ $row->kontak }}" data-alamat="{{ $row->alamat }}">
                                {{ $row->kode_peminjaman_barang }} - {{ $row->nama_peminjam }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_peminjaman_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan">{{ $pengembalianBarang->keterangan }}</textarea>
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
                            <th>Kode Peminjaman</th>
                            <td><span id="kode_peminjaman"></span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Peminjaman</th>
                            <td id="tanggal_peminjaman"></td>
                        </tr>
                        <tr>
                            <th>Nama Peminjam</th>
                            <td id="nama_peminjaman"></td>
                        </tr>
                        <tr>
                            <th>Telp/WA Peminjaman</th>
                            <td id="kontak"></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td id="alamat"></td>
                        </tr>
                        <tr>
                            <th>Status Peminjaman</th>
                            <td id="status"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Fungsi untuk mengisi data peminjaman saat pilihan select berubah
    function handleSelectChange() {
        const select = document.getElementById('id_peminjaman_barang');
        const selectedId = select.value;

        if (selectedId !== '') {
            // Dapatkan data peminjaman yang dipilih dari elemen select
            const selectedOption = select.options[select.selectedIndex];
            const kodePeminjaman = selectedOption.getAttribute('data-kode');
            const tanggalPeminjaman = selectedOption.getAttribute('data-tanggal');
            const namaPeminjam = selectedOption.getAttribute('data-nama');
            const kontak = selectedOption.getAttribute('data-kontak');
            const alamat = selectedOption.getAttribute('data-alamat');
            const status = selectedOption.getAttribute('data-status');

            // Isi data peminjaman ke dalam tabel detail
            document.getElementById('kode_peminjaman').innerText = kodePeminjaman;
            document.getElementById('tanggal_peminjaman').innerText = tanggalPeminjaman;
            document.getElementById('nama_peminjaman').innerText = namaPeminjam;
            document.getElementById('kontak').innerText = kontak;
            document.getElementById('alamat').innerText = alamat;
            document.getElementById('status').innerText = status;

            if (status === '0') {
                document.getElementById('status').innerHTML = '<span class="badge badge-danger">Belum dikembalikan</span>';
            } else {
                document.getElementById('status').innerHTML = '<span class="badge badge-success">Sudah dikembalikan</span>';
            }

        } else {
            // Jika pilihan tidak dipilih, reset data di tabel detail peminjaman
            document.getElementById('kode_peminjaman').innerText = '';
            document.getElementById('tanggal_peminjaman').innerText = '';
            document.getElementById('nama_peminjaman').innerText = '';
            document.getElementById('kontak').innerText = '';
            document.getElementById('alamat').innerText = '';
            document.getElementById('status').innerText = '';
        }
    }

    // Tambahkan event listener untuk perubahan pada select
    document.getElementById('id_peminjaman_barang').addEventListener('change', handleSelectChange);

    document.addEventListener('DOMContentLoaded', function() {
        handleSelectChange();
    });
</script>
@endsection