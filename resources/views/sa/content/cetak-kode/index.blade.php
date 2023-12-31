@extends ('sa.layout.main')
@section ('sa.content')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Cetak QR Code Item Barang</h1>
</div>
<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Kode Item Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-danger btn-sm" title="Filter" data-toggle="modal" data-target="#cetakPerBarang">
                                Export Per Barang <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Item Barang</th>
                                <th>Nama Item Barang/Merk</th>
                                <th>Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itemBarang as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_item_barang}}</td>
                                <td>{{$row->nama_item_barang}} {{$row->merk}}</td>
                                <td>{{$row->nama_ruangan }}</td>
                                <td>
                                    <a href="{{ route ('superadmin.cetak_kode.perItemBarang', $row->id_item_barang)}}" class="btn btn-sm btn-outline-danger" target="_blank" title="Cetak QR Code"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="cetakPerBarang" tabindex="-1" role="dialog" aria-labelledby="cetakPerBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakPerBarangLabel">Filter Cetak QR Code Per Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.cetak_kode.itemBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_barang">Barang</label>
                        <select name="id_barang" id="id_barang" class="form-control @error('id_barang') is-invalid @enderror" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $row)
                            <option value="{{ $row->id_barang }}">{{ $row->kode_barang }} {{ $row->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-danger">Cetak QR Code <i class="fa fa-file-print"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection