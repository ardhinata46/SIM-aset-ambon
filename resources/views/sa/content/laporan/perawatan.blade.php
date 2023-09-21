@extends ('sa.layout.main')
@section ('sa.content')

<div class="card mb-3">
    <div class="card-header item py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="title">
            <h5 style="margin-bottom: 0;">Pilih Data Perawatan</h5>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" data-toggle="tab" onclick="showDiv('PerawatanBangunan')">
                        <i class="fas fa-hard-hat"></i>
                        <span class="d-none d-lg-inline">Perawatan Bangunan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="tab" onclick="showDiv('PerawatanBarang')">
                        <i class="fas fa-tools"></i>
                        <span class="d-none d-lg-inline">Perawatan Barang</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row" id="PerawatanBangunan">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Laporan Perawatan Bangunan</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter Export Laporan Perawatan" data-toggle="modal" data-target="#perawatanBangunanModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.perawatanBangunanExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Perawatan Bangunan Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.perawatanBangunanPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Perawatan Bangunan PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePerawatanBangunan">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Perawatan</th>
                                <th>Bangunan</th>
                                <th>Tanggal</th>
                                <th>Deskripsi </th>
                                <th>Kondisi</th>
                                <th>Biaya</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perawatanBangunan as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_perawatan_bangunan}}</td>
                                <td>{{$row->kode}} {{$row->bangunan}}</td>
                                <td>{{$row->tanggal_perawatan}}</td>
                                <td>{{$row->deskripsi}}</td>
                                <td>
                                    @if($row->kondisi_sesudah == 'baik')
                                    <span class="badge badge-success">Baik</span>
                                    @elseif($row->kondisi_sesudah == 'rusak_ringan')
                                    <span class="badge badge-warning">Rusak Ringan</span>
                                    @elseif($row->kondisi_sesudah == 'rusak_berat')
                                    <span class="badge badge-danger">Rusak Berat</span>
                                    @endif
                                </td>
                                <td>Rp.{{ number_format(floatval($row->biaya), 0, ',', '.') }}</td>
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
<div class="row" id="PerawatanBarang" style="display: none;">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Laporan Perawatan Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter Export Perawatan Barang" data-toggle="modal" data-target="#perawatanBarangModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.perawatanBarangExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Perawatan Barang Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.perawatanBarangPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Perawatan Barang PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePerawatanBarang">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode Perawatan</th>
                                <th>Barang</th>
                                <th>Deskripsi Perawatan</th>
                                <th>Kondisi Setelah Perawatan</th>
                                <th>Biaya </th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perawatanBarang as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->tanggal_perawatan}}</td>
                                <td>{{$row->kode_perawatan_barang}}</td>
                                <td>{{$row->kode}} {{$row->barang}}</td>
                                <td>{{$row->deskripsi}} </td>
                                <td>
                                    @if($row->kondisi_sesudah == 'baik')
                                    <span class="badge badge-success">Baik</span>
                                    @elseif($row->kondisi_sesudah == 'rusak_ringan')
                                    <span class="badge badge-warning">Rusak Ringan</span>
                                    @elseif($row->kondisi_sesudah == 'rusak_berat')
                                    <span class="badge badge-danger">Rusak Berat</span>
                                    @endif
                                </td>
                                <td>Rp.{{ number_format(floatval($row->biaya), 0, ',', '.') }}</td>
                                <td>{{$row->keterangan}} </td>
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
<div class="modal fade" id="perawatanBangunanModal" tabindex="-1" role="dialog" aria-labelledby="perawatanBangunanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="perawatanBangunanModalLabel">Filter Perawatan Bangunan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPerawatanBangunan') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="id_bangunan">Bangunan</label>
                        <select name="id_bangunan" id="id_bangunan" class="form-control @error('id_bangunan') is-invalid @enderror">
                            <option value="">- Pilih Bangunan -</option>
                            @foreach($bangunan as $row)
                            <option value="{{ $row->id_bangunan }}">{{ $row->kode_bangunan }} {{ $row->nama_bangunan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kondisi">Kondisi Setelah Perawatan</label>
                        <select name="kondisi" id="kondisi" class="form-control @error('kondisi') is-invalid @enderror">
                            <option value="">- Pilih Kondisi -</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
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
<div class="modal fade" id="perawatanBarangModal" tabindex="-1" role="dialog" aria-labelledby="perawatanBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="perawatanBarangModalLabel">Filter Perawatan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPerawatanBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="id_item_barang">Item Barang</label>
                        <select name="id_item_barang" id="id_item_barang" class="form-control @error('id_item_barang') is-invalid @enderror">
                            <option value="">- Pilih Item Barang -</option>
                            @foreach($itemBarang as $row)
                            <option value="{{ $row->id_item_barang }}">{{ $row->kode_item_barang }} {{ $row->nama_item_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kondisi">Kondisi Setelah Perawatan</label>
                        <select name="kondisi" id="kondisi" class="form-control @error('kondisi') is-invalid @enderror">
                            <option value="">- Pilih Kondisi -</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
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
        $('#MyTablePerawatanBangunan').DataTable();
        $('#MyTablePerawatanBarang').DataTable();
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