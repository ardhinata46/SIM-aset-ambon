@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail Pengadaan Bangunan</h1>
    <a href="{{route('superadmin.pengadaan_bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Kode Pengadaan</th>
                    <td>: {{$detail->kode_pengadaan_bangunan}}</td>
                </tr>
                <tr>

                <tr>
                    <th>Kode Bangunan </th>
                    <td>: {{$detail->kode_bangunan}}</td>
                </tr>
                <tr>
                    <th>Nama Bangunan</th>
                    <td>: {{$detail->nama_bangunan}}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>: {{$detail->deskripsi}} </td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan</th>
                    <td>: {{$detail->tanggal_pengadaan}}</td>
                </tr>
                <tr>
                    <th>Tanah & Lokasi</th>
                    <td>: {{$detail->nama}}, {{$detail->lokasi}}</td>
                </tr>
                <tr>
                    <th>Sumber</th>
                    <td>: @if($detail->sumber == 'pembangunan')
                        Pembangunan
                        @elseif($detail->sumber == 'pembelian')
                        Pembelian
                        @elseif($detail->sumber == 'hibah')
                        Hibah
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Kondisi</th>
                    <td>:
                        @if($detail->kondisi == 'baik')
                        <span class="badge badge-success">Baik</span>
                        @elseif($detail->kondisi == 'rusak_ringan')
                        <span class="badge badge-warning">Rusak Ringan</span>
                        @elseif($detail->kondisi == 'rusak_berat')
                        <span class="badge badge-danger">Rusak Berat</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Harga Pengadaan</th>
                    <td>: Rp.{{ number_format(floatval($detail->harga_perolehan), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>: {{$detail->keterangan}} </td>
                </tr>
                <tr>
                    <th>Nota</th>
                    <td>:
                        @if ($detail->nota)
                        <a href="{{ asset($detail->nota) }}" target="_blank" title="Lihat Nota">
                            <img src="{{ asset($detail->nota) }}" alt="Nota" class="nota-image">
                        </a>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection