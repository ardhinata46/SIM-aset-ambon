<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{URL::asset('assets/img/logo/logo.png')}}" rel="icon">
    <title>{{$title}}</title>
    <link href="{{URL::asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/css/ruang-admin.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="table-responsive">

                                        <div class="data py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h3 class="text-center mb-3">Spesifikasi {{$detail->nama_item_barang}}</h3>
                                            <div class="text-center">
                                                <img class="logo" src="{{ asset($profil->logo) }}" style="height: 90px;">
                                                <p>{{ $profil->nama_aplikasi }}</p>
                                            </div>
                                        </div>
                                        <table class="table table-sm">
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
                                                    <span class=" badge badge-success">Baik</span>
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
                                                <th>Keterangan</th>
                                                <td>:
                                                    {{$detail->keterangan}}
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="{{URL::asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{URL::asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ruang-admin.min.js')}}"></script>
</body>

</html>