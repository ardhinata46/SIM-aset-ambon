@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah {{ $bangunan->nama_bangunan }}</h1>
    <a href="{{route('superadmin.bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<form method="POST" action="{{route ('superadmin.bangunan.update', $bangunan->id_bangunan)}}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="created_by" value="{{ $bangunan->created_by }}">
                    <div class="form-group">
                        <label for="kode_bangunan">Kode Bangunan <span style="color: red">*</span></label>
                        <input type="text" name="kode_bangunan" value="{{ $bangunan->kode_bangunan }}" class="form-control @error('kode_bangunan') is-invalid @enderror" id="kode_bangunan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi Bangunan<span style="color: red">*</span></label>
                        <input type="text" name="lokasi" value="{{ $bangunan->lokasi }}" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" required>
                        @error('lokasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sumber Aset<span style="color: red">*</span></label>
                        <div class="form-inline @error('sumber') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input class="custom-control-input" type="radio" name="sumber" id="pembangunan" value="pembangunan" {{ $bangunan->sumber === 'pembangunan' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="pembangunan">Pembangunan</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input class="custom-control-input" type="radio" name="sumber" id="pembelian" value="pembelian" {{ $bangunan->sumber === 'pembelian' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="pembelian">Pembelian</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input class="custom-control-input" type="radio" name="sumber" id="hibah" value="hibah" {{ $bangunan->sumber === 'hibah' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="hibah">Hibah</label>
                            </div>
                        </div>
                        @error('sumber')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_pengadaan">Tanggal Pengadaan <span style="color: red">*</span> </label>
                        <input type="date" name="tanggal_pengadaan" max="{{ date('Y-m-d') }}" value="{{ $bangunan->tanggal_pengadaan }}" class="form-control @error('tanggal_pengadaan') is-invalid @enderror" id="tanggal_pengadaan" required>
                        @error('tanggal_pengadaan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ $bangunan->keterangan }}</textarea>
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
                        <input type="text" name="nama_bangunan" value="{{ $bangunan->nama_bangunan }}" class="form-control @error('nama_bangunan') is-invalid @enderror" id="nama_bangunan" required>
                        @error('nama_bangunan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Bangunan <span style="color: red">*</span></label>
                        <input type="text" name="deskripsi" value="{{ $bangunan->deskripsi }}" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" required>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="harga_perolehan">Harga Perolehan (Rp) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="harga_perolehan" value="{{ number_format($bangunan->harga_perolehan, 0, ',', '.') }}" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" required>
                        @error('harga_perolehan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="umur_manfaat">Umur Manfaat (Tahun) <span style="color: red">*</span></label>
                        <input type="number" name="umur_manfaat" value="{{ $bangunan->umur_manfaat }}" class="form-control @error('umur_manfaat') is-invalid @enderror" id="umur_manfaat" required>
                        @error('umur_manfaat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nilai_residu">Nilai Residu (Rp.) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="nilai_residu" value="{{ number_format($bangunan->nilai_residu, 0, ',', '.') }}" class="form-control @error('nilai_residu') is-invalid @enderror" id="nilai_residu" required>
                        @error('nilai_residu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kondisi <span style="color: red">*</span></label>
                        <div class="form-inline @error('kondisi') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input class="custom-control-input" type="radio" name="kondisi" id="baik" value="baik" {{ $bangunan->kondisi === 'baik' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="baik">Baik</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input class="custom-control-input" type="radio" name="kondisi" id="rusak_ringan" value="rusak_ringan" {{ $bangunan->kondisi === 'rusak_ringan' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="kondisi" id="rusak_berat" value="rusak_berat" {{ $bangunan->kondisi === 'rusak_berat' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="rusak_berat">Rusak Berat</label>
                            </div>
                        </div>
                        @error('kondisi')
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
    </div>
</form>

<script>
    $(document).ready(function() {
        // Format input menjadi rupiah saat pengguna mengetik
        // Hapus karakter selain angka saat pengguna mengetik
        $('#harga_perolehan').on('input', function(e) {
            let hargaPerolehan = $(this).val();

            // Hapus karakter selain angka
            hargaPerolehan = hargaPerolehan.replace(/[^\d]/g, '');

            // Format menjadi rupiah
            let formattedHarga = formatRupiah(hargaPerolehan);

            // Set nilai kembali ke input
            $(this).val(formattedHarga);
        });

        // Validasi harga perolehan, umur manfaat, dan nilai residu saat tombol submit ditekan
        $('form').on('submit', function(e) {
            var hargaPerolehan = parseFloat($('#harga_perolehan').val().replace(/\./g, ''));
            var umurManfaat = parseInt($('#umur_manfaat').val());
            var nilaiResidu = parseFloat($('#nilai_residu').val().replace(/\./g, ''));

            // Validasi harga perolehan, umur manfaat, dan nilai residu
            if (hargaPerolehan <= 0) {
                alert("Harga perolehan harus lebih besar dari 0");
                e.preventDefault(); // Mencegah pengiriman form jika validasi gagal
            }
            if (umurManfaat <= 0) {
                alert("Umur manfaat harus lebih besar dari 0");
                e.preventDefault(); // Mencegah pengiriman form jika validasi gagal
            }
            if (nilaiResidu <= 0) {
                alert("Nilai residu harus lebih besar dari 0");
                e.preventDefault(); // Mencegah pengiriman form jika validasi gagal
            }
            if (nilaiResidu >= hargaPerolehan) {
                alert("Nilai residu tidak boleh lebih besar atau sama dengan dari harga perolehan");
                e.preventDefault(); // Mencegah pengiriman form jika validasi gagal
            }
        });
    });

    // Fungsi untuk mengubah angka menjadi format rupiah
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
</script>
@endsection