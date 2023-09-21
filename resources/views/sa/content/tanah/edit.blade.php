@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Data {{ $tanah->nama_tanah }}</h1>
    <a href="{{route('superadmin.tanah.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('superadmin.tanah.update', $tanah->id_tanah)}}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">

                <input type="hidden" name="created_by" value="{{ $tanah->created_by }}">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_tanah">Kode Tanah</label>
                        <input type="text" name="kode_tanah" value="{{ $tanah->kode_tanah }}" class="form-control @error('kode_tanah') is-invalid @enderror" id="kode_tanah" readonly>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi Tanah<span style="color: red">*</span></label>
                        <input type="text" name="lokasi" value="{{ $tanah->lokasi }}" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" required>
                        @error('lokasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_pengadaan">Tanggal Pengadaan <span style="color: red">*</span></label>
                        <input type="date" name="tanggal_pengadaan" max="{{ date('Y-m-d') }}" value="{{ $tanah->tanggal_pengadaan}}" class="form-control @error('tanggal_pengadaan') is-invalid @enderror" id="tanggal_pengadaan" required>
                        @error('tanggal_pengadaan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sumber Aset<span style="color: red">*</span></label>
                        <div class="form-inline @error('sumber') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="sumber_pembelian" name="sumber" class="custom-control-input" value="pembelian" {{ $tanah->sumber === 'pembelian' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_pembelian">Pembelian</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="sumber_hibah" name="sumber" class="custom-control-input" value="hibah" {{ $tanah->sumber === 'hibah' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_hibah">Hibah</label>
                            </div>
                        </div>
                        @error('sumber')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_tanah">Nama/Deskripsi Tanah <span style="color: red">*</span></label>
                        <input type="text" name="nama_tanah" value="{{ $tanah->nama_tanah }}" class="form-control @error('nama_tanah') is-invalid @enderror" id="nama_tanah" required>
                        @error('nama_tanah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="luas">Luas (Meter<sup>2</sup>) <span style="color: red">*</span></label>
                        <input type="number" name="luas" value="{{ $tanah->luas }}" class="form-control @error('luas') is-invalid @enderror" id="luas" required>
                        @error('luas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="harga_perolehan">Harga Perolehan (Rp.) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="harga_perolehan" value="{{ number_format($tanah->harga_perolehan, 0, ',', '.') }}" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" required>
                        @error('harga_perolehan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ $tanah->keterangan }}</textarea>
                    </div>
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

<script>
    // Mengambil elemen input dengan ID harga_perolehan
    const hargaPerolehanInput = document.getElementById('harga_perolehan');
    const luasInput = document.getElementById('luas');

    // Menambahkan event listener untuk event "input harga_perolehan"
    hargaPerolehanInput.addEventListener('input', function() {
        if (hargaPerolehanInput.value < 0) {
            hargaPerolehanInput.setCustomValidity('Harga Perolehan tidak boleh bernilai negatif');
        } else {
            hargaPerolehanInput.setCustomValidity('');
        }
    });

    // Menambahkan event listener untuk event "luas"
    luasInput.addEventListener('input', function() {
        if (luasInput.value < 0) {
            luasInput.setCustomValidity('Luas tidak boleh bernilai negatif');
        } else {
            luasInput.setCustomValidity('');
        }
    });
</script>
@endsection