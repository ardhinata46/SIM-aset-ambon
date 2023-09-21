@extends ('admin.layout.main')
@section ('admin.content')
<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Spesifikasi Aset Barang</h1>
    <a href="{{route('admin.inventaris_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-detail">
                <tr>
                    <td> Barang</td>
                    <td>: {{$detail ->kode_barang}} {{$detail->nama_barang}} </td>
                </tr>
                <tr>
                <tr>
                    <td>Kode Item Barang</td>
                    <td>: {{$detail->kode_item_barang}}</td>
                </tr>
                <tr>
                    <td>Nama Item Barang </td>
                    <td>: {{$detail->nama_item_barang}}</td>
                </tr>
                <tr>
                    <td>Merk/Type</td>
                    <td>: {{$detail->merk}}</td>
                </tr>
                <tr>
                    <td>Ruangan</td>
                    <td>: {{$detail->nama_ruangan}} {{$detail->nama_bangunan}}
                    </td>
                </tr>
                <tr>
                    <td>Sumber Aset</td>
                    <td>: @if($detail ->sumber == 'pembelian')
                        Pembelian
                        @elseif($detail->sumber == 'hibah')
                        Hibah
                        @endif </td>
                </tr>
                <tr>
                    <td>Tanggal Pengadaan</td>
                    <td>: {{$detail->tanggal_pengadaan}} </td>
                </tr>
                <tr>
                    <td>Kondisi</td>
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
                    <td>Harga Pengadaan</td>
                    <td>: Rp.{{ number_format(floatval($detail ->harga_perolehan), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Umur Manfaat</td>
                    <td>: {{$detail->umur_manfaat}} Tahun</td>
                </tr>
                <tr>
                    <td>Nilai Residu</td>
                    <td>: Rp.{{ number_format(floatval($detail ->nilai_residu), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Status </td>
                    <td>:
                        @if ($detail->status == 1)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                        @endif


                    </td>
                </tr>
                <tr>
                    <td>Keterangan Barang</td>
                    <td>:
                        {{$detail->keterangan}}
                    </td>
                </tr>
                <tr>
                    <td>Keterangan Penghapusan</td>
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