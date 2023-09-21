@extends ('admin.layout.main')
@section ('admin.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Pengadaan Barang</h1>
    <a href="{{route('admin.pengadaan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('admin.pengadaan_barang.update', $pengadaanBarang->id_pengadaan_barang)}}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="kode_pengadaan_barang">Kode pengadaan Barang</label>
                    <input type="text" name="kode_pengadaan_barang" value="{{  $pengadaanBarang->kode_pengadaan_barang }}" class="form-control" id="kode_pengadaan_barang" readonly>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_pengadaan">Tanggal Pengadaan</label>
                    <input type="date" name="tanggal_pengadaan" max="{{ date('Y-m-d') }}" value="{{  $pengadaanBarang->tanggal_pengadaan }}" class="form-control @error('tanggal_pengadaan') is-invalid @enderror" id="tanggal_pengadaan" autofocus required>
                    @error('tanggal_pengadaan')
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
                        <label for="nota">Nota</label>
                        <input type="file" name="nota" value="{{ old('nota') }}" class="form-control @error('nota') is-invalid @enderror" id="nota" accept="image/*">
                        @error('nota')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sumber<span style="color: red">*</span></label>
                        <div class="form-inline @error('sumber') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="sumber_pembelian" name="sumber" class="custom-control-input" value="pembelian" {{ $pengadaanBarang->sumber === 'pembelian' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_pembelian">Pembelian</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="sumber_hibah" name="sumber" class="custom-control-input" value="hibah" {{ $pengadaanBarang->sumber === 'hibah' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_hibah">Hibah</label>
                            </div>
                            @error('sumber')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control" id="keterangan">{{ $pengadaanBarang->keterangan }}</textarea>
                    @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

@endsection