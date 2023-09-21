@extends ('sa.layout.main')
@section ('sa.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h5>Detail {{$detail->nama_bangunan}}</h5>
    <a href="{{route('superadmin.bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Kode Bangunan</th>
                    <td>: {{$detail->kode_bangunan}}</td>
                </tr>
                <tr>
                    <th>Nama Bangunan</th>
                    <td>: {{$detail->nama_bangunan}}</td>
                </tr>
                <tr>
                    <th>Deskripsi Bangunan</th>
                    <td>: {{$detail->deskripsi}}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan </th>
                    <td>: {{$detail->tanggal_pengadaan}}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>: {{$detail->nama}}, {{$detail->lokasi}}</td>
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
                    <th>Sumber Aset</th>
                    <td>:
                        @if ($detail->sumber === 'pembangunan')
                        Pembangunan
                        @elseif ($detail->sumber === 'pembelian')
                        Pembelian
                        @elseif ($detail->sumber === 'hibah')
                        Hibah
                        @endif

                    </td>
                </tr>
                <tr>
                    <th>Harga Perolehan</th>
                    <td>: Rp.{{ number_format(floatval($detail->harga_perolehan), 0, ',', '.') }}</td>

                    </td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>: {{$detail->keterangan}} </td>
                </tr>

            </table>
        </div>
    </div>
</div>
<br>

@endsection