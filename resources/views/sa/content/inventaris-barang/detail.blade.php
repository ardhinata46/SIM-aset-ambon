@extends ('sa.layout.main')
@section ('sa.content')
<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Spesifikasi {{$detail->nama_item_barang}}</h1>
    <a href="{{route('superadmin.inventaris_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th> Barang</th>
                    <td>: {{$detail ->kode_barang}} {{$detail->nama_barang}} </td>
                </tr>
                <tr>
                <tr>
                    <th>Kode Item Barang</th>
                    <td>: {{$detail->kode_item_barang}}</td>
                </tr>
                <tr>
                    <th>Nama Item Barang </th>
                    <td>: {{$detail->nama_item_barang}}</td>
                </tr>
                <tr>
                    <th>Merk/Type</th>
                    <td>: {{$detail->merk}}</td>
                </tr>
                <tr>
                    <th>Ruangan</th>
                    <td>: {{$detail->nama_ruangan}} {{$detail->nama_bangunan}}</td>
                </tr>
                <tr>
                    <th>Sumber Aset</th>
                    <td>: @if($detail ->sumber == 'pembelian')
                        Pembelian
                        @elseif($detail->sumber == 'hibah')
                        Hibah
                        @endif </td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan</th>
                    <td>: {{$detail->tanggal_pengadaan}} </td>
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
                    <td>: Rp.{{ number_format(floatval($detail ->harga_perolehan), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Status </th>
                    <td>:
                        @if ($detail->status == 1)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                        @endif


                    </td>
                </tr>
                <tr>
                    <th>Keterangan Barang</th>
                    <td>:
                        {{$detail->keterangan}}
                    </td>
                </tr>
                <tr>
                    <th>Keterangan Penghapusan</th>
                    <td>:
                        @if($detail->penghapusanBarang)
                        @if($detail->penghapusanBarang->tindakan == 'jual')
                        Dijual
                        @elseif($detail->penghapusanBarang->tindakan == 'hibah')
                        Dihibahkan
                        @elseif($detail->penghapusanBarang->tindakan == 'dihanguskan')
                        Dihanguskan
                        @endif
                        @else

                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br>

@endsection