@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengadaan Aset Bangunan</h1>
    <a href="{{route('superadmin.pengadaan_bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<form method="POST" action="{{ route('superadmin.pengadaan_bangunan.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_pengadaan_bangunan">Kode Pengadaan Bangunan</label>
                        <input type="text" name="kode_pengadaan_bangunan" value="{{ old('kode_pengadaan_bangunan', $nextKodePengadaanBangunan) }}" class="form-control" id="kode_pengadaan_bangunan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pengadaan">Tanggal Pengadaan <span style="color: red">*</span></label>
                        <input type="date" name="tanggal_pengadaan" max="{{ date('Y-m-d') }}" value="{{ old('tanggal_pengadaan') }}" class="form-control @error('tanggal_pengadaan') is-invalid @enderror" id="tanggal_pengadaan" required>
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
                                <input type="radio" id="sumber_pembangunan" name="sumber" class="custom-control-input" value="pembangunan" {{ old('sumber') == 'pembangunan' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="sumber_pembangunan">Pembangunan</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="sumber_pembelian" name="sumber" class="custom-control-input" value="pembelian" {{ old('sumber') == 'pembelian' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_pembelian">Pembelian</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="sumber_hibah" name="sumber" class="custom-control-input" value="hibah" {{ old('sumber') == 'hibah' ? 'checked' : '' }}>
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
                        <label for="kode_bangunan">Kode Bangunan</label>
                        <input type="text" name="kode_bangunan" value="{{ old('kode_bangunan', $nextKodeBangunan) }}" class="form-control" id="kode_bangunan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_tanah">Tanah Lokasi Bangunan<span style="color: red">*</span> </label>
                        <select name="id_tanah" id="id_tanah" class="form-control" required>
                            <option value="" disabled selected>- Pilih Tanah Lokasi Bangunan -</option>
                            @foreach ($tanah as $row)
                            <option value="{{ $row->id_tanah }}" data-lokasi="{{ $row->lokasi }}">{{ $row->kode_tanah }} - {{ $row->nama_tanah }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi Bangunan<span style="color: red">*</span></label>
                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" readonly>
                        @error('lokasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ old('keterangan') }}</textarea>
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
                        <input type="text" name="nama_bangunan" value="{{ old('nama_bangunan') }}" class="form-control @error('nama_bangunan') is-invalid @enderror" id="nama_bangunan" required>
                    </div>
                    @error('nama_bangunan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Bangunan <span style="color: red">*</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_perolehan">Harga Perolehan (Rp.) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="harga_perolehan" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" required>
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
                        <input type="number" name="umur_manfaat" value="{{ old('umur_manfaat') }}" class="form-control @error('umur_manfaat') is-invalid @enderror" id="umur_manfaat" required>
                    </div>
                    @error('umur_manfaat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="nilai_residu">Nilai Residu (Rp.) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="nilai_residu" value="{{ old('nilai_residu') }}" class="form-control @error('nilai_residu') is-invalid @enderror" id="nilai_residu" required>
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
                                <input type="radio" id="kondisi_baik" name="kondisi" class="custom-control-input" value="baik" {{ old('kondisi') == 'baik' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="kondisi_baik">Baik</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="rusak_ringan" name="kondisi" class="custom-control-input" value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rusak_berat" name="kondisi" class="custom-control-input" value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'checked' : '' }}>
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
    // Fungsi untuk mengisi data lokasi saat pilihan select berubah
    function handleSelectChange() {
        const select = document.getElementById('id_tanah');
        const selectedId = select.value;

        if (selectedId !== '') {
            // Ambil data lokasi dari atribut data-lokasi pada opsi yang dipilih
            const selectedOption = select.options[select.selectedIndex];
            const lokasi = selectedOption.getAttribute('data-lokasi');

            // Masukkan data lokasi ke dalam input
            document.getElementById('lokasi').value = lokasi;
        } else {
            // Reset/kosongkan input lokasi
            document.getElementById('lokasi').value = '';
        }
    }

    // Tambahkan event listener pada select dengan id "id_tanah"
    document.getElementById('id_tanah').addEventListener('change', handleSelectChange);
</script>

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