<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$namaFile}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table-header {
            border-collapse: collapse;
        }

        .table-header th,
        .table-header td {
            border: none;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .data {
            margin-left: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
            font-size: 12px;
        }

        th {
            text-align: left;
        }

        p {
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
    <table class="table-header">
        <tr>
            <th><img class="logo" src="{{ $logoProfil }}" alt="Logo Profil"></th>
            <td>
                <h3>{{$nama}}</h3>
                <p>Email : {{ $email }}</p>
                <p>{{ $alamat }}</p>
            </td>
        </tr>
    </table>
    <hr>
    <h5 style="text-align: center;">{{$namaFile}}</h5>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Pengadaan Bangunan</th>
                <th>Sumber</th>
                <th>Kode Bangunan</th>
                <th>Nama Bangunan</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
                <th>Harga Perolehan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengadaanBangunan as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->tanggal_pengadaan}}</td>
                <td>{{$row->kode_pengadaan_bangunan}}</td>
                <td>
                    @if ($row->sumber === 'pembangunan')
                    Pembangunan
                    @elseif ($row->sumber === 'pembelian')
                    Pembelian
                    @else ($row->sumber === 'hibah')
                    Hibah
                    @endif
                </td>
                <td>{{$row->kode_bangunan}}</td>
                <td>{{$row->nama_bangunan}}</td>
                <td>{{$row->deskripsi}}</td>
                <td>{{$row->nama_tanah}}, {{$row->lokasi}}</td>
                <td>
                    @if($row->kondisi == 'baik')
                    Baik
                    @elseif($row->kondisi == 'rusak_ringan')
                    Rusak Ringan
                    @elseif($row->kondisi == 'rusak_berat')
                    Rusak Berat
                    @endif
                </td>
                <td>Rp. {{ number_format(floatval($row->harga_perolehan), 0, ',', '.') }}</td>
                <td>{{$row->keterangan}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>