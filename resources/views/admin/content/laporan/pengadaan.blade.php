@extends ('admin.layout.main')
@section ('admin.content')

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class=" col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Laporan Pengadaan Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#pengadaanBarangModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('admin.laporan.pengadaanBarangExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Pengadaan Barang Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('admin.laporan.pengadaanBarangPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Pengadaan Barang PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Pengadaan</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Sumber Aset</th>
                                <th>Keterangan</th>
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
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pengadaanBarangModal" tabindex="-1" role="dialog" aria-labelledby="pengadaanBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengadaanBarangModalLabel">Filter Item Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.laporan.filterPengadaanBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror">
                    </div>

                    <div class="form-group">
                        <label for="sumber">Sumber Aset</label>
                        <select name="sumber" id="sumber" class="form-control @error('sumber') is-invalid @enderror">
                            <option value="">- Pilih Sumber Aset -</option>
                            <option value="pembelian">Pembelian</option>
                            <option value="hibah">Hibah</option>
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
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <button type="reset" class="btn btn-sm btn-outline-primary">Reset Form</button>
                        <div>
                            <button type="submit" class="btn btn-sm btn-success" name="export_type" value="excel">Export Excel <i class="fa fa-file-excel"></i></button>
                            <button type="submit" class="btn btn-sm btn-danger" name="export_type" value="pdf">Export PDF <i class="fa fa-file-pdf"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection