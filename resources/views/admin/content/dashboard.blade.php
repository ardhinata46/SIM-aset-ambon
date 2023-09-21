@extends ('admin.layout.main')
@section ('admin.content')

<div class="row">
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-body">
                <div id="kondisiBarang" style="height:200px">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="row mb-3">

            <!-- Pending Requests Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <a href="{{route('superadmin.kategori_barang.index')}}">
                    <div class="card dashboard" style="height: 106px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Kategori Barang</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahKategoriBarang}}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tag fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card dashboard" style="height: 106px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Barang Non-Aktif</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$jumlahItemBarangNonAktif}}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ban fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card dashboard" style="height: 106px;">
                    <a href="{{route('superadmin.peminjaman_barang.index')}}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Peminjaman Barang</div>
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$peminjaman}}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-handshake fa-2x text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card dashboard" style="height: 106px;">
                    <a href="{{route('superadmin.perawatan_barang.index')}}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Perawatan Barang</div>
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$perawatanBarang}}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-toolbox fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script src=" https://code.highcharts.com/highcharts.js">
</script>

<script>
    // Create the chart
    Highcharts.chart('kondisiBarang', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Kondisi Barang',
            align: 'center'
        },

        accessibility: {
            announceNewData: {
                enabled: true
            },
            point: {
                valueSuffix: '%'
            }
        },

        plotOptions: {
            series: {
                borderRadius: 5,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [{
            name: 'Kondisi',
            colorByPoint: true,
            data: [{
                    name: 'Baik',
                    y: <?php echo $barangBaik; ?>,
                    color: 'green',
                    drilldown: 'Baik'
                },
                {
                    name: 'Rusak Ringan',
                    y: <?php echo $barangRusakRingan; ?>,
                    color: 'orange',
                    drilldown: 'Rusak Ringan'
                },
                {
                    name: 'Rusak Berat',
                    y: <?php echo $barangRusakBerat; ?>,
                    color: 'red',
                    drilldown: 'Rusak Berat'
                }
            ]
        }],
        drilldown: {
            series: [{
                    name: 'Baik',
                    id: 'Baik',
                    data: [
                        [
                            'v97.0',
                            36.89
                        ],
                        // Data lainnya
                    ]
                },
                {
                    name: 'Rusak Ringan',
                    id: 'Rusak Ringan',
                    data: [
                        [
                            'v15.3',
                            0.1
                        ],
                        // Data lainnya
                    ]
                },
                {
                    name: 'Rusak Berat',
                    id: 'Rusak Berat',
                    data: [
                        [
                            'v97',
                            6.62
                        ],
                        // Data lainnya
                    ]
                },

            ]
        }
    });
</script>


@endsection