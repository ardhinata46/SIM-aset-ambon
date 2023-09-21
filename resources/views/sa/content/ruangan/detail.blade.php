@extends('sa.layout.main')

@section('sa.content')
@include('sweetalert::alert')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail {{ $ruangan->nama_ruangan }}</h1>
    <a href="{{route('superadmin.ruangan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <table class="table table-sm table-borderless table-detail">
            <tr>
                <th>Bangunan Lokasi Ruangan</th>
                <td>: {{ $ruangan->nama }}</td>
            <tr>
                <th>Kode Ruangan</th>
                <td>: {{ $ruangan->kode_ruangan }}</td>
            </tr>
            <tr>
                <th>Nama Ruangan</th>
                <td>: {{ $ruangan->nama_ruangan }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Data Barang di {{ $ruangan->nama_ruangan }}</h5>
        <table class="table align-items-center table-flush" id="myTable">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Kode Item Barang</th>
                    <th>Nama Item Barang</th>
                    <th>Tanggal Penempatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $counter = 1;
                @endphp
                @foreach ($detailPenempatan as $detail)
                @foreach ($detail['itemPenempatan'] as $itemPenempatan)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>{{ $itemPenempatan->kode_item_barang }}</td>
                    <td>{{ $itemPenempatan->nama_item_barang }}</td>
                    <td>{{ $detail['penempatan']->tanggal }}</td>
                    <td>
                        <a href="{{ route('superadmin.ruangan.mutasi_barang', $itemPenempatan->id_item_barang) }}" class="btn btn-outline-primary btn-sm" title="Mutasi Barang"> <i class="fas fa-exchange-alt"></i></a>
                        <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Barang Dari Ruangan" data-toggle="modal" data-target="#DeleteModal-{{ $itemPenempatan->id_item_penempatan_barang }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="DeleteModal-{{ $itemPenempatan->id_item_penempatan_barang }}" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel-{{ $itemPenempatan->id_item_penempatan_barang }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="DeleteModalLabel-{{ $itemPenempatan->id_item_penempatan_barang }}">Peringatan!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Anda yakin ingin menghapus data {{ $itemPenempatan->kode_item_barang }} {{ $itemPenempatan->nama_item_barang }}?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('superadmin.ruangan.delete_item', $itemPenempatan->id_item_penempatan_barang) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                $counter++;
                @endphp
                @endforeach
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection