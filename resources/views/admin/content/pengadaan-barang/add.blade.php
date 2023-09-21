@extends('admin.layout.main')
@section('admin.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengadaan Aset Barang</h1>
    <a href="{{ route('admin.pengadaan_barang.index') }}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form action="{{ route('admin.pengadaan_barang.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label for="kode_pengadaan_barang">Kode Pengadaan Barang<span style="color: red">*</span></label>
                        <input type="text" name="kode_pengadaan_barang" value="{{ old('kode_pengadaan_barang', $nextKodePengadaanBarang) }}" class="form-control" id="kode_pengadaan_barang" readonly required>
                    </div>
                    @error('kode_pengadaan_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group">
                        <label for="tanggal_pengadaan">Tanggal Pengadaan <span style="color: red">*</span></label>
                        <input type="date" max="{{ date('Y-m-d') }}" name="tanggal_pengadaan" value="{{ old('tanggal_pengadaan') }}" class="form-control @error('tanggal_pengadaan') is-invalid @enderror" id="tanggal_pengadaan" required>
                    </div>
                    @error('tanggal_pengadaan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group">
                        <label>Sumber <span style="color: red">*</span></label>
                        <div class="form-inline @error('sumber') is-invalid @enderror">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="sumber_pembelian" name="sumber" class="custom-control-input" value="pembelian" {{ old('sumber') == 'pembelian' ? 'checked' : '' }} required>
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

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ old('keterangan') }}</textarea>
                    </div>
                    @error('keterangan')
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
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <div class="d-flex flex-row align-items-center justify-content-between">
                            <label for="id_barang">Barang <span style="color: red">*</span></label>
                            <a href="{{ route('superadmin.pengadaan_barang.add_barang') }}">Belum ada barang?</a>
                        </div>
                        <select name="id_barang" id="id_barang" class="form-control @error('id_barang') is-invalid @enderror">
                            <option disabled selected>- Pilih Barang -</option>
                            @foreach($barang as $row)
                            <option value="{{ $row->id_barang }}" data-nama-barang="{{ $row->nama_barang }}">{{ $row->nama_barang }}</option>
                            @endforeach
                        </select>
                        @error('id_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_item_barang">Nama Item Barang <span style="color: red">*</span></label>
                        <input type="text" name="nama_item_barang" value="{{ old('nama_item_barang') }}" class="form-control @error('nama_item_barang') is-invalid @enderror" id="nama_item_barang">
                        @error('nama_item_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="merk">Merk</label>
                        <input type="text" name="merk" value="{{ old('merk') }}" class="form-control @error('merk') is-invalid @enderror" id="merk">
                        @error('merk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_perolehan">Harga Perolehan (Rp.) <span style="color: red">*</span></label>
                                <input type="text" name="harga_perolehan" value="{{ old('harga_perolehan') }}" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" onkeyup="formatRupiah(this)">
                                @error('harga_perolehan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur_manfaat">Umur Manfaat (Tahun) <span style="color: red">*</span></label>
                                <input type="number" name="umur_manfaat" value="{{ old('umur_manfaat') }}" class="form-control @error('umur_manfaat') is-invalid @enderror" id="umur_manfaat">
                                @error('umur_manfaat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nilai_residu">Nilai Residu (Rp.) <span style="color: red">*</span></label>
                                <input type="text" name="nilai_residu" value="{{ old('nilai_residu') }}" class="form-control @error('nilai_residu') is-invalid @enderror" id="nilai_residu" onkeyup="formatRupiah(this)">
                                @error('nilai_residu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah">Jumlah <span style="color: red">*</span></label>
                                <input type="number" name="jumlah" class="form-control" id="jumlah" value="{{ old('jumlah') }}" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="addToCart" class="btn btn-primary" type="button" onclick="tambahItem()" disabled>Tambah Item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-3" id="pengadaanTable">
                    <h5>Keranjang Pengadaan Barang</h5>
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Nama Item Barang</th>
                            <th>Merk</th>
                            <th>Harga Perolehan (Rp)</th>
                            <th>Umur Manfaat (Tahun)</th>
                            <th>Nilai Residu (Rp)</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="keranjang-pengadaan">
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Simpan Pengadaan</button>
            </div>
        </div>
    </div>
</form>

<script>
    const addToCartButton = document.getElementById('addToCart');
    const idItemBarangSelect = document.getElementById('id_barang');
    const keranjangPengadaan = document.getElementById('keranjang-pengadaan');

    // Memeriksa validitas form dan mengaktifkan/menonaktifkan tombol "AddToCart"
    function checkFormValidity() {
        const id_barang = idItemBarangSelect.value;
        const nama_item_barang = document.getElementById('nama_item_barang').value;
        const merk = document.getElementById('merk').value;
        const harga_perolehan = document.getElementById('harga_perolehan').value;
        const umur_manfaat = document.getElementById('umur_manfaat').value;
        const nilai_residu = document.getElementById('nilai_residu').value;
        const jumlah = document.getElementById('jumlah').value;

        const isFormValid = id_barang && nama_item_barang && harga_perolehan && umur_manfaat && nilai_residu && jumlah;

        addToCartButton.disabled = !isFormValid;
    }

    // Menambahkan item ke keranjang pengadaan
    function tambahItem() {
        const id_barang = idItemBarangSelect.value;
        const nama_barang = idItemBarangSelect.options[idItemBarangSelect.selectedIndex].getAttribute('data-nama-barang');
        const nama_item_barang = document.getElementById('nama_item_barang').value;
        const merk = document.getElementById('merk').value;
        const harga_perolehan = document.getElementById('harga_perolehan').value;
        const umur_manfaat = document.getElementById('umur_manfaat').value;
        const nilai_residu = document.getElementById('nilai_residu').value;
        const jumlah = document.getElementById('jumlah').value;

        const hargaPerolehan = parseFloat($('#harga_perolehan').val().replace(/\./g, ''));
        const nilaiResidu = parseFloat($('#nilai_residu').val().replace(/\./g, ''));

        // Periksa validitas input
        if (hargaPerolehan <= 0) {
            alert('Harga perolehan harus lebih besar dari 0.');
            return;
        }

        if (nilaiResidu >= hargaPerolehan) {
            alert('Nilai residu harus lebih kecil dari harga perolehan.');
            return;
        }

        if (umur_manfaat <= 0) {
            alert('Umur manfaat harus lebih besar dari 0.');
            return;
        }

        if (jumlah <= 0) {
            alert('Jumlah harus lebih besar dari 0.');
            return;
        }

        const existingItem = Array.from(keranjangPengadaan.getElementsByTagName('tr')).find(row => {
            const namaItemBarang = row.querySelector('.item-nama-item-barang').textContent;
            return namaItemBarang === nama_item_barang;
        });

        if (existingItem) {
            const existingJumlah = existingItem.querySelector('.item-jumlah');
            existingJumlah.textContent = parseInt(existingJumlah.textContent) + parseInt(jumlah);
            clearFormInputs();
            checkFormValidity();
            return;
        }

        const row = document.createElement('tr');
        row.innerHTML = `
        <td>${keranjangPengadaan.children.length + 1}</td>
        <td>${nama_barang}</td>
        <td class="item-nama-item-barang">${nama_item_barang}</td>
        <td>${merk}</td>
        <td>${harga_perolehan}</td>
        <td>${umur_manfaat}</td>
        <td>${nilai_residu}</td>
        <td><span class="item-jumlah">${jumlah}</span></td>
        <td>
            <button class="btn btn-sm btn-outline-primary add-jumlah" onclick="tambahJumlah(this)"><i class="fa fa-plus"></i></button>
            <button class="btn btn-sm btn-outline-primary minus-jumlah" onclick="kurangJumlah(this)"><i class="fa fa-minus"></i></button>
            <button class="btn btn-outline-danger btn-sm" onclick="hapusItem(this)"><i class="fa fa-trash"></i></button>
        </td>
    `;

        // Tambahkan input tersembunyi untuk setiap kolom
        row.innerHTML += `
        <input type="hidden" name="id_barang[]" value="${id_barang}">
        <input type="hidden" name="nama_item_barang[]" value="${nama_item_barang}">
        <input type="hidden" name="merk[]" value="${merk}">
        <input type="hidden" name="harga_perolehan[]" value="${harga_perolehan}">
        <input type="hidden" name="umur_manfaat[]" value="${umur_manfaat}">
        <input type="hidden" name="nilai_residu[]" value="${nilai_residu}">
        <input type="hidden" name="jumlah[]" value="${jumlah}">
    `;

        keranjangPengadaan.appendChild(row);
        clearFormInputs();
        checkFormValidity();
    }

    // Menambahkan jumlah item
    function tambahJumlah(button) {
        event.preventDefault(); // Mencegah aksi submit
        const row = button.parentNode.parentNode;
        const jumlahElement = row.querySelector('.item-jumlah');
        const jumlah = parseInt(jumlahElement.textContent) + 1;
        jumlahElement.textContent = jumlah;
    }

    // Mengurangi jumlah item
    function kurangJumlah(button) {
        event.preventDefault(); // Mencegah aksi submit
        const row = button.parentNode.parentNode;
        const jumlahElement = row.querySelector('.item-jumlah');
        let jumlah = parseInt(jumlahElement.textContent) - 1;
        jumlah = Math.max(jumlah, 1);
        jumlahElement.textContent = jumlah;
    }



    // Menghapus item dari keranjang pengadaan
    function hapusItem(button) {
        const row = button.parentNode.parentNode;
        row.remove();
        updateRowNumbers();
        checkFormValidity();
    }

    // Mengupdate nomor urutan setelah menghapus item
    function updateRowNumbers() {
        const rows = keranjangPengadaan.getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            row.cells[0].textContent = i;
        }
    }

    // Membersihkan nilai input form setelah menambah item
    function clearFormInputs() {
        idItemBarangSelect.selectedIndex = 0;
        document.getElementById('nama_item_barang').value = '';
        document.getElementById('merk').value = '';
        document.getElementById('harga_perolehan').value = '';
        document.getElementById('umur_manfaat').value = '';
        document.getElementById('nilai_residu').value = '';
        document.getElementById('jumlah').value = '';
    }

    // Memanggil fungsi checkFormValidity saat nilai input berubah
    idItemBarangSelect.addEventListener('change', checkFormValidity);
    document.getElementById('nama_item_barang').addEventListener('input', checkFormValidity);
    document.getElementById('merk').addEventListener('input', checkFormValidity);
    document.getElementById('harga_perolehan').addEventListener('input', checkFormValidity);
    document.getElementById('umur_manfaat').addEventListener('input', checkFormValidity);
    document.getElementById('nilai_residu').addEventListener('input', checkFormValidity);
    document.getElementById('jumlah').addEventListener('input', checkFormValidity);

    const simpanPengadaanButton = document.querySelector('button[type="submit"]');
    simpanPengadaanButton.addEventListener('click', function(event) {
        const pengadaanTable = document.getElementById('pengadaanTable');
        if (pengadaanTable.rows.length <= 1) {
            event.preventDefault();
            alert('Keranjang Pengadaan Kosong');
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