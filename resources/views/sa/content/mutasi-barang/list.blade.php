@extends ('sa.layout.main')
@section ('sa.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Mutasi Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('superadmin.mutasi_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode mutasi</th>
                            <th>Tanggal</th>
                            <th>Item Barang</th>
                            <th>Ruangan Awal</th>
                            <th>Ruangan Tujuan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mutasi as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_mutasi_barang}}</td>
                            <td>{{$row->tanggal}}</td>
                            <td>{{$row->kode_item_barang}} {{ $row->nama_item_barang}}</td>
                            <td>{{$row->kode_ruangan_awal}} {{ $row->nama_ruangan_awal}}</td>
                            <td>{{$row->kode_ruangan_tujuan}} {{ $row->nama_ruangan_tujuan}}</td>
                            <td>{{$row->keterangan}}</td>
                            <td>
                                <a href="{{ route('superadmin.mutasi_barang.edit', $row->id_mutasi_barang) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#mutasiBarangDeleteModal-{{ $row->id_mutasi_barang }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="mutasiBarangDeleteModal-{{ $row->id_mutasi_barang }}" tabindex="-1" role="dialog" aria-labelledby="mutasiBarangDeleteModalLabel-{{ $row->id_mutasi_barang }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mutasiBarangDeleteModalLabel-{{ $row->id_mutasi_barang }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data mutasi {{ $row->nama_item_barang }} dengan kode {{ $row->kode_mutasi_barang }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.mutasi_barang.delete', $row->id_mutasi_barang) }}" method="POST">
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