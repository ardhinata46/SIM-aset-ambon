@extends ('admin.layout.main')
@section ('admin.content')
<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Spesifikasi Item Barang</h1>
    <a href="{{route('admin.barang.detail', ['id_barang' => $id_barang])}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <td>Barang</td>
                    <td>: {{$itemBarang->nama_barang}} {{$itemBarang->kode_barang}}</td>
                </tr>
                <tr>
                <tr>
                    <td>Kode Item Barang</td>
                    <td>: {{$itemBarang->kode_item_barang}}</td>
                </tr>
                <tr>
                    <td>Nama Item Barang </td>
                    <td>: {{$itemBarang->nama_item_barang}}</td>
                </tr>
                <tr>
                    <td>Merk/Type</td>
                    <td>: {{$itemBarang->merk}}</td>
                </tr>
                <tr>
                    <td>Sumber</td>
                    <td>: @if($itemBarang->sumber == 'pembelian')
                        Pembelian
                        @elseif($itemBarang->sumber == 'hibah')
                        Hibah
                        @endif </td>
                </tr>
                <tr>
                    <td>Tanggal Pengadaan</td>
                    <td>: {{$itemBarang->tanggal_pengadaan}} </td>
                </tr>
                <tr>
                    <td>Kondisi</td>
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
                    <td>Harga Pengadaan</td>
                    <td>: Rp.{{ number_format(floatval($itemBarang->harga_perolehan), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{$itemBarang->keterangan}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br>

@endsection