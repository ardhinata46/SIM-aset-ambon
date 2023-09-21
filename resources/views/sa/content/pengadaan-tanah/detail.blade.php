@extends ('sa.layout.main')
@section ('sa.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail Pengadaan Aset Tanah</h1>
    <a href="{{route('superadmin.pengadaan_tanah.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Kode Pengadaan Tanah</th>
                    <td>: {{$detail->kode_pengadaan_tanah}}</td>
                </tr>
                <tr>
                    <th>Kode Tanah</th>
                    <td>: {{$detail->kode_tanah}}</td>
                </tr>
                <tr>
                    <th>Nama/Deskripsi Tanah</th>
                    <td>: {{$detail->nama_tanah}}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>: {{$detail->lokasi}}</td>
                </tr>
                <tr>
                    <th>Luas </th>
                    <td>: {{$detail->luas}} m<sup>2 </td>
                </tr>
                <tr>
                    <th>Sumber Aset</th>
                    <td>:
                        @if ($detail->sumber === 'pembelian')
                        Pembelian
                        @else ($detail->sumber === 'hibah')
                        Hibah
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan</th>
                    <td>: {{$detail->tanggal_pengadaan}} </td>
                </tr>
                <tr>
                    <th>Harga Perolehan</th>
                    <td>: Rp.{{ number_format(floatval($detail->harga_perolehan), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Keterangan</td>
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