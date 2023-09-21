@extends ('sa.layout.main')
@section ('sa.content')
@include('sweetalert::alert')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Pengaturan</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body pengaturan">
                <div class="text-center mb-3">
                    <h6 class="font-weight-bold">{{ $profil->nama_aplikasi}}</h6>
                </div>
                <div class="text-center mb-3">
                    <img src="{{ asset($profil->logo) }}" alt="Logo Gereja" class="img-profil">
                </div>
                <div class="text-center mb-3">
                    <h6 class="font-weight-bold">{{ $profil->nama_organisasi}}</h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>
                                <a href="">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </a>
                            </th>
                            <td>{{$profil->email}}</td>
                        </tr>
                        <tr>
                            <th>
                                <a href="{{$profil->alamat}}" target="_blank">
                                    <i class="fas fa-map-marker-alt fa-lg"></i>
                                </a>
                            </th>
                            <td>{{$profil->alamat}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <form action="{{ route('superadmin.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Ubah Data Setting</h5>
                    <input type="hidden" name="updated_by" value="{{ $profil->updated_by }}">

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text " title="Nama Aplikasi"><i class="fas fa-globe"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nama_aplikasi" value="{{ $profil->nama_aplikasi }}" required>
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" title="Nama Organisasi"><i class="fas fa-church"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nama_organisasi" value="{{ $profil->nama_organisasi }}" required>
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" title="Email"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email" value="{{ $profil->email }}" required>
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" title="Alamat"> <i class="fas fa-map-marker-alt"></i></i></span>
                        </div>
                        <textarea class="form-control" name="alamat" required>{{ $profil->alamat }}</textarea>
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" title="Logo"><i class="fas fa-image"></i></span>
                        </div>
                        <input type="file" id="logo" name="logo" onchange="previewImage(event)" class="form-control" accept=".jpg, .jpeg, .png">
                    </div>
                    <img id="previewFoto" src="#" alt="Preview Foto" style="display: none; max-width: 100px; max-height: 100px;">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        var preview = document.getElementById('previewFoto');

        reader.onload = function() {
            preview.src = reader.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection