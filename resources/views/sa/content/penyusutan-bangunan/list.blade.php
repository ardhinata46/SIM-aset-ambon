@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="d-sm-flex  mb-4">
    <h1 class="h3 mb-0 text-gray-800">Penyusutan Nilai Aset Bangunan</h1>
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
                            <th>Kode, Nama Bangunan</th>
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
                        @foreach($bangunans as $row)

                        @php
                        $tahunSekarang = date('Y');
                        $jumlahTahunBerlalu = $tahunSekarang - date('Y', strtotime($row->tanggal_pengadaan));
                        $nilaiAsetTahunIni = $row->harga_perolehan - ($row->nilai_penyusutan * $jumlahTahunBerlalu);
                        if ($nilaiAsetTahunIni < 0) { $nilaiAsetTahunIni=0; } @endphp <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->kode_bangunan}} {{$row->nama_bangunan}}</td>
                            <td>{{$row->tanggal_pengadaan}}</td>
                            <td>Rp.{{ number_format($row->harga_perolehan, 0, ',', '.') }}</td>
                            <td>{{$row->umur_manfaat}} tahun</td>
                            <td>{{$row->tahunPenggunaan}} Tahun</td>
                            <td>Rp.{{ number_format($row->nilai_residu, 0, ',', '.') }}</td>
                            <td>Rp.{{ number_format($row->nilaiAsetTahunIni, 0, ',', '.') }}</td>
                            <td>Rp.{{ number_format($row->nilai_penyusutan, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('superadmin.penyusutan_bangunan.detail', $row->id_bangunan) }}" data-toggle="tooltip" data-placement="top" title="Info" class="btn btn-outline-info btn-sm">
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