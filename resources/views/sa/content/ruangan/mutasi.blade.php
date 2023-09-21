@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Mutasi Barang </h1>
    <a href="{{route('superadmin.ruangan.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form action="{{ route('superadmin.ruangan.storeMutasi', $itemBarang->id_item_barang) }}" method="POST">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_mutasi_barang">Kode Mutasi Barang</label>
                        <input type="text" name="kode_mutasi_barang" value="{{ old('kode_mutasi_barang', $nextKodeMutasiBarang) }}" class="form-control" id="kode_mutasi_barang" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Mutasi<span style="color: red">*</span></label>
                        <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required>
                    </div>
                    @error('tanggal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_item_barang">Barang</label>
                        <input type="text" class="form-control" value="{{ $itemBarang->kode_item_barang}} {{ $itemBarang->nama_item_barang}}" readonly>
                        <input type="hidden" name="id_item_barang" value="{{ $itemBarang->id_item_barang}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="id_item_barang">Ruangan Sebelumnya</label>
                        <input type="text" class="form-control" value="{{ $itemBarang->nama_ruangan}}" readonly>
                        <input type="hidden" name="id_ruangan_awal" value="{{ $itemBarang->id_ruangan}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_ruangan">Ruangan Tujuan<span style="color: red">*</span></label>
                        <select id="id_ruangan" name="id_ruangan_tujuan" class="form-control" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($ruangan as $ruangan)
                            <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->kode_ruangan }} {{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('id_ruangan')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3"></textarea>
                        @error('keterangan')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <button class="btn btn-primary" type="submit">Simpan Mutasi</button>
        </div>
    </div>
</form>

@endsection