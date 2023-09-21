@extends ('sa.layout.main')
@section ('sa.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Perawatan Bangunan</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('superadmin.perawatan_bangunan.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Perawatan</th>
                            <th>Bangunan</th>
                            <th>Tanggal</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perawatanBangunan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_perawatan_bangunan}}</td>
                            <td>{{$row->kode}} {{$row->bangunan}}</td>
                            <td>{{$row->tanggal_perawatan}}</td>
                            <td>
                                @if($row->kondisi_sesudah == 'baik')
                                <span class="badge badge-success">Baik</span>
                                @elseif($row->kondisi_sesudah == 'rusak_ringan')
                                <span class="badge badge-warning">Rusak Ringan</span>
                                @elseif($row->kondisi_sesudah == 'rusak_berat')
                                <span class="badge badge-danger">Rusak Berat</span>
                                @endif
                            </td>
                            <td>

                                <a href="{{ route('superadmin.perawatan_bangunan.detail', $row->id_perawatan_bangunan) }}" data-toggle="tooltip" data-placement="top" title="Detail perawatan bangunan" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('superadmin.perawatan_bangunan.edit', $row->id_perawatan_bangunan) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#perawatanBangunanDeleteModal-{{ $row->id_perawatan_bangunan }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="perawatanBangunanDeleteModal-{{ $row->id_perawatan_bangunan }}" tabindex="-1" role="dialog" aria-labelledby="perawatanBangunanDeleteModalLabel-{{ $row->id_perawatan_bangunan }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="perawatanBangunanDeleteModalLabel-{{ $row->id_perawatan_bangunan }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data tanggla {{ $row->tanggal_perawatan }} dengan kode {{ $row->kode_perawatan_bangunan }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.perawatan_bangunan.delete', $row->id_perawatan_bangunan) }}" method="POST">
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