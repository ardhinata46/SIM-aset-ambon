@extends('sa.layout.main')

@section('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Detail {{ $pengguna->nama_pengguna }}</h1>
    <a href="{{route('superadmin.pengguna.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ asset($pengguna->foto) }}" target="_blank" title="Lihat Foto">
                    <img src="{{ asset($pengguna->foto) }}" alt="Foto Pengguna" class="card-img">
                </a>
            </div>

            <div class="col-md-8">
                <table class="table table-sm  table-borderless">
                    <tr>
                        <th>Nama</th>
                        <td>: {{ $pengguna->nama_pengguna }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>:
                            @if ($pengguna->jk === 'l')
                            Laki-laki
                            @elseif ($pengguna->jk === 'p')
                            Perempuan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>: @if ($pengguna->role === 'superadmin')
                            Superadmin
                            @else ($pengguna->role === 'admin')
                            Admin
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: {{ $pengguna->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon/WA</th>
                        <td>: {{ $pengguna->kontak }}</td>
                    </tr>

                    <tr>
                        <th>Status </th>
                        <td>:
                            @if ($pengguna->status == 1)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $pengguna->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection