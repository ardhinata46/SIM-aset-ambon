@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Data Perawatan Barang</h1>
    <a href="{{route('superadmin.perawatan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('superadmin.perawatan_barang.update', $perawatanBarang->id_perawatan_barang)}}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="created_by" value="{{ $perawatanBarang->created_by}}">
                    <div class="form-group">
                        <label for="kode_perawatan_barang">Kode Perawatan Barang <span style="color: red">*</span></label>
                        <input type="text" name="kode_perawatan_barang" value="{{ $perawatanBarang->kode_perawatan_barang }}" class="form-control" id="kode_perawatan_barang" readonly>
                    </div>

                    <div class="form-group">
                        <label for="id_item_barang">Barang</label>
                        <select name="id_item_barang" id="id_item_barang" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($barang as $row)
                            <option value="{{ $row->id_item_barang }}" {{ $row->id_item_barang == $perawatanBarang->id_item_barang ? 'selected' : '' }}>
                                {{ $row->kode_item_barang }} {{ $row->nama_item_barang }}
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
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_perawatan">Tanggal Perawatan <span style="color: red">*</span></label>
                        <input type="date" name="tanggal_perawatan" max="{{ date('Y-m-d') }}" value="{{ $perawatanBarang->tanggal_perawatan }}" class="form-control @error('tanggal_perawatan') is-invalid @enderror" id="tanggal_perawatan" required>
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
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" required>{{ $perawatanBarang->deskripsi }}</textarea>
                    </div>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="biaya">Total Biaya Perawatan (Rp.)<span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="biaya" value="{{ number_format($perawatanBarang->biaya, 0, ',', '.')}}" class="form-control  @error('biaya') is-invalid @enderror" id="biaya">
                    </div>
                    @error('biaya')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ $perawatanBarang->keterangan }}</textarea>
                    </div>
                    @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Kondisi Setelah Perawatan <span style="color: red">*</span></label>
                        <div class="form-inline @error('kondisi_sesudah') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="kondisi_baik" name="kondisi_sesudah" class="custom-control-input" value="baik" {{ $perawatanBarang->kondisi_sesudah == 'baik' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="kondisi_baik">Baik</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="rusak_ringan" name="kondisi_sesudah" class="custom-control-input" value="rusak_ringan" {{ $perawatanBarang->kondisi_sesudah == 'rusak_ringan' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rusak_berat" name="kondisi_sesudah" class="custom-control-input" value="rusak_berat" {{ $perawatanBarang->kondisi_sesudah == 'rusak_berat' ? 'checked' : '' }}>
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