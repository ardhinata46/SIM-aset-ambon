@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah {{$ruangan->nama_ruangan}}</h1>
    <a href="{{route('superadmin.ruangan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
            <form method="POST" action="{{route('superadmin.ruangan.update', $ruangan->id_ruangan)}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="kode_ruangan">Kode Ruangan</label>
                        <input type="text" name="kode_ruangan" value="{{$ruangan->kode_ruangan}}" class="form-control" id="kode_ruangan" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nama_ruangan">Nama Ruangan <span style="color: red">*</span></label>
                        <input type="text" name="nama_ruangan" value="{{$ruangan->nama_ruangan}}" class="form-control" id="nama_ruangan" autofocus required>
                    </div>

                    <input type="hidden" name="created_by" value="{{$ruangan->created_by}}">

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection