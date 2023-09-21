@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Data {{$pengguna->nama_pengguna}}</h1>
    <a href="{{route('superadmin.pengguna.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <form method="POST" action="{{ route('superadmin.pengguna.update', $pengguna->id_pengguna) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama">Nama Pengguna <span style="color: red">*</span></label>
                                <input type="text" name="nama_pengguna" value="{{$pengguna->nama_pengguna}}" class="form-control @error('nama_pengguna') is-invalid @enderror" id="nama" required>
                                @error('nama_pengguna')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span style="color: red">*</span></label>
                                <input type="email" name="email" value="{{$pengguna->email}}" class="form-control @error('email') is-invalid @enderror" id="email" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin <span style="color: red">*</span></label>
                                <div class="form-inline  @error('jk') is-invalid @enderror">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" id="l" name="jk" class="custom-control-input" value="l" {{ $pengguna->jk === 'l' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="l">Laki-laki</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="p" name="jk" class="custom-control-input" value="p" {{ $pengguna->jk === 'p' ? 'checked' : '' }}>
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
                                <label>Role <span style="color: red">*</span></label>
                                <div class="form-inline @error('role') is-invalid @enderror">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" id="superadmin" name="role" class="custom-control-input" value="superadmin" {{ $pengguna->role === 'superadmin' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="superadmin">Super Admin</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="admin" name="role" class="custom-control-input" value="admin" {{ $pengguna->role === 'admin' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="admin">Admin</label>
                                    </div>
                                    @error('role')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="alamat">Alamat <span style="color: red">*</span></label>
                                <input type="text" name="alamat" value="{{$pengguna->alamat}}" class="form-control @error('alamat') is-invalid @enderror" id="alamat" required>
                                @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kontak">Telepon/WA <span style="color: red">*</span></label>
                                <input type="number" name="kontak" value="{{$pengguna->kontak}}" class="form-control @error('kontak') is-invalid @enderror" id="kontak" required>
                                @error('kontak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Status <span style="color: red">*</span></label>
                                <div class="form-inline  @error('status') is-invalid @enderror">
                                    <div class="custom-control custom-radio  mr-3">
                                        <input type="radio" id="1" name="status" class="custom-control-input" value="1" {{ $pengguna->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="1">Aktif</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="0" name="status" class="custom-control-input" value="0" {{ $pengguna->status == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="0">Non-aktif</label>
                                    </div>
                                </div>
                                @error('status')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection