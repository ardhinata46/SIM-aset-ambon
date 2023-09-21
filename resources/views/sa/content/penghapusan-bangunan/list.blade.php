@extends ('sa.layout.main')
@section ('sa.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Penghapusan Bangunan</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('superadmin.penghapusan_bangunan.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Penghapusan Bangunan</th>
                            <th>Bangunan</th>
                            <th>Tanggal Penghapusan</th>
                            <th>Tindakan Penghapusan</th>
                            <th>Harga Jual (Rp.)</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penghapusanBangunan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_penghapusan_bangunan}}</td>
                            <td>{{$row->bangunan}}</td>
                            <td>{{$row->tanggal}}</td>
                            <td>
                                @if($row->tindakan == 'jual')
                                Dijual
                                @elseif($row->tindakan == 'hibah')
                                Dihibahkan
                                @elseif($row->tindakan == 'dihanguskan')
                                Dihanguskan
                                @endif
                            </td>
                            <td>{{$row->harga}}
                            </td>
                            <td> {{$row->keterangan}}</td>
                            <td>
                                <a href="{{ route('superadmin.penghapusan_bangunan.edit', $row->id_penghapusan_bangunan) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Data Penghapusan Bangunan" data-toggle="modal" data-target="#penghapusanBangunanModal-{{ $row->id_penghapusan_bangunan }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="penghapusanBangunanModal-{{ $row->id_penghapusan_bangunan }}" tabindex="-1" role="dialog" aria-labelledby="penghapusanBangunanModalLabel-{{ $row->id_penghapusan_bangunan }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="penghapusanBangunanModalLabel-{{ $row->id_penghapusan_bangunan }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data tanggal {{ $row->tanggal }} dengan kode {{ $row->kode_penghapusan_bangunan }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.penghapusan_bangunan.delete', $row->id_penghapusan_bangunan) }}" method="POST">
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