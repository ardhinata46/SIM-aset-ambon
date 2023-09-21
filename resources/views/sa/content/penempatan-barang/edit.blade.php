@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Penempatan Barang </h1>
    <a href="{{route('superadmin.penempatan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form action="{{ route('superadmin.penempatan_barang.update', $penempatanBarang->id_penempatan_barang) }}" method="POST">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_penempatan_barang">Kode Pengadaan Tanah<span style="color: red">*</span></label>
                        <input type="text" name="kode_penempatan_barang" value="{{ $penempatanBarang->kode_penempatan_barang }}" class="form-control" id="kode_penempatan_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_ruangan">Ruangan<span style="color: red">*</span></label>
                        <select id="id_ruangan" name="id_ruangan" class="form-control" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($ruangan as $row)
                            <option value="{{ $row->id_ruangan }}" {{ $row->id_ruangan == $penempatanBarang->id_ruangan ? 'selected' : '' }}>
                                {{ $row->kode_ruangan }} {{ $row->nama_ruangan }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_ruangan')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Penempatan<span style="color: red">*</span></label>
                        <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ $penempatanBarang->tanggal }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required>
                    </div>
                    @error('tanggal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3">{{ $penempatanBarang->keterangan }}</textarea>
                        @error('keterangan')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class=" btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

@endsection