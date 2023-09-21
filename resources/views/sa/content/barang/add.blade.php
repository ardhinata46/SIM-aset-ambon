@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Data Barang</h1>
    <a href="{{route('superadmin.barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{route ('superadmin.barang.store')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang', $nextKodeBarang) }}" class="form-control" id="kode_barang" readonly>
                    </div>

                    <div class="form-group">
                        <div class="d-flex flex-row align-items-center justify-content-between">
                            <label for="id_kategori_barang">Kategori Barang <span style="color: red">*</span></label>
                            <a href="{{route('superadmin.barang.addKategori')}}">Belum ada kategori?</a>
                        </div>
                        <select name="id_kategori_barang" id="id_kategori_barang" class="form-control" required>
                            <option value="" disabled selected>- Pilih Kategori Barang -</option>
                            @foreach ($kategoriBarang as $row)
                            <option value="{{ $row->id_kategori_barang }}">{{ $row->kode_kategori_barang }} {{ $row->nama_kategori_barang }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="nama_barang">Nama Barang<span style="color: red">*</span></label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="form-control" id="nama_kategori _barang" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection