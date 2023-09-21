@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengguna</h1>
    <a href="{{route('superadmin.pengguna.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <form method="POST" action="{{ route('superadmin.pengguna.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama">Nama Pengguna <span style="color: red">*</span></label>
                                <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna') }}" class="form-control @error('nama_pengguna') is-invalid @enderror" id="nama" required>
                                @error('nama_pengguna')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="d-flex flex-row align-items-center justify-content-between">
                                    <label for="email">Email <span style="color: red">*</span></label>
                                    <p style="color: red; font-size:12px" align="right">*Default password akun baru adalah 123456</p>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin <span style="color: red">*</span></label>
                                <div class="form-inline @error('jk') is-invalid @enderror">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" id="l" name="jk" class="custom-control-input" value="l" {{ old('jk') == 'l' ? 'checked' : '' }} required>
                                        <label class="custom-control-label" for="l">Laki-laki</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="p" name="jk" class="custom-control-input" value="p" {{ old('jk') == 'p' ? 'checked' : '' }}>
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
                                        <input type="radio" id="superadmin" name="role" class="custom-control-input" value="superadmin" {{ old('role') == 'superadmin' ? 'checked' : '' }} required>
                                        <label class="custom-control-label" for="superadmin">Super Admin</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="admin" name="role" class="custom-control-input" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="admin">Admin</label>
                                    </div>
                                </div>
                                @error('role')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kontak">Telepon/WA <span style="color: red">*</span></label>
                                <input type="number" name="kontak" value="{{ old('kontak') }}" class="form-control @error('kontak') is-invalid @enderror" id="kontak" required>
                                @error('kontak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat <span style="color: red">*</span></label>
                                <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control @error('alamat') is-invalid @enderror" id="alamat" required>
                                @error('alamat')
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