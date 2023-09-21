@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Penghapusan Aset Bangunan</h1>
    <a href="{{route('superadmin.penghapusan_bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('superadmin.penghapusan_bangunan.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">

                    <label for="kode_penghapusan_bangunan">Kode Penghapusan Tanah <span style="color: red">*</span></label>
                    <input type="text" name="kode_penghapusan_bangunan" value="{{ old('kode_penghapusan_bangunan', $nextKodePenghapusanBangunan) }}" class="form-control" id="kode_penghapusan_bangunan" readonly>
                </div>
                <div class="col-md-6">
                    <label for="tanggal">Tanggal Penghapusan <span style="color: red">*</span></label>
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
                        <label for="id_bangunan">Bangunan <span style="color: red">*</span></label>
                        <select name="id_bangunan" id="id_bangunan" class="form-control  @error('id_bangunan') is-invalid @enderror" required>
                            <option disabled selected>
                                - Pilih Bangunan -
                            </option>
                            @foreach($bangunan as $row)
                            <option value=" {{$row->id_bangunan}}">{{$row->kode_bangunan}}| {{$row->nama_bangunan}} |
                                @if($row->kondisi == 'baik')
                                Baik
                                @elseif($row->kondisi == 'rusak_ringan')
                                Rusak Ringan
                                @elseif($row->kondisi == 'rusak_berat')
                                Rusak Berat
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('id_bangunan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tindakan">Tindakan Penghapusan <span style="color: red">*</span></label>
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
                </div>

                <div class="col-md-6">
                    <div id="harga-input" style="display: none;">
                        <label for="harga">Harga Penjualan<span style="color: red">*</span></label>
                        <input type="number " min="0" name="harga" id="harga" class="form-control">
                    </div>

                    <div class="form-group">
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
        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value=" Simpan">
        </div>
    </div>
</form>

<script>
    const tindakanRadios = document.querySelectorAll('input[name="tindakan"]');
    const hargaInput = document.getElementById('harga-input');

    function toggleHargaInput() {
        if (this.checked && this.value === 'jual') {
            hargaInput.style.display = 'block';
        } else {
            hargaInput.style.display = 'none';
        }
    }

    tindakanRadios.forEach(radio => {
        radio.addEventListener('change', toggleHargaInput);
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        const tindakan = document.querySelector('input[name="tindakan"]:checked');
        const harga = document.getElementById('harga');

        if (tindakan.value === 'jual' && harga.value.trim() === '') {
            event.preventDefault();
            alert('Harga harus diisi sebelum menyimpan!');
        }
    });

    window.addEventListener('DOMContentLoaded', function() {
        toggleHargaInput();

        const tindakan = document.querySelector('input[name="tindakan"]:checked');

        if (tindakan.value === 'jual') {
            hargaInput.style.display = 'block';
        }
    });
</script>

<script>
    const harga = document.getElementById('harga');

    // Menambahkan event listener untuk event "input harga_perolehan"
    harga.addEventListener('input', function() {
        if (harga.value < 0) {
            harga.setCustomValidity('Harga Perolehan tidak boleh bernilai negatif');
        } else {
            harga.setCustomValidity('');
        }
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