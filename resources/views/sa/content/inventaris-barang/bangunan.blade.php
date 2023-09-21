@extends ('sa.layout.main')
@section ('sa.content')

<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Aset Bangunan</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Bangunan</th>
                            <th>Nama Bangunan</th>
                            <th>Lokasi</th>
                            <th>Sumber</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bangunan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_bangunan}}</td>
                            <td>{{$row->nama_bangunan}}</td>
                            <td>{{$row->lokasi}}</td>
                            <td>
                                @if ($row->sumber === 'pembangunan')
                                Pembangunan
                                @elseif ($row->sumber === 'pembelian')
                                Pembelian
                                @elseif ($row->sumber === 'hibah')
                                Hibah
                                @endif
                            </td>
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
                            <td>@if($row->status == 1)
                                <span class="badge badge-success">Aktif</span>
                                @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>@if($row->tindakan == 'jual')
                                Dijual
                                @elseif($row->tindakan == 'hibah')
                                Dihibahkan
                                @elseif($row->tindakan == 'dihanguskan')
                                Dihanguskan
                                @endif {{$row->keterangan}}
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