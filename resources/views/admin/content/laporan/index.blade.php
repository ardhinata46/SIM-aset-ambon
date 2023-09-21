@extends ('admin.layout.main')
@section ('admin.content')

<div class="card mb-3">
    <div class="card-header item py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="title">
            <h5 style="margin-bottom: 0;">Pilih Data Aset</h5>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" data-toggle="tab" onclick="showDiv('barang')">
                        <i class="fas fa-box"></i> <span class="d-none d-lg-inline">Barang</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="tab" onclick="showDiv('itemBarang')">
                        <i class="fas fa-boxes"></i> <span class="d-none d-lg-inline">Item Barang</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row" id="barang">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class="mb-0 text-gray-800">Laporan Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#filterBarangModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('admin.laporan.barangExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Barang Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('admin.laporan.barangPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Barang PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="myTableBarang">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Item Barang</th>
                                <th>Kategori Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_barang}}</td>
                                <td>{{$row->nama_barang}}</td>
                                <td>{{$row->item_barang_count}}</td>
                                <td>{{$row->nama}}</td>
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
<div class="row" id="itemBarang" style="display: none;">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class="mb-0 text-gray-800">Laporan Item Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" title="Filter" data-toggle="modal" data-target="#itemBarangModal">
                                Filter Export <i class="fas fa-filter"></i>
                            </button>
                            <a href="{{ route('admin.laporan.barangExcel') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Cetak Laporan Item Barang Excel">
                                Export Excel <i class="fa fa-file-excel"></i>
                            </a>
                            <a href="{{ route('admin.laporan.itemBarangPDF') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Laporan Item Barang PDF">
                                Export PDF <i class="fa fa-file-pdf"></i>
                            </a>

                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="myTableItemBarang">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Kode Item Barang</th>
                                <th>Nama Item Barang</th>
                                <th>Merk</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Sumber Aset</th>
                                <th>Harga Perolehan</th>
                                <th>Kondisi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itemBarang as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->barang}}</td>
                                <td>{{$row->kode_item_barang}}</td>
                                <td>{{$row->nama_item_barang}}</td>
                                <td>{{$row->merk}}</td>
                                <td>{{$row->tanggal_pengadaan}}</td>
                                <td> @if($row->sumber == 'pembelian')
                                    Pembelian
                                    @else($row->sumber == 'hibah')
                                    Hibah
                                    @endif
                                </td>
                                <td>Rp. {{ number_format(floatval($row->harga_perolehan), 0, ',', '.') }}</td>
                                <td>
                                    @if($row->kondisi == 'baik')
                                    <span class="badge badge-success">Baik</span>
                                    @elseif($row->kondisi == 'rusak_ringan')
                                    <span class="badge badge-warning">Rusak Ringan</span>
                                    @elseif($row->kondisi == 'rusak_berat')
                                    <span class="badge badge-danger">Rusak Berat</span>
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
<div class="modal fade" id="itemBarangModal" tabindex="-1" role="dialog" aria-labelledby="itemBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemBarangModalLabel">Filter Item Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.laporan.filterItemBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_barang">Barang</label>
                        <select name="id_barang" id="id_barang" class="form-control @error('id_barang') is-invalid @enderror">
                            <option value="">- Pilih Barang -</option>
                            @foreach($pilihBarang as $row)
                            <option value="{{ $row->id_barang }}">{{ $row->kode_barang }} {{ $row->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_item_barang">Nama Item Barang</label>
                        <input type="text" name="nama_item_barang" id="nama_item_barang" class="form-control @error('nama_item_barang') is-invalid @enderror">
                    </div>
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


<!-- Modal -->
<div class="modal fade" id="filterBarangModal" tabindex="-1" role="dialog" aria-labelledby="filterBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterBarangModalLabel">Filter Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.laporan.filterBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <select name="id_kategori_barang" id="id_barang" class="form-control @error('id_barang') is-invalid @enderror" required>
                            <option disabled selected>- Pilih Kategori Barang -</option>
                            @foreach($kategoriBarang as $row)
                            <option value="{{ $row->id_kategori_barang }}">{{ $row->kode_kategori_barang }} {{ $row->nama_kategori_barang }}</option>
                            @endforeach
                        </select>
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
        $('#myTableBarang').DataTable();
        $('#myTableItemBarang').DataTable();
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