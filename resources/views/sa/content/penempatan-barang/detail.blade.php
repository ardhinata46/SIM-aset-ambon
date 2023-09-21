@extends ('sa.layout.main')
@section ('sa.content')


<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Penempatan Barang di {{ $detail->nama }}</h1>
    <a href="{{route('superadmin.penempatan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>


<div class="card mb-3">
    <div class="card-body">
        <table class="table table-sm table-borderless table-detail">
            <tr>
                <th>Kode Penempatan Barang</th>
                <td>: {{ $detail->kode_penempatan_barang}}</td>
            </tr>
            <tr>
                <th>Ruangan</th>
                <td>: {{ $detail->kode}} {{ $detail->nama}}</td>
            </tr>
            <tr>
                <th>Tanggal Penempatan</th>
                <td>: {{ $detail->tanggal}}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>: {{ $detail->keterangan}}</td>
            </tr>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class=" table-responsive">
            <h5>List Barang</h5>
            <table class="table table-sm align-items-center table-flush" id="myTable">
                <thead class=" thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Item Barang</th>
                        <th>Nama Item Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item as $row)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->kode_item_barang}}</td>
                        <td>{{$row->nama_item_barang}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection