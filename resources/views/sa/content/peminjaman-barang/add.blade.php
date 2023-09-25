@extends('sa.layout.main')

@section('sa.content')
<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Peminjaman Barang</h1>
    <a href="{{route('superadmin.peminjaman_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form method="POST" action="{{route ('superadmin.peminjaman_barang.store')}}">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_peminjaman_barang">Kode Peminjaman Barang</label>
                        <input type="text" name="kode_peminjaman_barang" value="{{ old('kode_peminjaman_barang', $nextKodePeminjamanBarang) }}" class="form-control @error('kode_peminjaman_barang') is-invalid @enderror" id="kode_peminjaman_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_peminjam">Nama Peminjaman<span style="color: red">*</span></label>
                        <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}" class="form-control @error('nama_peminjam') is-invalid @enderror" id="nama_peminjam" required>
                        @error('nama_peminjam')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat<span style="color: red">*</span></label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" required>{{ old('alamat') }}</textarea>
                    </div>
                    @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Peminjaman<span style="color: red">*</span></label>
                        <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required>
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kontak">Telp/WA<span style="color: red">*</span></label>
                        <input type="number" name="kontak" value="{{ old('kontak') }}" class="form-control @error('kontak') is-invalid @enderror" id="kontak" required>
                        @error('kontak')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="id_item_barang">Pilih Barang</label>
                        <select name="id_item_barang" id="id_item_barang" class="form-control">
                            <option value="" disabled selected>- Pilih Item Barang -</option>
                            @foreach ($itemBarang as $row)
                            <option value="{{ $row->id_item_barang }}">{{ $row->kode_item_barang }} - {{ $row->nama_item_barang }} </option>
                            @endforeach
                        </select>
                    </div>
                    <button id="addToCart" class="btn btn-primary" type="button" onclick="tambahItem()" disabled>Tambah Item</button>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-2" id="peminjamanTable">
                            <h5>Keranjang Peminjaman</h5>
                            <thead class=" thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Item Barang</th>
                                    <th>Nama Item Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="keranjang-peminjaman">
                            </tbody>
                        </table>
                        <button class="btn btn-primary" type="submit">Simpan Peminjaman</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    const addToCartButton = document.getElementById('addToCart');
    const idItemBarangSelect = document.getElementById('id_item_barang');
    const peminjamanTable = document.getElementById('peminjamanTable');
    let rowCount = 1;
    const addedItems = new Set();
    const deletedItems = new Set();

    idItemBarangSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        const existingItem = peminjamanTable.querySelector(`[data-id="${selectedValue}"]`);

        addToCartButton.disabled = selectedValue === '';
    });

    function tambahItem() {
        const selectedOption = idItemBarangSelect.options[idItemBarangSelect.selectedIndex];
        const idItemBarang = selectedOption.value;
        const kodeItemBarang = selectedOption.text.split(' - ')[0];
        const namaItemBarang = selectedOption.text.split(' - ')[1];

        const newRow = peminjamanTable.insertRow();
        newRow.innerHTML = `
        <td>${rowCount}</td>
        <td>${kodeItemBarang}
            <input type="hidden" name="idItemBarangSelect[]" value='${idItemBarang}'></td>
        <td>${namaItemBarang}</td>
        <td>
            <button class="btn btn-outline-danger btn-sm" onclick="hapusItem(this)" data-id="${idItemBarang}">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
        updateRowNumbers();

        addToCartButton.disabled = true;
        idItemBarangSelect.value = '';

        selectedOption.remove(); // Menghapus opsi terpilih dari elemen select

        addedItems.add(idItemBarang);
        deletedItems.delete(idItemBarang);

        const addedItemsInput = document.getElementById('addedItemsInput');
        addedItemsInput.value = Array.from(addedItems).join(',');
    }

    function hapusItem(button) {
        const row = button.parentNode.parentNode;
        const idItemBarang = button.getAttribute('data-id');

        peminjamanTable.deleteRow(row.rowIndex);
        updateRowNumbers();

        addToCartButton.disabled = false;

        addedItems.delete(idItemBarang);
        deletedItems.add(idItemBarang);

        const option = document.createElement('option');
        option.value = idItemBarang;
        option.text = row.cells[1].textContent + ' - ' + row.cells[2].textContent;
        idItemBarangSelect.appendChild(option);

        sortSelectOptions(idItemBarangSelect);

        const addedItemsInput = document.getElementById('addedItemsInput');
        addedItemsInput.value = Array.from(addedItems).join(',');
    }

    function updateRowNumbers() {
        const rows = peminjamanTable.getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            row.cells[0].textContent = i;
        }
    }

    function sortSelectOptions(select) {
        const options = Array.from(select.options);
        options.sort((a, b) => a.text.localeCompare(b.text));

        select.innerHTML = '';
        for (const option of options) {
            select.appendChild(option);
        }
    };
    const simpanPeminjamanButton = document.querySelector('button[type="submit"]');

    // Cek jika peminjamanTable tidak memiliki data saat tombol "Simpan Peminjaman" ditekan
    simpanPeminjamanButton.addEventListener('click', function(event) {
        if (peminjamanTable.rows.length <= 1) {
            event.preventDefault();
            alert('Tidak ada barang yang dipinjam. Harap tambahkan barang terlebih dahulu.');
        }
    });
</script>
@endsection
