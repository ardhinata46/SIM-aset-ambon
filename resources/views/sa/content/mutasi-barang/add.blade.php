@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Mutasi Barang </h1>
    <a href="{{route('superadmin.mutasi_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form action="{{ route('superadmin.mutasi_barang.store') }}" method="POST">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
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
    <div class="card">
        <div class="card-body mb-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_item_barang">Item Barang<span style="color: red">*</span> </label>
                        <select name="id_item_barang" id="id_item_barang" class="form-control" required>
                            <option value="" disabled selected>- Pilih Item Barang -</option>
                            @foreach ($itemBarang as $row)
                            <option value="{{ $row->id_item_barang }}" data-namaRuangan="{{ $row->nama_ruangan }}" data-idRuangan="{{ $row->id_ruangan }}">{{ $row->kode_item_barang }} - {{ $row->nama_item_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ruangan_awal">Ruangan Awal<span style="color: red">*</span></label>
                        <input type="text" class="form-control @error('ruangan_awal') is-invalid @enderror" id="ruangan_awal" readonly>
                        <input type="hidden" name="id_ruangan_awal" id="idRuangan">
                        @error('ruangan_awal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ruangan_tujuan">Ruangan Tujuan<span style="color: red">*</span></label>
                        <select id="ruangan_tujuan" name="id_ruangan_tujuan" class="form-control" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->kode_ruangan }} {{ $ruangan->nama_ruangan }} </option>
                            @endforeach
                        </select>
                        @error('ruangan_tujuan')
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
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

<script>
    // Fungsi untuk mengisi data namaRuangan saat pilihan select berubah
    function handleSelectChange() {
        const select = document.getElementById('id_item_barang');
        const selectedOption = select.options[select.selectedIndex];
        const namaRuangan = selectedOption.getAttribute('data-namaRuangan');
        const idRuangan = selectedOption.getAttribute('data-idRuangan');

        // Masukkan data namaRuangan ke dalam input
        document.getElementById('ruangan_awal').value = namaRuangan;
        // Masukkan ID ruangan ke dalam input tersembunyi
        document.getElementById('idRuangan').value = idRuangan;
    }

    // Tambahkan event listener pada select dengan id "id_item_barang"
    document.getElementById('id_item_barang').addEventListener('change', handleSelectChange);

    document.querySelector('form').addEventListener('submit', function(event) {
        const ruanganAwalId = document.getElementById('idRuangan').value;
        const ruanganTujuanId = document.getElementById('ruangan_tujuan').value;

        if (ruanganAwalId === ruanganTujuanId) {
            alert('Ruangan awal dan ruangan tujuan tidak boleh sama.');
            event.preventDefault(); 
        }
    });
</script>


@endsection