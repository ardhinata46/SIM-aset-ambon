@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail {{ $barang->nama_barang }}</h1>
    <a href="{{route('superadmin.barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="row mb-3">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Kategori Barang</th>
                    <td>: {{ $barang->kategori_barang->kode_kategori_barang }} {{ $barang->kategori_barang->nama_kategori_barang }}</td>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <td>: {{ $barang->kode_barang }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>: {{ $barang->nama_barang }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="d-sm-flex  mb-4 align-items-center justify-content-between">
            <h5 class="h5 mb-0 text-gray-800">List Item {{ $barang->nama_barang }}</h5>
            <a href="{{route('superadmin.barang.add_item_barang', $barang->id_barang)}}" class="btn btn-primary" title="Tambah Item Barang"><i class="fa fa-plus"></i> Item</a>
        </div>
        <div class="table-responsive">
            <table class="table" id="myTable">
                <thead class=" thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Item Barang</th>
                        <th>Nama Item Barang</th>
                        <th>Merk</th>
                        <th>Tanggal Pengadaan</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itemBarang as $row)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->kode_item_barang}}</td>
                        <td>{{$row->nama_item_barang}}</td>
                        <td>{{$row->merk}}</td>
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
                            <a href="{{ route('superadmin.barang.detail_item_barang', $row->id_item_barang) }}" data-toggle="tooltip" data-placement="top" title="Detail Item Barang" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('superadmin.barang.edit_item_barang', $row->id_item_barang) }}" data-toggle="tooltip" data-placement="top" title="Edit Item Barang" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#itemDeleteModal-{{ $row->id_item_barang }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="itemDeleteModal-{{ $row->id_item_barang }}" tabindex="-1" role="dialog" aria-labelledby="itemDeleteModalLabel-{{ $row->id_item_barang }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="itemDeleteModalLabel-{{ $row->id_item_barang }}">Peringatan!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Anda yakin ingin menghapus data {{ $row->nama_item_barang }} dengan kode {{ $row->kode_item_barang }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('superadmin.barang.delete_item_barang', $row->id_item_barang) }}" method="POST">
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

@endsection