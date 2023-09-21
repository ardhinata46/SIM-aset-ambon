@extends ('sa.layout.main')
@section ('sa.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail Perawatan Bangunan</h1>
    <a href="{{route('superadmin.perawatan_bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Kode Perawatan</th>
                    <td>: {{$detail->kode_perawatan_bangunan}}</td>
                </tr>

                <tr>
                    <th>Bangunan </th>
                    <td>: {{$detail->kode}} {{$detail->bangunan}}</td>
                </tr>
                <tr>
                    <th>Tanggal Perawatan</th>
                    <td>: {{$detail->tanggal_perawatan}}</td>
                </tr>
                <tr>
                    <th>Deskripsi Perawatan</th>
                    <td>: {{$detail->deskripsi}} </td>
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
                    <th>Biaya Perawatan</th>
                    <td>: Rp.{{ number_format(floatval($detail->biaya), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>: {{$detail->keterangan}}</td>
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