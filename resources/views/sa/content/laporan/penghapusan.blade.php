@extends ('sa.layout.main')
@section ('sa.content')

<div class="card mb-3">
    <div class="card-header item py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="title">
            <h5 style="margin-bottom: 0;">Pilih Data Penghapusan</h5>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" data-toggle="tab" onclick="showDiv('penghapusanTanah')">
                        <i class="fas fa-map"></i> <span class="d-none d-lg-inline">Penghapusan Tanah</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="tab" onclick="showDiv('penghapusanBangunan')">
                        <i class="fas fa-building"></i> <span class="d-none d-lg-inline">Penghapusan Bangunan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="tab" onclick="showDiv('penghapusanBarang')">
                        <i class="fas fa-boxes"></i> <span class="d-none d-lg-inline">Penghapusan Barang</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row" id="penghapusanTanah">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class="mb-0 text-gray-800">Laporan Penghapusan Tanah</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#penghapusanTanahModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.penghapusanTanahExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Penghapusan Tanah Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.penghapusanTanahPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Penghapusan Tanah PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePenghapusanTanah">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Penghapusan Tanah</th>
                                <th>Tanah</th>
                                <th>Tanggal Penghapusan</th>
                                <th>Tindakan Penghapusan</th>
                                <th>Harga Jual (Rp.)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penghapusanTanah as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_penghapusan_tanah}}</td>
                                <td>{{$row->tanah}}</td>
                                <td>{{$row->tanggal}}</td>
                                <td>
                                    @if($row->tindakan == 'jual')
                                    Dijual
                                    @elseif($row->tindakan == 'hibah')
                                    Dihibahkan
                                    @elseif($row->tindakan == 'dihanguskan')
                                    Dihanguskan
                                    @endif
                                </td>
                                <td>{{$row->harga}} </td>
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
<div class="row" id="penghapusanBangunan" style="display: none;">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class="mb-0 text-gray-800">Laporan Penghapusan Bangunan</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#penghapusanBangunanModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.penghapusanBangunanExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Penghapusan Bangunan Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.penghapusanBangunanPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Bangunan">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePenghapusanBangunan">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Penghapusan Tanah</th>
                                <th>Tanah</th>
                                <th>Tanggal Penghapusan</th>
                                <th>Tindakan Penghapusan</th>
                                <th>Harga Jual (Rp.)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penghapusanBangunan as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_penghapusan_bangunan}}</td>
                                <td>{{$row->bangunan}}</td>
                                <td>{{$row->tanggal}}</td>
                                <td>
                                    @if($row->tindakan == 'jual')
                                    Dijual
                                    @elseif($row->tindakan == 'hibah')
                                    Dihibahkan
                                    @elseif($row->tindakan == 'dihanguskan')
                                    Dihanguskan
                                    @endif
                                </td>
                                <td>{{$row->harga}}</td>
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
<div class="row" id="penghapusanBarang" style="display: none;">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class="mb-0 text-gray-800">Laporan Penghapusan Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#penghapusanBarangModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.penghapusanBarangExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Penghapusan Barang Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.penghapusanBarangPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Penghapusan Barang PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablepenghapusanBarang">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Penghapusan Tanah</th>
                                <th>Barang</th>
                                <th>Tanggal Penghapusan</th>
                                <th>Alasan Penghapusan</th>
                                <th>Tindakan Penghapusan</th>
                                <th>Harga Jual (Rp.)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penghapusanBarang as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_penghapusan_barang}}</td>
                                <td>{{$row->kode}} {{$row->barang}}</td>
                                <td>{{$row->tanggal}}</td>
                                <td>
                                    @if($row->alasan == 'rusak')
                                    Rusak
                                    @elseif($row->alasan == 'hilang')
                                    Hilang
                                    @elseif($row->alasan == 'tidak_digunakan')
                                    Tidak digunakan
                                    @endif
                                </td>
                                <td>
                                    @if($row->tindakan == 'jual')
                                    Dijual
                                    @elseif($row->tindakan == 'hibah')
                                    Dihibahkan
                                    @elseif($row->tindakan == 'dihanguskan')
                                    Dihanguskan
                                    @endif
                                </td>
                                <td>{{$row->harga}}</td>
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

<!-- Modal -->
<div class="modal fade" id="penghapusanBangunanModal" tabindex="-1" role="dialog" aria-labelledby="penghapusanBangunanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penghapusanBangunanModalLabel">Filter Penghapusan Bangunan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPenghapusanBangunan') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tindakan">Tindakan Penghapusan</label>
                        <select name="tindakan" id="tindakan" class="form-control @error('tindakan') is-invalid @enderror">
                            <option value="">- Pilih Tindakan Penghapusan -</option>
                            <option value="jual">Dijual</option>
                            <option value="hibah">Dihibahkan</option>
                            <option value="dihanguskan">Dihanguskan</option>
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

<!-- Modal -->
<div class="modal fade" id="penghapusanTanahModal" tabindex="-1" role="dialog" aria-labelledby="penghapusanTanahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penghapusanTanahModalLabel">Filter Penghapusan Tanah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPenghapusanTanah') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tindakan">Tindakan Penghapusan</label>
                        <select name="tindakan" id="tindakan" class="form-control @error('tindakan') is-invalid @enderror">
                            <option value="">- Pilih Tindakan Penghapusan -</option>
                            <option value="jual">Dijual</option>
                            <option value="hibah">Dihibahkan</option>
                            <option value="dihanguskan">Dihanguskan</option>
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

<!-- Modal -->
<div class="modal fade" id="penghapusanBarangModal" tabindex="-1" role="dialog" aria-labelledby="penghapusanBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penghapusanBarangModalLabel">Filter Penghapusan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPenghapusanBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="alasan">Alasan Penghapusan</label>
                        <select name="alasan" id="alasan" class="form-control @error('alasan') is-invalid @enderror">
                            <option value="">- Pilih Alasan Penghapusan -</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                            <option value="tidak_digunakan">Tidak digunakan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tindakan">Tindakan Penghapusan</label>
                        <select name="tindakan" id="tindakan" class="form-control @error('tindakan') is-invalid @enderror">
                            <option value="">- Pilih Tindakan Penghapusan -</option>
                            <option value="jual">Dijual</option>
                            <option value="hibah">Dihibahkan</option>
                            <option value="dihanguskan">Dihanguskan</option>
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
        $('#MyTablePenghapusanTanah').DataTable();
        $('#MyTablePengahapusanBangunan').DataTable();
        $('#MyTablePenghapusanBarang').DataTable();
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