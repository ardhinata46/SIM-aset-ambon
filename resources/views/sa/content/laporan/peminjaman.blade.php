@extends ('sa.layout.main')
@section ('sa.content')

<div class="card mb-3">
    <div class="card-header item py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="title">
            <h5 style="margin-bottom: 0;">Pilih Data Peminjaman</h5>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" data-toggle="tab" onclick="showDiv('Peminjaman')">
                        <i class="fas fa-arrow-circle-up"></i> <span class="d-none d-lg-inline">Peminjaman</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="tab" onclick="showDiv('belumKembali')">
                        <i class="fas fa-times-circle"></i>
                        <span class="d-none d-lg-inline">Belum Dikembalikan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row" id="Peminjaman">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class="mb-0 text-gray-800">Laporan Peminjaman</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#peminjamanModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.peminjamanExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Peminjaman Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.peminjamanPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Peminjaman PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTablePeminjaman">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Peminjaman</th>
                                <th>Tanggal</th>
                                <th>Nama Peminjam</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamanBarang as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_peminjaman_barang}}</td>
                                <td>{{$row->tanggal}}</td>
                                <td>{{$row->nama_peminjam}}</td>
                                <td>{{$row->kontak}}</td>
                                <td>{{$row->alamat}}</td>
                                <td>
                                    @if($row->status == 0)
                                    <span class=" badge badge-danger">Belum Dikembalikan</span>
                                    @else
                                    <span class="badge badge-success">Sudah Dikembalikan</span>
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

<div class="row" id="belumKembali" style="display: none;">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class="mb-0 text-gray-800">Laporan Barang Belum Kembali</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#belumKembaliModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('superadmin.laporan.belumKembaliExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Barang Belum Dikembalikan Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('superadmin.laporan.belumKembaliPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Pengembalian PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="MyTableBelum">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Item Barang</th>
                                <th>Nama Item barang</th>
                                <th>Kode Peminjaman</th>
                                <th>Nama Peminjam</th>
                                <th>Tanggal Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->kode_item_barang }}</td>
                                <td>{{ $item->nama_item_barang }}</td>
                                <td>{{ $item->kode_peminjaman_barang }}</td>
                                <td>{{ $item->nama_peminjam }}</td>
                                <td>{{ $item->tanggal }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="peminjamanModal" tabindex="-1" role="dialog" aria-labelledby="peminjamanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="peminjamanModalLabel">Filter Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterPeminjaman') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="status">Status Peminjaman</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">- Pilih status Peminjaman -</option>
                            <option value="0">Belum Dikembalikan</option>
                            <option value="1">Sudah Dikembalikan</option>
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
<div class="modal fade" id="belumKembaliModal" tabindex="-1" role="dialog" aria-labelledby="belumKembaliModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="belumKembaliModalLabel">Filter Barang Belum Kembali</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.laporan.filterBelumKembali') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_peminjam">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control">
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
        $('#MyTablePeminjaman').DataTable();
        $('#MyTableBelum').DataTable();
    });
</script>
@endsection