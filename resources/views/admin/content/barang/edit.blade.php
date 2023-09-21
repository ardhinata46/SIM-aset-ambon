@extends ('admin.layout.main')
@section ('admin.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Data Barang</h1>
    <a href="{{route('admin.barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{route ('admin.barang.update', $barang->id_barang)}}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="created_by" value="{{ $barang->created_by }}">
                    <div class="form-group">
                        <label for="kode_barang">Kode Barang<span style="color: red">*</span></label>
                        <input type="text" name="kode_barang" value="{{ $barang->kode_barang }}" class="form-control" id="kode_barang" readonly>
                    </div>

                    <div class="form-group">
                        <label for="id_kategori_barang">Kategori Barang<span style="color: red">*</span></label>
                        <select name="id_kategori_barang" id="id_kategori_barang" class="form-control" required>
                            <option value="" disabled>- Pilih Kategori Barang -</option>
                            @foreach ($kategoriBarang as $row)
                            <option value="{{ $row->id_kategori_barang }}" {{ $row->id_kategori_barang == $barang->id_kategori_barang ? 'selected' : '' }}>
                                {{ $row->kode_kategori_barang }} {{ $row->nama_kategori_barang }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang">Nama Barang<span style="color: red">*</span></label>
                        <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" class="form-control" id="nama_barang" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection