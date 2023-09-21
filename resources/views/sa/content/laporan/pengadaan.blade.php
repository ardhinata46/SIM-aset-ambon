@extends ('sa.layout.main')
@section ('sa.content')

<div class="card mb-3">
    <div class="card-header item py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="title">
            <h5 style="margin-bottom: 0;">Pilih Data Pengadaan Aset</h5>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" data-toggle="tab" onclick="showDiv('pTanah')">
                        <i class="fas fa-map"></i> <span class="d-none d-lg-inline">Pengadaan Tanah</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="tab" onclick="showDiv('PBangunan')">
                        <i class="fas fa-building"></i> <span class="d-none d-lg-inline">Pengadaan Bangunan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="tab" onclick="showDiv('PBarang')">
                        <i class="fas fa-boxes"></i> <span class="d-none d-lg-inline">Pengadaan Barang</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row" id="pTanah">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Laporan Pengadaan Tanah</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter Pengadaan Tanah" data-toggle="modal" data-target="#pengadaanTanahModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.pengadaanTanahExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Pengadaan Tanah Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.pengadaanTanahPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Pengadaan Tanah PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePTanah">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Pengadaan Tanah</th>
                                <th>Kode Tanah</th>
                                <th>Nama Tanah</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Sumber</th>
                                <th>Lokasi</th>
                                <th>Luas Tanah</th>
                                <th>Harga Perolehan</th>
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
                                    @endif
                                </td>
                                <td>{{$row->lokasi}}</td>
                                <td>{{$row->luas}} m<sup>2 </td>
                                <td>Rp. {{ number_format(floatval($row->harga_perolehan), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Row -->
<div class="row" id="PBangunan" style="display: none;">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Laporan Pengadaan Bangunan</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#pengadaanBangunanModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.pengadaanBangunanExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Pengadaan Bangunan Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.pengadaanBangunanPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Bangunan">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePBangunan">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Kode Pengadaan Bangunan</th>
                                <th>Sumber Aset</th>
                                <th>Kode Bangunan</th>
                                <th>Nama Bangunan</th>
                                <th>Deskripsi</th>
                                <th>Tanah & Lokasi</th>
                                <th>Kondisi</th>
                                <th>Harga Perolehan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengadaanBangunan as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->tanggal_pengadaan}}</td>
                                <td>{{$row->kode_pengadaan_bangunan}}</td>
                                <td>
                                    @if ($row->sumber === 'pembangunan')
                                    Pembangunan
                                    @elseif ($row->sumber === 'pembelian')
                                    Pembelian
                                    @else ($row->sumber === 'hibah')
                                    Hibah
                                    @endif
                                </td>
                                <td>{{$row->kode_bangunan}}</td>
                                <td>{{$row->nama_bangunan}}</td>
                                <td>{{$row->deskripsi}}</td>
                                <td>{{$row->nama_tanah}}, {{$row->lokasi}}</td>
                                <td>
                                    @if($row->kondisi == 'baik')
                                    <span class="badge badge-success">Baik</span>
                                    @elseif($row->kondisi == 'rusak_ringan')
                                    <span class="badge badge-warning">Rusak Ringan</span>
                                    @elseif($row->kondisi == 'rusak_berat')
                                    <span class="badge badge-danger">Rusak Berat</span>
                                    @endif
                                </td>
                                <td>Rp. {{ number_format(floatval($row->harga_perolehan), 0, ',', '.') }}</td>
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
<!-- Row -->
<div class="row" id="PBarang" style="display: none;">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Laporan Pengadaan Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#pengadaanBarangModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.pengadaanBarangExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Pengadaan Barang Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.pengadaanBarangPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Pengadaan Barang PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePBarang">
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

<div class="modal fade" id="pengadaanTanahModal" tabindex="-1" role="dialog" aria-labelledby="pengadaanTanahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengadaanTanahModalLabel">Filter Pengadaan Tanah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPengadaanTanah') }}" method="POST" target="_blank">
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

<div class="modal fade" id="pengadaanBangunanModal" tabindex="-1" role="dialog" aria-labelledby="pengadaanBangunanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengadaanBangunanModalLabel">Filter Pengadaan Bangunan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPengadaanBangunan') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="id_tanah">Lokasi</label>
                        <select name="id_tanah" id="id_tanah" class="form-control">
                            <option value="">- Pilih Tanah -</option>
                            @foreach($tanah as $row)
                            <option value="{{ $row->id_tanah }}">{{ $row->nama_tanah }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <select name="kondisi" id="kondisi" class="form-control @error('kondisi') is-invalid @enderror">
                            <option value="">- Pilih kondisi -</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sumber">Sumber Aset</label>
                        <select name="sumber" id="sumber" class="form-control @error('sumber') is-invalid @enderror">
                            <option value="">- Pilih Sumber Aset -</option>
                            <option value="pembangunan">Pembangunan</option>
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

<div class="modal fade" id="pengadaanBarangModal" tabindex="-1" role="dialog" aria-labelledby="pengadaanBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengadaanBarangModalLabel">Filter Pengadaan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPengadaanBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">

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
                            <label for="tanggal_awal">Tanggal Pengadaan</label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control @error('tanggal_awal') is-invalid @enderror" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class=" form-group col-md-6">
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

<script>
    function showDiv(divId) {
        // Mengambil semua elemen dengan class "row"
        var divs = document.getElementsByClassName("row");

        // Menyembunyikan semua div dengan class "row"
        for (var i = 0; i < divs.length; i++) {
            divs[i].style.display = "none";
        }

        // Menampilkan div dengan id yang dipilih
        document.getElementById(divId).style.display = "block";
    }

    $(document).ready(function() {
        $('#MyTablePTanah').DataTable();
        $('#MyTablePBangunan').DataTable();
        $('#MyTablePBarang').DataTable();
    });
</script>

<script>
    // Mengambil elemen form
    const form = document.getElementById('filterForm');

    // Menangani submit form
    form.addEventListener('submit', function(event) {
        // Mengambil nilai tanggal awal dan tanggal akhir
        const tanggalAwal = document.getElementById('tanggal_awal').value;
        const tanggalAkhir = document.getElementById('tanggal_akhir').value;

        // Mengubah format tanggal menjadi objek Date
        const tanggalAwalObj = new Date(tanggalAwal);
        const tanggalAkhirObj = new Date(tanggalAkhir);
        const today = new Date();

        // Validasi tanggal awal tidak lebih besar dari tanggal akhir
        if (tanggalAwalObj > tanggalAkhirObj) {
            event.preventDefault(); // Mencegah pengiriman form
            alert('Tanggal awal harus lebih kecil atau sama dengan tanggal akhir.');
        }
    });
</script>
@endsection