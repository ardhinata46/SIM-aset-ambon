@extends ('sa.layout.main')
@section ('sa.content')

<div class="card mb-3">
    <div class="card-header item py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="title">
            <h5 style="margin-bottom: 0;"></h5>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" data-toggle="tab" onclick="showDiv('ruangan')">
                        <i class="fas fa-door-closed"></i> <span class="d-none d-lg-inline">Ruangan</span>
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
<div class="row" id="ruangan">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h5 class=" mb-0 text-gray-800">Kode Ruangan</h5>
                        <a href="{{ route('superadmin.cetak_kode.ruangan') }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Kode Ruangan">
                            Cetak Semua <i class="fa fa-print"></i>
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="myTableRuangan">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Ruagan</th>
                                <th>Nama Ruangan</th>
                                <th>Lokasi Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ruangan as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_ruangan}}</td>
                                <td>{{$row->nama_ruangan}}</td>
                                <td>{{$row->nama}}</td>
                                <td><a href="{{ route ('superadmin.cetak_kode.perRuangan', $row->id_ruangan) }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fa fa-print"></i></a></td>
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
                        <h5 class=" mb-0 text-gray-800">Cetak Kode Item Barang</h5>
                        <div>
                            <button type="button" class="btn btn-outline-danger btn-sm" title="Filter" data-toggle="modal" data-target="#cetakPerBarang">
                                Export Per Barang <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="myTableItemBarang">
                        <thead class=" thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Item Barang</th>
                                <th>Nama Item Barang/Merk</th>
                                <th>Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itemBarang as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->kode_item_barang}}</td>
                                <td>{{$row->nama_item_barang}} {{$row->merk}}</td>
                                <td>{{$row->nama_ruangan }}</td>
                                <td>
                                    <a href="{{ route ('superadmin.cetak_kode.perItemBarang', $row->id_item_barang)}}" class="btn btn-sm btn-outline-danger" target="_blank" title="Cetak QR Code"><i class="fa fa-print"></i></a>
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
<div class="modal fade" id="cetakPerBarang" tabindex="-1" role="dialog" aria-labelledby="cetakPerBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakPerBarangLabel">Filter Cetak QR Code Per Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.cetak_kode.itemBarang') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_barang">Barang</label>
                        <select name="id_barang" id="id_barang" class="form-control @error('id_barang') is-invalid @enderror" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $row)
                            <option value="{{ $row->id_barang }}">{{ $row->kode_barang }} {{ $row->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-danger">Cetak QR Code <i class="fa fa-file-print"></i></button>
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
        $('#myTableRuangan').DataTable();
        $('#myTableItemBarang').DataTable();
    });
</script>


@endsection