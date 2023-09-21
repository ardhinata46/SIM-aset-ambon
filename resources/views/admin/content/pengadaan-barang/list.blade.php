@extends ('admin.layout.main')
@section ('admin.content')

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
                <a href="{{route('admin.pengadaan_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
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
                                <a href="{{ route('admin.pengadaan_barang.detail', $row->id_pengadaan_barang) }}" data-toggle="tooltip" data-placement="top" title="Info" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('admin.pengadaan_barang.edit', $row->id_pengadaan_barang) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection