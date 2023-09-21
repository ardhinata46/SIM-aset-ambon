@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Ruangan</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('superadmin.ruangan.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Bangunan</th>
                            <th>Kode Ruangan</th>
                            <th>Nama Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->kode_ruangan}}</td>
                            <td>{{$row->nama_ruangan}}</td>
                            <td>
                                <a href="{{ route('superadmin.ruangan.detail', $row->id_ruangan) }}" data-toggle="tooltip" data-placement="top" title="Detail Ruangan" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('superadmin.ruangan.edit', $row->id_ruangan) }}" data-toggle="tooltip" data-placement="top" title="Edit Ruangan" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Ruangan" data-toggle="modal" data-target="#ruanganDeleteModal-{{ $row->id_ruangan }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="ruanganDeleteModal-{{ $row->id_ruangan }}" tabindex="-1" role="dialog" aria-labelledby="ruanganDeleteModalLabel-{{ $row->id_ruangan }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ruanganDeleteModalLabel-{{ $row->id_ruangan }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data {{ $row->nama_ruangan }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.ruangan.delete', $row->id_ruangan) }}" method="POST">
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