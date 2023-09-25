@extends ('sa.layout.main')
@section ('sa.content')

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
                <a href="{{route ('superadmin.peminjaman_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Peminjaman</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Nama Peminjam</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
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
                            <td>
                                @if($row->status == 0)
                                <span class=" badge badge-danger">Belum Dikembalikan</span>
                                @else
                                <span class="badge badge-success">Sudah Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                @if($row->status == 0)
                                <a href="{{route ('superadmin.peminjaman_barang.pengembalian', $row->id_peminjaman_barang)}}" class="btn btn-outline-primary btn-sm" data-toogle="tooltip" data-placement="top" title="Pengembalian">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </a>
                                @endif
                                <a href="{{route ('superadmin.peminjaman_barang.detail', $row->id_peminjaman_barang)}}" class="btn btn-outline-info btn-sm" data-toogle="tooltip" data-placement="top" title="Info">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{route ('superadmin.peminjaman_barang.edit', $row->id_peminjaman_barang)}}" class="btn btn-outline-warning btn-sm" data-toogle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Tanah" data-toggle="modal" data-target="#peminjamanBarangDelete-{{ $row->id_peminjaman_barang }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="peminjamanBarangDelete-{{ $row->id_peminjaman_barang }}" tabindex="-1" role="dialog" aria-labelledby="peminjamanBarangDeleteLabel-{{ $row->id_peminjaman_barang }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="peminjamanBarangDeleteLabel-{{ $row->id_peminjaman_barang }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus peminjaman {{ $row->kode_peminjaman_barang }} dengan nama peminjaman {{ $row->nama_peminjam }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.peminjaman_barang.delete', $row->id_peminjaman_barang) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection
