@extends ('admin.layout.main')
@section ('admin.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Barang Belum Dikembalikan</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Item Barang</th>
                            <th>Nama Item barang</th>
                            <th>Kode Peminjaman</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->kode_item_barang }}</td>
                            <td>{{ $item->nama_item_barang }}</td>
                            <td>{{ $item->kode_peminjaman_barang }}</td>
                            <td>{{ $item->nama_peminjam }}</td>
                            <td>{{ $item->tanggal }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection