@extends ('admin.layout.main')
@section ('admin.content')
<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail Perawatan Barang</h1>
    <a href="{{route('admin.perawatan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Kode Perawatan detail</th>
                    <td>: {{$detail->kode_perawatan_barang}}</td>
                </tr>
                <tr>
                <tr>
                    <th>Kode Barang</th>
                    <td>: {{$detail->kode}} {{$detail->barang}}</td>
                </tr>
                <tr>
                    <th>Tanggal Perawatan</th>
                    <td>: {{$detail->tanggal_perawatan}}</td>
                </tr>
                <tr>
                    <th>Kondisi Setelah Perawatan</th>
                    <td>:
                        @if($detail->kondisi_sesudah == 'baik')
                        <span class="badge badge-success">Baik</span>
                        @elseif($detail->kondisi_sesudah == 'rusak_ringan')
                        <span class="badge badge-warning">Rusak Ringan</span>
                        @elseif($detail->kondisi_sesudah == 'rusak_berat')
                        <span class="badge badge-danger">Rusak Berat</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Deskripsi Perawatan</th>
                    <td>: {{$detail->deskripsi}} </td>
                </tr>
                <tr>
                    <th>Biaya Perawatan</th>
                    <td>: Rp.{{ number_format(floatval($detail->biaya), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Nota</th>
                    <td>:
                        @if ($detail->nota)
                        <a href="{{ asset($detail->nota) }}" target="_blank">
                            <img src="{{ asset($detail->nota) }}" alt="Nota" style="width: 100px;" class="nota-image" title="Lihat Nota">
                        </a>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>
<br>

@endsection