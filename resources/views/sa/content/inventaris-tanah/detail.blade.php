@extends ('sa.layout.main')
@section ('sa.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail {{$tanah->nama_tanah}}</h1>
    <a href="{{route('superadmin.inventaris_tanah.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-tanah table-detail">
                <tr>
                    <th>Kode Aset Tanah</th>
                    <td>: {{$tanah->kode_tanah}}</td>
                </tr>
                <tr>
                    <th>Nama/Deskripsi Tanah</th>
                    <td>: {{$tanah->nama_tanah}}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan</th>
                    <td>: {{$tanah->tanggal_pengadaan}} </td>
                </tr>
                <tr>
                    <th>Lokasi Tanah</th>
                    <td>: {{$tanah->lokasi}}</td>
                </tr>
                <tr>
                    <th>Luas </th>
                    <td>: {{$tanah->luas}} m<sup>2 </td>
                </tr>
                <tr>
                    <th>Sumber Aset</th>
                    <td>:
                        @if ($tanah->sumber === 'pembelian')
                        Pembelian
                        @else ($tanah->sumber === 'hibah')
                        Hibah
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status </th>
                    <td>:
                        @if ($tanah->status == 1)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Harga Perolehan</th>
                    <td>: Rp.{{ number_format(floatval($tanah->harga_perolehan), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Keterangan Tanah</th>
                    <td>: {{$tanah->keterangan}}
                    </td>
                </tr>
                <tr>
                    <th>Keterangan Penghapusan</th>
                    <td>:
                        @if ($tanah->penghapusanTanah)
                        @if ($tanah->penghapusanTanah->tindakan == 'jual')
                        Dijual
                        @elseif ($tanah->penghapusanTanah->tindakan == 'hibah')
                        Dihibahkan
                        @elseif ($tanah->penghapusanTanah->tindakan == 'dihanguskan')
                        Dihanguskan
                        @endif
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br>

@endsection