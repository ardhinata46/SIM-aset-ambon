@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Inventaris Bangunan</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#inventarisBangunanModal">
                        Filter Bangunan <i class="fas fa-filter"></i>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Bangunan</th>
                                <th>Nama Bangunan</th>
                                <th>Tanah & Lokasi Bangunan</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Kondisi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bangunan as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_bangunan}}</td>
                                <td>{{$row->nama_bangunan}}</td>
                                <td>{{$row->nama}}, {{$row->lokasi}}</td>
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
                                    @if($row->status == 1)
                                    <span class="badge badge-success">Aktif</span>
                                    @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row->penghapusanBangunan)
                                    @if($row->penghapusanBangunan->tindakan == 'jual')
                                    Dijual
                                    @elseif($row->penghapusanBangunan->tindakan == 'hibah')
                                    Dihibahkan
                                    @elseif($row->penghapusanBangunan->tindakan == 'dihanguskan')
                                    Dihanguskan
                                    @endif
                                    @else

                                    @endif
                                <td>
                                    <a href="{{ route('superadmin.inventaris_bangunan.detail', $row->id_bangunan) }}" data-toggle="tooltip" data-placement="top" title="Detail Item Bangunan" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-info-circle"></i>
                                    </a>

                                    @if($row->status == 1)
                                    <a href="{{ route('superadmin.inventaris_bangunan.perawatan', $row->id_bangunan) }}" data-toggle="tooltip" data-placement="top" title="Perawatan Bangunan" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-hard-hat"></i>
                                    </a>
                                    @endif

                                    @if($row->status == 1)
                                    <a href="{{ route('superadmin.inventaris_bangunan.nonaktif', $row->id_bangunan) }}" data-toggle="tooltip" data-placement="top" title="NonAktifkan Bangunan" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                    @endif


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
<div class="modal fade" id="inventarisBangunanModal" tabindex="-1" role="dialog" aria-labelledby="inventarisBangunanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventarisBangunanModalLabel">Filter inventaris Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.inventaris_bangunan.filterInventarisBangunan') }}">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <select name="kondisi" id="kondisi" class="form-control @error('kondisi') is-invalid @enderror">
                            <option value="">- Pilih Kondisi -</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">- Pilih Status -</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tanggal_awal">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control @error('tanggal_awal') is-invalid @enderror">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_akhir">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control @error('tanggal_akhir') is-invalid @enderror" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-primary">Reset Form</button>
                    <button type="submit" class="btn btn-primary">Filter <i class="fa fa-filter"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection