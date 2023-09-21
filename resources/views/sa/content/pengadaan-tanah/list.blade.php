@extends ('sa.layout.main')
@section ('sa.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengadaan Aset Tanah</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{ route('superadmin.pengadaan_tanah.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Pengadaan Tanah</th>
                            <th>Kode Tanah</th>
                            <th>Nama Tanah</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Sumber</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengadaanTanah as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_pengadaan_tanah}}</td>
                            <td>{{$row->kode_tanah}}</td>
                            <td>{{$row->nama_tanah}}</td>
                            <td>{{$row->tanggal_pengadaan}}</td>
                            <td>
                                @if ($row->sumber === 'pembelian')
                                Pembelian
                                @else ($row->sumber === 'hibah')
                                Hibah
                                @endif</td>

                            <td>
                                <a href="{{ route('superadmin.pengadaan_tanah.detail', $row->id_pengadaan_tanah) }}" data-toggle="tooltip" data-placement="top" title="Detail Pengadaan" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>

                                <a href="{{ route('superadmin.pengadaan_tanah.edit', $row->id_pengadaan_tanah) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>


                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#pengadaanTanahDeleteModal-{{ $row->id_pengadaan_tanah }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="pengadaanTanahDeleteModal-{{ $row->id_pengadaan_tanah }}" tabindex="-1" role="dialog" aria-labelledby="pengadaanTanahDeleteModalLabel-{{ $row->id_pengadaan_tanah }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pengadaanTanahDeleteModalLabel-{{ $row->id_pengadaan_tanah }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus transaksi {{ $row->tanggal_pengadaan }} dengan kode {{ $row->kode_pengadaan_tanah }} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.pengadaan_tanah.delete', $row->id_pengadaan_tanah) }}" method="POST">
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