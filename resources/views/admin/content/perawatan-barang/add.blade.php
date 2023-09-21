@extends ('admin.layout.main')
@section ('admin.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Perawatan Barang</h1>
    <a href="{{route('admin.perawatan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('admin.perawatan_barang.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_perawatan_barang">Kode Perawatan Barang </label>
                        <input type="text" name="kode_perawatan_barang" value="{{ old('kode_perawatan_barang', $nextKodePerawatanBarang) }}" class="form-control" id="kode_perawatan_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_item_barang">Item Barang</label>
                        <select name="id_item_barang" id="id_item_barang" class="form-control @error('id_item_barang') is-invalid @enderror" required>
                            <option disabled selected>- Pilih Item barang -</option>
                            @foreach($barang as $row)
                            <option value="{{$row->id_item_barang}}">
                                {{$row->kode_item_barang}} {{$row->nama_item_barang}}
                                (@if($row->kondisi == 'baik')
                                Baik
                                @elseif($row->kondisi == 'rusak_ringan')
                                Rusak Ringan
                                @elseif($row->kondisi == 'rusak_berat')
                                Rusak Berat
                                @endif)
                            </option>
                            @endforeach
                        </select>
                        @error('id_item_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_perawatan">Tanggal Perawatan <span style="color: red">*</span></label>
                        <input type="date" name="tanggal_perawatan" max="{{ date('Y-m-d') }}" value="{{ old('tanggal_perawatan') }}" class="form-control @error('tanggal_perawatan') is-invalid @enderror" id="tanggal_perawatan" required>
                    </div>
                    @error('tanggal_perawatan')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">


                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Perawatan <span style="color: red">*</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" required>{{ old('deskripsi') }}</textarea>
                    </div>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="biaya">Total Biaya Perawatan (Rp.)</label>
                        <input type="text" onkeyup="formatRupiah(this)" name="biaya" value="{{ old('biaya') }}" class="form-control  @error('biaya') is-invalid @enderror" id="biaya">
                    </div>
                    @error('biaya')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ old('keterangan') }}</textarea>
                    </div>
                    @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Kondisi Setelah Perawatan <span style="color: red">*</span></label>
                        <div class="form-inline @error('kondisi_sesudah') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="kondisi_baik" name="kondisi_sesudah" class="custom-control-input" value="baik" {{ old('kondisi_sesudah') == 'baik' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="kondisi_baik">Baik</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="rusak_ringan" name="kondisi_sesudah" class="custom-control-input" value="rusak_ringan" {{ old('kondisi_sesudah') == 'rusak_ringan' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rusak_berat" name="kondisi_sesudah" class="custom-control-input" value="rusak_berat" {{ old('kondisi_sesudah') == 'rusak_berat' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_berat">Rusak Berat</label>
                            </div>
                        </div>
                        @error('kondisi_sesudah')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
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
    const biayaInput = document.getElementById('biaya');
    // Menambahkan event listener untuk event "biaya"
    biayaInput.addEventListener('input', function() {
        const biaya = parseFloat(biayaInput.value.replace(/\./g, ''));
        if (biaya < 0) {
            biayaInput.setCustomValidity('Biaya tidak boleh bernilai negatif');
        } else {
            biayaInput.setCustomValidity('');
        }
    });
</script>

@endsection