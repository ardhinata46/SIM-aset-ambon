@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Data Kategori Barang</h1>
    <a href="{{route('superadmin.kategori_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{route('superadmin.kategori_barang.update', $kategoriBarang->id_kategori_barang)}}">
                    @csrf
                    <div class="form-group">
                        <label for="kode_kategori_barang">Kode kategori Barang</label>
                        <input type="text" name="kode_kategori_barang" value="{{$kategoriBarang->kode_kategori_barang}}" class="form-control" id="kode_kategori_barang" readonly>

                    </div>

                    <div class="form-group">
                        <label for="nama_kategori_barang">Nama Kategori Barang <span style="color: red">*</span></label>
                        <input type="text" name="nama_kategori_barang" value="{{$kategoriBarang->nama_kategori_barang}}" class="form-control" id="nama_kategori_barang" required>
                    </div>

                    <input type="hidden" name="created_by" value="{{$kategoriBarang->created_by}}">

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection