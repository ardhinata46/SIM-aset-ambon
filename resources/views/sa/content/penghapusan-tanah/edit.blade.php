@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Penghapusan Aset Tanah</h1>
    <a href="{{route('superadmin.penghapusan_tanah.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('superadmin.penghapusan_tanah.update', $penghapusanTanah->id_penghapusan_tanah )}}">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">

                    <label for="kode_penghapusan_tanah">Kode Penghapusan Tanah</label>
                    <input type="text" name="kode_penghapusan_tanah" value="{{  $penghapusanTanah->kode_penghapusan_tanah }}" class="form-control" id="kode_penghapusan_tanah" readonly>
                </div>
                <div class="col-md-6">
                    <label for="tanggal">Tanggal Penghapusan<span style="color: red">*</span></label>
                    <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{  $penghapusanTanah->tanggal }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required>
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
                        <label for="id_tanah">Tanah<span style="color: red">*</span></label>
                        <select name="id_tanah" id="id_tanah" class="form-control  @error('id_tanah') is-invalid @enderror" required>
                            <option disabled selected>
                                - Pilih Tanah -
                            </option>
                            @foreach($tanah as $row)
                            <option value=" {{$row->id_tanah}}" {{ $row->id_tanah == $penghapusanTanah->id_tanah ? 'selected' : '' }}>{{$row->kode_tanah}} {{$row->nama_tanah}}</option>
                            @endforeach
                        </select>
                        @error('id_tanah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tindakan">Tindakan Penghapusan</label>
                        <div>
                            <div class=" form-check form-check-inline @error('tindakan') is-invalid @enderror">
                                <input class="form-check-input" type="radio" name="tindakan" id="jual" value="jual" {{ $penghapusanTanah->tindakan === 'jual' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jual">Dijual</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tindakan" id="hibah" value="hibah" {{ $penghapusanTanah->tindakan === 'hibah' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hibah">Dihibahkan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tindakan" id="dihanguskan" value="dihanguskan" {{ $penghapusanTanah->tindakan === 'dihanguskan' ? 'checked' : '' }}>
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
                        <input type="number" min="0" name="harga" id="harga" value="{{$penghapusanTanah->harga}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" value="{{$penghapusanTanah->harga}}" id="keterangan">{{ $penghapusanTanah->keterangan }}</textarea>
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
</script>

@endsection