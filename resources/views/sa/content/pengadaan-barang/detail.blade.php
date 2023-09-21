@extends ('sa.layout.main')
@section ('sa.content')


<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail Pengadaan Barang</h1>
    <a href="{{route('superadmin.pengadaan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <table class="table table-sm table-borderless table-detail">
            <tr>
                <th>Kode Pengadaan</th>
                <td>: {{ $detail->kode_pengadaan_barang}}</td>
            </tr>
            <tr>
                <th>Tanggal Pengadaan Barang</th>
                <td>: {{ $detail->tanggal_pengadaan}}</td>
            </tr>
            <tr>
                <th>Sumber Aset</th>
                <td>:
                    @if ($detail->sumber === 'pembelian')
                    Pembelian
                    @elseif ($detail->sumber === 'hibah')
                    Hibah
                    @endif
                </td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>: {{ $detail->keterangan}}</td>
            </tr>

            <tr>
                <th>Nota</th>
                <td>
                    : @if($detail->nota)
                    <a href="{{ asset($detail->nota) }}" target="_blank" title="Lihat Nota">
                        <img src="{{ asset($detail->nota) }}" alt="Nota" class="nota-image">
                    </a>
                    @endif
                </td>
            </tr>

        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>
            Item Pengadaan Barang
        </h5>
    </div>
    <div class="card-body">
        <div class="table-sm table-responsive">

            <table class="table align-items-center table-flush">
                <thead class=" thead-light">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Item Barang</th>
                        <th>Merk/Type</th>
                        <th>Harga Perolehan</th>
                        <th>Umur Manfaat</th>
                        <th>Nilai Residu</th>
                        <th>Jumlah Item</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($item as $row)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->nama_barang}}</td>
                        <td>{{$row->nama_item_barang}}</td>
                        <td>{{$row->merk}}</td>
                        <td>Rp. {{ number_format(floatval($row->harga_perolehan), 0, ',', '.') }}</td>

                        <td>{{$row->umur_manfaat}}</td>
                        <td>Rp. {{ number_format(intval($row->nilai_residu), 0, ',', '.') }}</td>

                        <td>{{$row->jumlah}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection