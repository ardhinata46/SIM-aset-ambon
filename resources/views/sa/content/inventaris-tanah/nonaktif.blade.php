@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Penghapusan Aset Tanah</h1>
    <a href="{{route('superadmin.inventaris_tanah.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('superadmin.inventaris_tanah.store_penghapusan', $tanah->id_tanah )}}">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="kode_penghapusan_tanah">Kode Penghapusan Tanah</label>
                    <input type="text" name="kode_penghapusan_tanah" value="{{ old('kode_penghapusan_tanah', $nextKodePenghapusanTanah) }}" class="form-control" id="kode_penghapusan_tanah" readonly>
                </div>
                <div class="col-md-6">
                    <label for="tanggal">Tanggal Penghapusan</label>
                    <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required>
                    @error('tanggal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_tanah">Tanah</label>
                        <input type="text" name="id_tanah" value="{{ $tanah->kode_tanah}} {{ $tanah->nama_tanah}}" class="form-control" id="id_tanah" readonly>
                        @error('id_tanah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <label for="tindakan">Tindakan Penghapusan</label>
                    <div>
                        <div class=" form-check form-check-inline @error('tindakan') is-invalid @enderror">
                            <input class="form-check-input" type="radio" name="tindakan" id="jual" value="jual" {{ old('tindakan') === 'jual' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jual">Dijual</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tindakan" id="hibah" value="hibah" {{ old('tindakan') === 'hibah' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="hibah">Dihibahkan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tindakan" id="dihanguskan" value="dihanguskan" {{ old('tindakan') === 'dihanguskan' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="dihanguskan">Dihanguskan</label>
                        </div>
                    </div>
                    @error('tindakan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control" id="keterangan">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value=" Simpan">
        </div>
    </div>

</form>
@endsection