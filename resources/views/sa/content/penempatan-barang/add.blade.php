@extends ('sa.layout.main')
@section ('sa.content')

<div class="py-3 d-flex flex-row align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Tambah Penempatan Barang </h1>
    <a href="{{route('superadmin.penempatan_barang.index')}}"><button class="btn btn-primary">Kembali</button></a>
</div>

<form action="{{ route('superadmin.penempatan_barang.store') }}" method="POST">
    @csrf
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_penempatan_barang">Kode Penempatan Barang</label>
                        <input type="text" name="kode_penempatan_barang" value="{{ old('kode_penempatan_barang', $nextKodePenempatanBarang) }}" class="form-control" id="kode_penempatan_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_ruangan">Ruangan<span style="color: red">*</span></label>
                        <select id="id_ruangan" name="id_ruangan" class="form-control" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->kode_ruangan }} {{ $ruangan->nama_ruangan }}</option>
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
                        <input type="date" name="tanggal" max="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required>
                    </div>
                    @error('tanggal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3"></textarea>
                        @error('keterangan')
                        <span class="text-danger">{{ $message }}</span>
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
                            <option value="{{ $row->id_item_barang }}">
                                {{ $row->kode_item_barang }} - {{ $row->nama_item_barang }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button id="addToPenempatan" class="btn btn-primary" type="button" onclick="tambahItem()" disabled>Tambah Item</button>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table mb-3" id="penempatanTable">
                            <h5>Tabel Penempatan</h5>
                            <thead class=" thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Item Barang</th>
                                    <th>Nama Item Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="keranjang-Penempatan">
                            </tbody>
                        </table>
                        <button class="btn btn-primary" type="submit">Simpan Penempatan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    const addToPenempatanButton = document.getElementById('addToPenempatan');
    const idItemBarangSelect = document.getElementsByName('id_item_barang')[0];
    const penempatanTable = document.getElementById('penempatanTable');
    let rowCount = 1;
    const addedItems = new Set();
    const deletedItems = new Set();

    idItemBarangSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        const existingItem = penempatanTable.querySelector(`[data-id="${selectedValue}"]`);

        addToPenempatanButton.disabled = selectedValue === '';
    });

    function tambahItem() {
        const selectedOption = idItemBarangSelect.options[idItemBarangSelect.selectedIndex];
        const idItemBarang = selectedOption.value;
        const kodeItemBarang = selectedOption.text.split(' - ')[0];
        const namaItemBarang = selectedOption.text.split(' - ')[1];

        const newRow = penempatanTable.insertRow();
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

        addToPenempatan.disabled = true;
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

        penempatanTable.deleteRow(row.rowIndex);
        updateRowNumbers();

        addToPenempatan.disabled = false;

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
        const rows = penempatanTable.getElementsByTagName('tr');
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
    const simpanPenempatanButton = document.querySelector('button[type="submit"]');

    // Cek jika penempatanTable tidak memiliki data saat tombol "Simpan Peminjaman" ditekan
    simpanPenempatanButton.addEventListener('click', function(event) {
        if (penempatanTable.rows.length <= 1) {
            event.preventDefault();
            alert('Tidak ada barang yang ditempatkan. Harap tambahkan barang terlebih dahulu.');
        }
    });
</script>
@endsection