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
    <div class="table-responsive p-3">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Kode Item Barang</th>
                    <th>Nama Item Barang</th>
                    <th>Merk</th>
                    <th>Tanggal Pengadaan</th>
                    <th>Sumber Aset</th>
                    <th>Harga Perolehan</th>
                    <th>Kondisi</th>

                </tr>
            </thead>
            <tbody>
                @foreach($itemBarang as $row)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->barang}}</td>
                    <td>{{$row->kode_item_barang}}</td>
                    <td>{{$row->nama_item_barang}}</td>
                    <td>{{$row->merk}}</td>
                    <td>{{$row->tanggal_pengadaan}}</td>
                    <td> @if($row->sumber == 'pembelian')
                        Pembelian
                        @else($row->sumber == 'hibah')
                        Hibah
                        @endif
                    </td>
                    <td>Rp. {{ number_format(floatval($row->harga_perolehan), 0, ',', '.') }}</td>
                    <td>
                        @if($row->kondisi == 'baik')
                        <span class="badge badge-success">Baik</span>
                        @elseif($row->kondisi == 'rusak_ringan')
                        <span class="badge badge-warning">Rusak Ringan</span>
                        @elseif($row->kondisi == 'rusak_berat')
                        <span class="badge badge-danger">Rusak Berat</span>
                        @endif
                    </td>


                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</body>

</html>