@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Ubah Perawatan Bangunan</h1>
    <a href="{{route('superadmin.perawatan_bangunan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>
<form method="POST" action="{{route ('superadmin.perawatan_bangunan.update', $perawatanBangunan->id_perawatan_bangunan)}}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="created_by" value="{{ $perawatanBangunan->created_by }}">
                    <div class=" form-group">
                        <label for="kode_perawatan_bangunan">Kode Perawatan Bangunan <span style="color: red">*</span></label>
                        <input type="text" name="kode_perawatan_bangunan" value="{{ $perawatanBangunan->kode_perawatan_bangunan }}" class="form-control" id="kode_perawatan_bangunan" readonly>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="id_bangunan">Bangunan <span style="color: red">*</span></label>
                            <select name="id_bangunan" id="id_bangunan" class="form-control" required>
                                <option disabled>- Pilih Bangunan -</option>
                                @foreach($bangunan as $row)
                                <option value="{{ $row->id_bangunan }}" {{ ($perawatanBangunan->id_bangunan == $row->id_bangunan) ? 'selected' : '' }}>
                                    {{ $row->kode_bangunan }}
                                    {{ $row->nama_bangunan }}
                                    @if($row->kondisi == 'baik')
                                    Baik</span>
                                    @elseif($row->kondisi == 'rusak_ringan')
                                    Rusak Ringan
                                    @elseif($row->kondisi == 'rusak_berat')
                                    Rusak Berat
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('id_bangunan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_perawatan">Tanggal Perawatan <span style="color: red">*</span></label>
                        <input type="date" name="tanggal_perawatan" max="{{ date('Y-m-d') }}" value="{{ $perawatanBangunan->tanggal_perawatan }}" class="form-control @error('tanggal_perawatan') is-invalid @enderror" id="tanggal_perawatan" required>
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
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" required>{{$perawatanBangunan->deskripsi }}</textarea>
                    </div>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="biaya">Total Biaya Perawatan (Rp.) <span style="color: red">*</span></label>
                        <input type="text" onkeyup="formatRupiah(this)" name="biaya" value="{{ number_format($perawatanBangunan->biaya, 0, ',', '.') }}" class="form-control  @error('biaya') is-invalid @enderror" id="biaya">
                    </div>
                    @error('biaya')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ $perawatanBangunan->keterangan }}</textarea>
                    </div>
                    @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Kondisi Setelah Perawatan <span style="color: red">*</span></label>
                        <div class="form-inline @error('kondisi_sesudah') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="kondisi_baik" name="kondisi_sesudah" class="custom-control-input" value="baik" {{ $perawatanBangunan->kondisi_sesudah === 'baik' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="kondisi_baik">Baik</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="rusak_ringan" name="kondisi_sesudah" class="custom-control-input" value="rusak_ringan" {{ $perawatanBangunan->kondisi_sesudah === 'rusak_ringan' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rusak_berat" name="kondisi_sesudah" class="custom-control-input" value="rusak_berat" {{ $perawatanBangunan->kondisi_sesudah === 'rusak_berat' ? 'checked' : '' }}>
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
        if (biayaInput.value < 0) {
            biayaInput.setCustomValidity('Biaya tidak boleh bernilai negatif');
        } else {
            biayaInput.setCustomValidity('');
        }
    });
</script>

@endsection