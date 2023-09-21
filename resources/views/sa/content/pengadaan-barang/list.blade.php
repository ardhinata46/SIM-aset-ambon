@extends ('sa.layout.main')
@section ('sa.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengadaan Aset Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('superadmin.pengadaan_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Pengadaan</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Sumber Aset</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengadaanBarang as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_pengadaan_barang}}</td>
                            <td>{{$row->tanggal_pengadaan}}</td>
                            <td>
                                @if ($row->sumber === 'pembelian')
                                Pembelian
                                @elseif ($row->sumber === 'hibah')
                                Hibah
                                @endif
                            </td>
                            <td>{{$row->keterangan}}</td>
                            <td>
                                <a href="{{ route('superadmin.pengadaan_barang.detail', $row->id_pengadaan_barang) }}" data-toggle="tooltip" data-placement="top" title="Info" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('superadmin.pengadaan_barang.edit', $row->id_pengadaan_barang) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Tanah" data-toggle="modal" data-target="#pengadaanBarangDeleteModal-{{ $row->id_pengadaan_barang }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="pengadaanBarangDeleteModal-{{ $row->id_pengadaan_barang }}" tabindex="-1" role="dialog" aria-labelledby="pengadaanBarangDeleteModalLabel-{{ $row->id_pengadaan_barang }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pengadaanBarangDeleteModalLabel-{{ $row->id_pengadaan_barang }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data {{ $row->kode_pengadaan_barang }} tanggal {{ $row->tanggal_pengadaan }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('superadmin.pengadaan_barang.delete', $row->id_pengadaan_barang) }}" method="POST">
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