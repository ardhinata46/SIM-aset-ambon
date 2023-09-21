@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Data Pengadaan Aset Tanah</h1>
    <a href="{{route('superadmin.pengadaan_bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{ route('superadmin.pengadaan_bangunan.update', $pengadaanBangunan->id_pengadaan_bangunan) }}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="created_by" value="{{ $pengadaanBangunan->created_by }}">
                    <div class="form-group">
                        <label for="kode_pengadaan_bangunan">Kode Pengadaan Bangunan <span style="color: red">*</span></label>
                        <input type="text" name="kode_pengadaan_bangunan" value="{{ $pengadaanBangunan->kode_pengadaan_bangunan }}" class="form-control" id="kode_pengadaan_bangunan" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pengadaan">Tanggal Pengadaan <span style="color: red">*</span></label>
                        <input type="date" name="tanggal_pengadaan" max="{{ date('Y-m-d') }}" value="{{ $pengadaanBangunan->tanggal_pengadaan }}" class="form-control @error('tanggal_pengadaan') is-invalid @enderror" id="tanggal_pengadaan" required>
                    </div>
                    @error('tanggal_pengadaan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="nota">Nota</label>
                        <input type="file" name="nota" class="form-control" id="nota" accept="image/*">
                        @error('nota')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Sumber Aset<span style="color: red">*</span></label>
                        <div class="form-inline @error('sumber') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="sumber_pembangunan" name="sumber" class="custom-control-input" value="pembangunan" {{ $pengadaanBangunan->sumber === 'pembangunan' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_pembangunan">Pembangunan</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="sumber_pembelian" name="sumber" class="custom-control-input" value="pembelian" {{ $pengadaanBangunan->sumber === 'pembelian' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_pembelian">Pembelian</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="sumber_hibah" name="sumber" class="custom-control-input" value="hibah" {{ $pengadaanBangunan->sumber === 'hibah' ? 'checked' : '' }}>
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
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="kode_bangunan">Kode Bangunan <span style="color: red">*</span></label>
                        <input type="text" name="kode_bangunan" value="{{ $pengadaanBangunan->kode_bangunan }}" class="form-control" id="kode_bangunan" readonly>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi Bangunan <span style="color: red">*</span></label>
                        <input type="text" name="lokasi" value="{{ $pengadaanBangunan->lokasi }}" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" required>
                    </div>
                    @error('lokasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ $pengadaanBangunan->keterangan}}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">
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
                        <label for="nama_bangunan">Nama Bangunan <span style="color: red">*</span></label>
                        <input type="text" name="nama_bangunan" value="{{ $pengadaanBangunan->nama_bangunan }}" class="form-control @error('nama_bangunan') is-invalid @enderror" id="nama_bangunan" required>
                    </div>
                    @error('nama_bangunan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror


                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Bangunan <span style="color: red">*</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" required>{{ $pengadaanBangunan->deskripsi }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="harga_perolehan">Harga Perolehan (Rp.) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="harga_perolehan" value="{{ number_format($pengadaanBangunan->harga_perolehan, 0, ',', '.') }}" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" required>
                    </div>
                    @error('harga_perolehan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror


                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="umur_manfaat">Umur Manfaat (Tahun) <span style="color: red">*</span></label>
                        <input type="number" name="umur_manfaat" value="{{ $pengadaanBangunan->umur_manfaat }}" class="form-control @error('umur_manfaat') is-invalid @enderror" id="umur_manfaat" required>
                    </div>
                    @error('umur_manfaat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="nilai_residu">Nilai Residu (Rp.) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="nilai_residu" value="{{ number_format($pengadaanBangunan->nilai_residu, 0, ',', '.') }}" class="form-control @error('nilai_residu') is-invalid @enderror" id="nilai_residu" required>
                    </div>
                    @error('nilai_residu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group">
                        <label>Kondisi <span style="color: red">*</span></label>
                        <div class="form-inline @error('kondisi') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="kondisi_baik" name="kondisi" class="custom-control-input" value="baik" {{ $pengadaanBangunan->kondisi === 'baik' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="kondisi_baik">Baik</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="rusak_ringan" name="kondisi" class="custom-control-input" value="rusak_ringan" {{ $pengadaanBangunan->kondisi === 'rusak_ringan' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rusak_berat" name="kondisi" class="custom-control-input" value="rusak_berat" {{ $pengadaanBangunan->kondisi === 'rusak_berat' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_berat">Rusak Berat</label>
                            </div>
                        </div>
                        @error('kondisi')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <input class="btn btn-primary" type="submit" value="Simpan">
        </div>
    </div>
</form>

<script>
    // Mengambil elemen input dengan ID harga_perolehan
    const hargaPerolehanInput = document.getElementById('harga_perolehan');
    const umurManfaatInput = document.getElementById('umur_manfaat');
    const nilaiResiduInput = document.getElementById('nilai_residu');

    // Menambahkan event listener untuk event "input harga_perolehan"
    hargaPerolehanInput.addEventListener('input', function() {
        if (hargaPerolehanInput.value < 0) {
            hargaPerolehanInput.setCustomValidity('Harga Perolehan tidak boleh bernilai negatif');
        } else {
            hargaPerolehanInput.setCustomValidity('');
        }
    });

    // Menambahkan event listener untuk event "umur_manfaat"
    umurManfaatInput.addEventListener('input', function() {
        if (umurManfaatInput.value < 0) {
            umurManfaatInput.setCustomValidity('Umur manfaat tidak boleh bernilai negatif');
        } else {
            umurManfaatInput.setCustomValidity('');
        }
    });

    // Menambahkan event listener untuk event "nilai_residu"
    nilaiResiduInput.addEventListener('input', function() {
        const hargaPerolehan = parseFloat(hargaPerolehanInput.value);
        const nilaiResidu = parseFloat(nilaiResiduInput.value);

        if (nilaiResidu < 0) {
            nilaiResiduInput.setCustomValidity('Nilai residu tidak boleh bernilai negatif');
        } else if (nilaiResidu > hargaPerolehan) {
            nilaiResiduInput.setCustomValidity('Nilai residu tidak boleh lebih besar dari harga perolehan');
        } else {
            nilaiResiduInput.setCustomValidity('');
        }
    });
</script>
@endsection