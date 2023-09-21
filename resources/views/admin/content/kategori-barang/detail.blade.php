@extends ('admin.layout.main')
@section ('admin.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail {{ $kategoriBarang->nama_kategori_barang }}</h1>
    <a href="{{route('admin.kategori_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <table class="table table-sm table-borderless table-detail">
            <tr>
                <th>Kode Kategori Barang</th>
                <td>: {{ $kategoriBarang->kode_kategori_barang}}</td>
            </tr>
            <tr>
                <th>Nama Kategori Barang</th>
                <td>: {{ $kategoriBarang->nama_kategori_barang }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">

        <div class=" table-responsive">
            <h6>List Barang</h6>
            <table class="table align-items-center table-flush " id="myTable">
                <thead class=" thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Item Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $row)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->kode_barang}}</td>
                        <td>{{$row->nama_barang}}</td>
                        <td>{{$row->item_barang_count}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection