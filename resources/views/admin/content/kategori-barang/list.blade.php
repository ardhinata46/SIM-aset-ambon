@extends ('admin.layout.main')
@section ('admin.content')
@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Kategori Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('admin.kategori_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Kategori Barang</th>
                            <th>Nama Kategori Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriBarang as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_kategori_barang}}</td>
                            <td>{{$row->nama_kategori_barang}}</td>
                            <td>
                                <a href="{{route ('admin.kategori_barang.detail', $row->id_kategori_barang)}}" class="btn btn-outline-info btn-sm" data-toogle="tooltip" data-placement="top" title="Info">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{route ('admin.kategori_barang.edit', $row->id_kategori_barang)}}" class="btn btn-outline-warning btn-sm" data-toogle="tooltip" data-placement="top" title="Info">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#kategoriBarangDeleteModal-{{ $row->id_kategori_barang }}">
                                    <i class="fas fa-trash"></i>
                                </button> -->
                            </td>
                        </tr>
                        <!-- Modal -->
                        <!-- <div class="modal fade" id="kategoriBarangDeleteModal-{{ $row->id_kategori_barang }}" tabindex="-1" role="dialog" aria-labelledby="kategoriBarangDeleteModalLabel-{{ $row->id_kategori_barang }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="kategoriBarangDeleteModalLabel-{{ $row->id_kategori_barang }}">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data {{ $row->nama_kategori_barang }} dengan kode {{ $row->kode_kategori_barang }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.kategori_barang.delete', $row->id_kategori_barang) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection