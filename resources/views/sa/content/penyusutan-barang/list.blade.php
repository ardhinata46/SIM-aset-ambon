@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Penyusutan Nilai Aset Barang</h1>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table" id="myTable">
                    <thead class=" thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode, Nama Barang</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Harga Perolehan</th>
                            <th>Umur Manfaat</th>
                            <th>Pemakaian</th>
                            <th>Nilai Residu</th>
                            <th>Nilai Aset Tahun Sekarang</th>
                            <th>Nilai Penyusutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->kode_item_barang }} {{ $row->nama_item_barang }}</td>
                            <td>{{ $row->tanggal_pengadaan }}</td>
                            <td>Rp.{{ number_format($row->harga_perolehan, 0, ',', '.') }}</td>
                            <td>{{ $row->umur_manfaat }} tahun</td>
                            <td>{{ $row->tahunPenggunaan }} Tahun</td>
                            <td>Rp.{{ number_format($row->nilai_residu, 0, ',', '.') }}</td>
                            <td>Rp.{{ number_format($row->nilaiAsetTahunIni, 0, ',', '.') }}</td>
                            <td>Rp.{{ number_format($row->nilai_penyusutan, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('superadmin.penyusutan_barang.detail', $row->id_item_barang) }}" data-toggle="tooltip" data-placement="top" title="Info" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
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