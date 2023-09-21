@extends('sa.layout.main')

@section('sa.content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pengguna</h1>
    <a href="{{ route('superadmin.pengguna.index') }}" class="btn btn-primary">Kembali</a>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="profile-image">
                <img src="{{ asset($user->foto) }}" alt="Foto Pengguna" class="card-img-top">
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <td>Nama</td>
                        <td>{{ $user->nama_pengguna }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Telepon/WA</td>
                        <td>{{ $user->kontak }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>
                            @if ($user->jk === 'l')
                            Laki-laki
                            @elseif ($user->jk === 'p')
                            Perempuan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Status Pengguna</td>
                        <td>
                            @if ($user->status == 1)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{ $user->alamat }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfil" id="#myBtn">
                    Ubah Profil
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editProfil" tabindex="-1" role="dialog" aria-labelledby="editProfilLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfilLabel">Ubah Profil Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('superadmin.pengguna.update', $user->id_pengguna) }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="status" value="{{$user->status}}">
                    <input type="hidden" name="role" value="{{$user->role}}">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama_pengguna" value="{{$user->nama_pengguna}}" class="form-control @error('nama_pengguna') is-invalid @enderror" id="nama" placeholder="Nama" required>
                        @error('nama_pengguna')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{$user->email}}" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" value="" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="*********" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="form-inline  @error('jk') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="l" name="jk" class="custom-control-input" value="l" {{ $user->jk === 'l' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="l">Laki-laki</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="p" name="jk" class="custom-control-input" value="p" {{ $user->jk === 'p' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="p">Perempuan</label>
                            </div>
                        </div>
                        @error('jk')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" value="{{$user->alamat}}" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat" required>
                        @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kontak">Telepon/WA</label>
                        <input type="number" name="kontak" value="{{$user->kontak}}" class="form-control @error('kontak') is-invalid @enderror" id="kontak" placeholder="Kontak" required>
                        @error('kontak')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control" id="foto" accept="image/*" onchange="previewImage(event)">
                        @error('foto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <img id="previewFoto" src="#" alt="Preview Foto" style="display: none; max-width: 200px; max-height: 200px;">
                    <div class="row text-right">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>



@endsection