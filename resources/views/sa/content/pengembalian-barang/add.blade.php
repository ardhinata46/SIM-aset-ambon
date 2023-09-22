@extends('sa.layout.main')
@section('sa.content')

    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pengembalian Barang</h1>
        <a href="{{route('superadmin.pengembalian_barang.index')}}">
            <button class="btn btn-primary">Kembali</button>
        </a>
    </div>
    <div class="row">
        <div class="col-md-5">
            <form action="{{ route('superadmin.pengembalian_barang.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kode_pengembalian_barang">Kode Pengembalian Barang</label>
                            <input type="text" name="kode_pengembalian_barang"
                                   value="{{ old('kode_pengembalian_barang', $nextKodePengembalianBarang) }}"
                                   class="form-control" id="kode_pengembalian_barang" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Pengembalian</label>
                            <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}"
                                   class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" autofocus
                                   required>
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_peminjaman_barang">Peminjaman</label>
                            <select name="id_peminjaman_barang" id="id_peminjaman_barang"
                                    class="form-control @error('id_peminjaman_barang') is-invalid @enderror" required>
                                <option disabled selected>- Pilih Peminjaman -</option>
                                @foreach($dataPeminjaman as $data)
                                    <option value="{{ $data['id_peminjaman_barang'] }}"
                                            data-kode="{{ $data['kode_peminjaman_barang'] }}"
                                            data-status="{{ $data['status_barang'] }}"
                                            data-tanggal="{{ $data['tanggal'] }}"
                                            data-nama="{{ $data['nama_peminjam'] }}"
                                            data-kontak="{{ $data['kontak'] }}"
                                            data-alamat="{{ $data['alamat'] }}"
                                            data-jaminan="{{$data['jaminan']}}"
                                            data-item-barang="{{ json_encode($data['item_barang']) }}">

                                        {{$data['kode_peminjaman_barang']}} - {{$data['nama_peminjam']}}
                                        @endforeach

                                    </option>

                            </select>
                            @error('id_peminjaman_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control"
                                      id="keterangan">{{ old('keterangan') }}</textarea>
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
                            <tr>
                                <th>Jaminan</th>
                                <td id="jaminan"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="table-sm table-responsive p-3">
                    <h5 class="mb-3">
                        List Barang Dipinjam
                    </h5>
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Merk Barang</th>
                        </tr>
                        </thead>
                        <tbody id="tb-item-barang">

                        </tbody>
                    </table>
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
                // ambil data dari select
                const selectedOption = select.options[select.selectedIndex];
                const kodePeminjaman = selectedOption.getAttribute('data-kode');
                const tanggalPeminjaman = selectedOption.getAttribute('data-tanggal');
                const namaPeminjam = selectedOption.getAttribute('data-nama');
                const kontak = selectedOption.getAttribute('data-kontak');
                const alamat = selectedOption.getAttribute('data-alamat');
                const status = selectedOption.getAttribute('data-status');
                const jaminan = selectedOption.getAttribute('data-jaminan');
                document.getElementById('tb-item-barang').innerText = '';


                // masukan data ke tabel
                document.getElementById('kode_peminjaman').innerText = kodePeminjaman;
                document.getElementById('tanggal_peminjaman').innerText = tanggalPeminjaman;
                document.getElementById('nama_peminjaman').innerText = namaPeminjam;
                document.getElementById('kontak').innerText = kontak;
                document.getElementById('alamat').innerText = alamat;
                document.getElementById('status').innerText = status;
                document.getElementById('jaminan').innerText = jaminan;

                const item_barang = selectedOption.getAttribute('data-item-barang');
                const itemBarang = JSON.parse(item_barang);

                var tabelBody = document.getElementById('tb-item-barang');

                let iteration = 0;
                itemBarang.forEach(item => {
                    var row = tabelBody.insertRow();
                    var cell = row.insertCell(0);
                    var cell1 = row.insertCell(1);
                    var cell2 = row.insertCell(2);
                    var cell3 = row.insertCell(3);

                    iteration++;
                    cell.innerText = iteration;
                    cell1.innerText = item.kode_item_barang;
                    cell2.innerText = item.nama_item_barang;
                    cell3.innerText = item.merk_item_barang;
                });

                if (status === '0') {
                    document.getElementById('status').innerHTML = '<span class="badge badge-danger">Belum dikembalikan</span>';
                } else {
                    document.getElementById('status').innerHTML = '<span class="badge badge-success">Sudah dikembalikan</span>';
                }

            } else {
                // reset/kosongkan tabel
                document.getElementById('kode_peminjaman').innerText = '';
                document.getElementById('tanggal_peminjaman').innerText = '';
                document.getElementById('nama_peminjaman').innerText = '';
                document.getElementById('kontak').innerText = '';
                document.getElementById('alamat').innerText = '';
                document.getElementById('status').innerText = '';
                document.getElementById('tb-item-barang').innerText = '';

            }
        }

        // fungsi untuk mengubah data di tabel jika memilih id_peminjaman_barang lain
        document.getElementById('id_peminjaman_barang').addEventListener('change', handleSelectChange);
    </script>
@endsection
