@extends('sa.layout.main')

@section('sa.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail Penyusutan Nilai Aset Barang</h1>
    <a href="{{route('superadmin.penyusutan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-sm table-borderless table-detail">
                    <tr>
                        <th>Kode Barang</th>
                        <td>: {{ $barang->kode_item_barang }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>: {{ $barang->nama_item_barang }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengadaan</th>
                        <td>: {{ $barang->tanggal_pengadaan }}</td>
                    </tr>
                    <tr>
                        <th>Harga Perolehan</th>
                        <td>: Rp.{{ number_format(floatval($barang->harga_perolehan), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Umur Manfaat</th>
                        <td>: {{ $barang->umur_manfaat }} tahun</td>
                    </tr>
                    <tr>
                        <th>Nilai Residu</th>
                        <td>: Rp.{{ number_format(floatval($barang->nilai_residu), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Aset Tahun Ini</th>
                        <td>: Rp.{{ number_format(floatval($barang->nilai_aset_tahun_ini), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Penyusutan</th>
                        <td>: Rp.{{ number_format(floatval($barang->nilai_penyusutan), 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Nilai Aset Pertahunnya</h5>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Nilai Aset</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($nilaiAsetPertahun as $tahun => $nilai)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $tahun }}</td>
                            <td>Rp.{{ number_format($nilai, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <hr>
        </div>
    </div>
</div>
@endsection