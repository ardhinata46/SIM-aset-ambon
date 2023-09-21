@extends ('sa.layout.main')
@section ('sa.content')

<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail Peminjaman Barang</h1>
    <a href="{{route('superadmin.peminjaman_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-detail">
                        <tr>
                            <th>Kode Peminjaman </th>
                            <td>: {{ $detail->kode_peminjaman_barang}}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Peminjaman </th>
                            <td>: {{ $detail->tanggal}}</td>
                        </tr>
                        <tr>
                            <th>Nama Peminjaman </th>
                            <td>: {{ $detail->nama_peminjam}}</td>
                        </tr>
                        <tr>
                            <th>Telp/WA Peminjaman </th>
                            <td>: {{ $detail->kontak}}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $detail->alamat}}</td>
                        </tr>
                        <tr>
                            <th>Status Peminjaman</th>
                            <td>:
                                @if($detail->status == 0)
                                <span class=" badge badge-danger">Belum Dikembalikan</span>
                                @else
                                <span class="badge badge-success">Sudah Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="table-sm table-responsive p-3">
                <h5 class="mb-3">
                    List Barang Dipinjam
                </h5>
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->kode_item_barang }}</td>
                            <td>{{ $row->nama_item_barang }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>



@endsection