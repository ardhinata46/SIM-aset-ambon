@extends ('sa.layout.main')
@section ('sa.content')
<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail {{$bangunan->nama_bangunan}}</h1>
    <a href="{{route('superadmin.inventaris_bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Kode Bangunan</th>
                    <td>: {{$bangunan->kode_bangunan}}</td>
                </tr>
                <tr>
                    <th>Nama Bangunan</th>
                    <td>: {{$bangunan->nama_bangunan}}</td>
                </tr>
                <tr>
                    <th>Deskripsi Bangunan</th>
                    <td>: {{$bangunan->deskripsi}}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan </th>
                    <td>: {{$bangunan->tanggal_pengadaan}}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>: {{$bangunan->nama}}, {{$bangunan->lokasi}}</td>
                </tr>
                <tr>
                    <th>Kondisi</th>
                    <td>:
                        @if($bangunan->kondisi == 'baik')
                        <span class="badge badge-success">Baik</span>
                        @elseif($bangunan->kondisi == 'rusak_ringan')
                        <span class="badge badge-warning">Rusak Ringan</span>
                        @elseif($bangunan->kondisi == 'rusak_berat')
                        <span class="badge badge-danger">Rusak Berat</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Sumber Aset</th>
                    <td>:
                        @if ($bangunan->sumber === 'pembangunan')
                        Pembangunan
                        @elseif ($bangunan->sumber === 'pembelian')
                        Pembelian
                        @elseif ($bangunan->sumber === 'hibah')
                        Hibah
                        @endif

                    </td>
                </tr>
                <tr>
                    <th>Harga Perolehan</th>
                    <td>: Rp.{{ number_format(floatval($bangunan->harga_perolehan), 0, ',', '.') }}</td>

                    </td>
                </tr>
                <tr>
                    <th>Status </th>
                    <td>:
                        @if ($bangunan->status == 1)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Keterangan Bangunan</th>
                    <td>: {{$bangunan->keterangan}}
                    </td>
                </tr>
                <tr>
                    <th>Keterangan Penghapusan</th>
                    <td>: @if ($bangunan->penghapusanBangunan)
                        @if ($bangunan->penghapusanBangunan->tindakan == 'jual')
                        Dijual
                        @elseif ($bangunan->penghapusanBangunan->tindakan == 'hibah')
                        Dihibahkan
                        @elseif ($bangunan->penghapusanBangunan->tindakan == 'dihanguskan')
                        Dihanguskan
                        @endif
                        @endif</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br>

@endsection