@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Penghapusan Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('superadmin.penghapusan_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Penghapusan Barang</th>
                            <th>Barang</th>
                            <th>Tanggal Penghapusan</th>
                            <th>Alasan Penghapusan</th>
                            <th>Tindakan Penghapusan</th>
                            <th>Harga Jual</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penghapusanBarang as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_penghapusan_barang}}</td>
                            <td>{{$row->kode}} {{$row->barang}}</td>
                            <td>{{$row->tanggal}}</td>
                            <td>
                                @if($row->alasan == 'rusak')
                                Rusak
                                @elseif($row->alasan == 'hilang')
                                Hilang
                                @elseif($row->alasan == 'tidak_digunakan')
                                Tidak digunakan
                                @endif
                            </td>
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
                                <a href="{{ route('superadmin.penghapusan_barang.edit', $row->id_penghapusan_barang) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Data Penghapusan Barang" data-toggle="modal" data-target="#penghapusanBarangDeletaModal-{{ $row->id_penghapusan_barang }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="penghapusanBarangDeletaModal-{{ $row->id_penghapusan_barang }}" tabindex="-1" role="dialog" aria-labelledby="penghapusanBarangDeletaModalLabel-{{ $row->id_penghapusan_barang }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="penghapusanBarangDeletaModalLabel-{{ $row->id_penghapusan_barang }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data {{ $row->tanggal }} dengan kode {{ $row->kode_penghapusan_barang }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.penghapusan_barang.delete', $row->id_penghapusan_barang) }}" method="POST">
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