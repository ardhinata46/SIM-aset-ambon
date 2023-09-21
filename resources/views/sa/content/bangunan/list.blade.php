@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')

<div class="d-sm-flex  mb-4">
    <h5 class="h3 mb-0 text-gray-800">Data Aset Bangunan</h5>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route ('superadmin.bangunan.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Bangunan</th>
                            <th>Nama Bangunan</th>
                            <th>Tanah & Lokasi Bangunan</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bangunan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_bangunan}}</td>
                            <td>{{$row->nama_bangunan}}</td>
                            <td>{{$row->nama}} {{$row->lokasi}}</td>
                            <td>{{$row->tanggal_pengadaan}}</td>
                            <td>
                                @if($row->kondisi == 'baik')
                                <span class="badge badge-success">Baik</span>
                                @elseif($row->kondisi == 'rusak_ringan')
                                <span class="badge badge-warning">Rusak Ringan</span>
                                @elseif($row->kondisi == 'rusak_berat')
                                <span class="badge badge-danger">Rusak Berat</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route ('superadmin.bangunan.detail', $row->id_bangunan)}}" data-toggle="tooltip" data-placement="top" title="Detail Bangunan" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{route ('superadmin.bangunan.edit', $row->id_bangunan)}}" data-toggle="tooltip" data-placement="top" title="Edit Bangunan" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Bangunan" data-toggle="modal" data-target="#bangunanDeleteModal-{{ $row->id_bangunan }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="bangunanDeleteModal-{{ $row->id_bangunan }}" tabindex="-1" role="dialog" aria-labelledby="bangunanDeleteModalLabel-{{ $row->id_bangunan }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bangunanDeleteModalLabel-{{ $row->id_bangunan }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data {{ $row->kode_bangunan }} {{ $row->nama_bangunan }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.bangunan.delete', $row->id_bangunan) }}" method="POST">
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