@extends('sa.layout.main')
@section('sa.content')

@include('sweetalert::alert')

<div class="d-sm-flex mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengguna</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{ route('superadmin.pengguna.add') }}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengguna as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nama_pengguna }}</td>
                            <td>@if ($row->role === 'superadmin')
                                Superadmin
                                @else ($row->role === 'admin')
                                Admin
                                @endif</td>
                            <td>{{ $row->kontak }}</td>
                            <td>
                                @if($row->status == 1)
                                <span class="badge badge-success">Aktif</span>
                                @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('superadmin.pengguna.detail', $row->id_pengguna) }}" data-toggle="tooltip" data-placement="top" title="Detail Pengguna" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('superadmin.pengguna.edit', $row->id_pengguna) }}" data-toggle="tooltip" data-placement="top" title="Edit Pengguna" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Pengguna" data-toggle="modal" data-target="#penggunaDeleteModal-{{ $row->id_pengguna }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="penggunaDeleteModal-{{ $row->id_pengguna }}" tabindex="-1" role="dialog" aria-labelledby="penggunaDeleteModalLabel-{{ $row->id_pengguna }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="penggunaDeleteModalLabel-{{ $row->id_pengguna }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data {{ $row->nama_pengguna }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.pengguna.delete', $row->id_pengguna) }}" method="POST">
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