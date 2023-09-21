@extends ('sa.layout.main')
@section ('sa.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Penghapusan Tanah</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('superadmin.penghapusan_tanah.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Penghapusan Tanah</th>
                            <th>Tanah</th>
                            <th>Tanggal Penghapusan</th>
                            <th>Tindakan Penghapusan</th>
                            <th>Harga Penjualan (Rp.)</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penghapusanTanah as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_penghapusan_tanah}}</td>
                            <td>{{$row->tanah}}</td>
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

                            <td>{{ $row->harga}}</td>

                            <td>{{$row->keterangan}}</td>
                            <td>
                                <a href="{{ route('superadmin.penghapusan_tanah.edit', $row->id_penghapusan_tanah) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#penghapusanTanahDeleteModal-{{ $row->id_penghapusan_tanah }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="penghapusanTanahDeleteModal-{{ $row->id_penghapusan_tanah }}" tabindex="-1" role="dialog" aria-labelledby="penghapusanTanahDeleteModalLabel-{{ $row->id_penghapusan_tanah }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="penghapusanTanahDeleteModalLabel-{{ $row->id_penghapusan_tanah }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data pada tanggal {{ $row->tanggal }} dengan kode {{ $row->kode_penghapusan_tanah }} dengan nama tanah {{ $row->tanah }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.penghapusan_tanah.delete', $row->id_penghapusan_tanah) }}" method="POST">
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