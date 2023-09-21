@extends ('sa.layout.main')
@section ('sa.content')
<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Spesifikasi {{$itemBarang->nama_item_barang}}</h1>
    <a href="{{route('superadmin.barang.detail', ['id_barang' => $id_barang])}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <th>Barang</th>
                    <td>: {{$itemBarang->nama_barang}} {{$itemBarang->kode_barang}}</td>
                </tr>
                <tr>
                <tr>
                    <th>Kode Item Barang</th>
                    <td>: {{$itemBarang->kode_item_barang}}</td>
                </tr>
                <tr>
                    <th>Nama Item Barang </th>
                    <td>: {{$itemBarang->nama_item_barang}}</td>
                </tr>
                <tr>
                    <th>Merk/Type</th>
                    <td>: {{$itemBarang->merk}}</td>
                </tr>
                <tr>
                    <th>Sumber Aset</th>
                    <td>: @if($itemBarang->sumber == 'pembelian')
                        Pembelian
                        @elseif($itemBarang->sumber == 'hibah')
                        Hibah
                        @endif </td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan</th>
                    <td>: {{$itemBarang->tanggal_pengadaan}} </td>
                </tr>
                <tr>
                    <th>Kondisi</th>
                    <td>:
                        @if($itemBarang->kondisi == 'baik')
                        <span class="badge badge-success">Baik</span>
                        @elseif($itemBarang->kondisi == 'rusak_ringan')
                        <span class="badge badge-warning">Rusak Ringan</span>
                        @elseif($itemBarang->kondisi == 'rusak_berat')
                        <span class="badge badge-danger">Rusak Berat</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Harga Pengadaan</th>
                    <td>: Rp.{{ number_format(floatval($itemBarang->harga_perolehan), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>: {{$itemBarang->keterangan}} </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br>

@endsection