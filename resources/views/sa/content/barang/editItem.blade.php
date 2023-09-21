@extends ('sa.layout.main')
@section ('sa.content')

<div class="d-sm-flex  mb-4 align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Item Barang</h1>
    <a href="{{route('superadmin.barang.detail', ['id_barang' => $id_barang])}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<form method="POST" action="{{ route('superadmin.barang.update_item_barang', $itemBarang->id_item_barang) }}">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="created_by" value="{{ $itemBarang->created_by}}">
                    <div class=" form-group">
                        <label for="kode_item_barang">Kode Barang</label>
                        <input type="text" name="kode_item_barang" value="{{ $itemBarang->kode_item_barang}}" class="form-control" id="kode_item_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_barang"> Barang<span style="color: red">*</span></label>
                        <select name="id_barang" id="id_barang" class="form-control" required>
                            <option disabled>- Pilih Barang -</option>
                            @foreach($barang as $row)
                            <option value="{{ $row->id_barang }}" {{ ($itemBarang->id_barang == $row->id_barang) ? 'selected' : '' }}>
                                {{$row->kode_barang}} {{$row->nama_barang}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sumber<span style="color: red">*</span></label>
                        <div class="form-inline @error('sumber') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="sumber_pembelian" name="sumber" class="custom-control-input" value="pembelian" {{ $itemBarang->sumber === 'pembelian' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sumber_pembelian">Pembelian</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="sumber_hibah" name="sumber" class="custom-control-input" value="hibah" {{ $itemBarang->sumber === 'hibah' ? 'checked' : '' }}>
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
                    <div class="form-group">
                        <label for="tanggal_pengadaan">Tanggal Pengadaan<span style="color: red">*</span></label>
                        <input type="date" name="tanggal_pengadaan" max="{{ date('Y-m-d') }}" value="{{ $itemBarang->tanggal_pengadaan }}" class="form-control @error('tanggal_pengadaan') is-invalid @enderror" id="tanggal_pengadaan" required>
                        @error('tanggal_pengadaan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ $itemBarang->keterangan }}</textarea>
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
                        <label for="nama_item_barang">Nama Item Barang<span style="color: red">*</span></label>
                        <input type="text" name="nama_item_barang" value="{{ $itemBarang->nama_item_barang }}" class="form-control  @error('nama_item_barang') is-invalid @enderror" id="nama_item_barang" required>
                        @error('nama_item_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="merk">Merk/Type</label>
                        <input type="text" name="merk" value="{{ $itemBarang->merk }}" class="form-control  @error('merk') is-invalid @enderror" id="merk">
                        @error('merk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_perolehan">Harga Perolehan (Rp.)<span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="harga_perolehan" value="{{ number_format($itemBarang->harga_perolehan, 0, ',', '.') }}" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" required>
                        @error('harga_perolehan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="umur_manfaat">Umur Manfaat (Tahun)<span style="color: red">*</span></label>

                        <input type="number" name="umur_manfaat" value="{{ $itemBarang->umur_manfaat }}" class="form-control @error('umur_manfaat') is-invalid @enderror" id="umur_manfaat" required>
                        @error('umur_manfaat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="nilai_residu">Nilai Residu (Rp.)<span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="nilai_residu" value="{{ number_format($itemBarang->nilai_residu, 0, ',', '.') }}" class="form-control @error('nilai_residu') is-invalid @enderror" id="nilai_residu" required>
                        @error('nilai_residu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kondisi<span style="color: red">*</span></label>
                        <div class="form-inline @error('kondisi') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="kondisi_baik" name="kondisi" class="custom-control-input" value="baik" {{ $itemBarang->kondisi === 'baik' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="kondisi_baik">Baik</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="rusak_ringan" name="kondisi" class="custom-control-input" value="rusak_ringan" {{ $itemBarang->kondisi === 'rusak_ringan' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rusak_berat" name="kondisi" class="custom-control-input" value="rusak_berat" {{ $itemBarang->kondisi === 'rusak_berat' ? 'checked' : '' }}>
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