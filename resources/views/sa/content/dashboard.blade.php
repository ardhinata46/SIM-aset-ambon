@extends ('sa.layout.main')
@section ('sa.content')

<div class="card mb-3">
    <div class="card-body">
        <div class="text-right">
            <h3>Total Nilai Aset Saat Ini = Rp. {{ number_format($totalKekayaan, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-body">
                <div id="chartJumlahAset" style="height:200px">
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div id="kondisiBarang" style="height:200px">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <a href="{{route('superadmin.pengguna.index')}}">
                    <div class="card dashboard" style="height: 106px;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Pengguna</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahPengguna}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <a href="{{route('superadmin.ruangan.index')}}">
                    <div class="card dashboard" style="height: 106px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Ruangan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$ruangan}}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-door-open fa-2x text-success "></i>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
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
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card dashboard" style="height: 106px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Aset Aktif</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalAsetAktif}}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card dashboard" style="height: 106px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Aset Non-Aktif</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$totalAsetNonAktif}}</div>
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
        </div>
    </div>

</div>

<!-- <div class="card mb-3">
    <div class="card-body">
        <div id="chartNilaiAset">
        </div>
    </div>
</div> -->


@endsection

@section('footer')
<script src=" https://code.highcharts.com/highcharts.js">
</script>

<script>
    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

    // Create the chart
    Highcharts.chart('chartJumlahAset', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'center',
            text: 'Aset Aktif'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total Jumlah Aset Aktif'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },
        series: [{
            name: 'Aset',
            colorByPoint: true,
            data: [{
                    name: 'Aset Tanah',
                    y: <?php echo $jumlahTanah; ?>,
                    color: 'blue',
                    drilldown: 'Tanah'
                },
                {
                    name: 'Aset Bangunan',
                    y: <?php echo $jumlahBangunan; ?>,
                    color: 'green',
                    drilldown: 'Bangunan'
                },
                {
                    name: 'Aset Barang',
                    y: <?php echo $jumlahItemBarang; ?>,
                    color: 'red',
                    drilldown: 'ItemBarang'
                }
            ]
        }],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: [
                // Drilldown data
            ]
        }
    });
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

<script>
    Highcharts.chart('chartNilaiAset', {

        title: {
            text: 'Grafik Total Nilai Aset Pertahun',
            align: 'center'
        },

        yAxis: {
            title: {
                text: 'Total Nilai Aset'
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2020'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 2010
            }
        },

        series: [{
            name: 'Installation & Developers',
            data: [43934, 48656, 65165, 81827, 112143, 142383,
                171533, 165174, 155157, 161454, 154610
            ]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>

@endsection