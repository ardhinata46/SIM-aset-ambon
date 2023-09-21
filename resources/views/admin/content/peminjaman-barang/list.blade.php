@extends ('admin.layout.main')
@section ('admin.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Peminjaman Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route ('admin.peminjaman_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Peminjaman</th>
                            <th>Tanggal</th>
                            <th>Nama Peminjam</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Jaminan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamanBarang as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_peminjaman_barang}}</td>
                            <td>{{$row->tanggal}}</td>
                            <td>{{$row->nama_peminjam}}</td>
                            <td>{{$row->kontak}}</td>
                            <td>{{$row->alamat}}</td>
                            <td>{{$row->jaminan}}</td>
                            <td>
                                @if($row->status == 0)
                                <span class=" badge badge-danger">Belum Dikembalikan</span>
                                @else
                                <span class="badge badge-success">Sudah Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                @if($row->status == 0)
                                <a href="{{route ('admin.peminjaman_barang.pengembalian', $row->id_peminjaman_barang)}}" class="btn btn-outline-primary btn-sm" data-toogle="tooltip" data-placement="top" title="Pengembalian">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </a>
                                @endif

                                <a href="{{route ('admin.peminjaman_barang.detail', $row->id_peminjaman_barang)}}" class="btn btn-outline-info btn-sm" data-toogle="tooltip" data-placement="top" title="Info">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{route ('admin.peminjaman_barang.edit', $row->id_peminjaman_barang)}}" class="btn btn-outline-warning btn-sm" data-toogle="tooltip" data-placement="top" title="Edit">
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