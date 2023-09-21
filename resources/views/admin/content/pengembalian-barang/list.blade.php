@extends ('admin.layout.main')
@section ('admin.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengembalian Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route ('admin.pengembalian_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Pengembalian</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Kode Peminjaman</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Nama Peminjaman</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengembalianBarang as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_pengembalian_barang}}</td>
                            <td>{{$row->tanggal}}</td> 
                            <td>{{$row->kode}}</td>
                            <td>{{$row->tanggal_peminjaman}}</td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->keterangan}}</td>
                            <td>
                                <a href="{{route ('admin.pengembalian_barang.edit', $row->id_pengembalian_barang)}}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection