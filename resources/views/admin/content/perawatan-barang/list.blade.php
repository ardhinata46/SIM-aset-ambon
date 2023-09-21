@extends ('admin.layout.main')
@section ('admin.content')

@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Perawatan Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{route('admin.perawatan_barang.add')}}"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Perawatan</th>
                            <th>Barang</th>
                            <th>Tanggal</th>
                            <th>Kondisi Setelah Perawatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perawatanBarang as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_perawatan_barang}}</td>
                            <td>{{$row->kode}} {{$row->barang}}</td>
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
                                <a href="{{ route('admin.perawatan_barang.detail', $row->id_perawatan_barang) }}" data-toggle="tooltip" data-placement="top" title="Detail Perawatan Barang" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('admin.perawatan_barang.edit', $row->id_perawatan_barang) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-outline-warning btn-sm">
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