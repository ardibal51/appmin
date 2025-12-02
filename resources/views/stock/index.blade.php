@extends('home.index')

@section('content')
<div class="container">

    {{-- Error Handling --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tombol search --}}
<form action="{{ route('stock.index') }}" method="GET" class="mb-3 d-flex" style="max-width: 400px;">
    <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama Produk..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-outline-primary">Search</button>
</form>

    {{-- Tombol Tambah Stok --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Stok Produk</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
             Tambah Stok
        </button>
    </div>

 {{-- Tabel Stok --}}
@if($stocks->count())
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Merk</th>
            <th>Harga Satuan</th>
            <th>Stok Awal</th>
            <th>Unit</th>
            <th>Sisa Stok</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $index => $stock)
            @php
                $status = $stock->stock_remaining > 0 ? 'Stock Tersedia' : 'Stock Habis';
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $stock->name }}</td>
                <td>{{ $stock->category->name ?? '-' }}</td>
                <td>{{ $stock->merk_code }}</td>
                <td>{{ number_format($stock->unit_price) }}</td>
                <td>{{ $stock->initial_stock }}</td> {{-- Unit dihapus --}}
                <td>{{ $stock->unit }}</td>
                <td>{{ $stock->stock_remaining }}</td> {{-- Unit dihapus --}}
                <td>
                    <span class="badge {{ $status == 'Stock Tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('stock.edit', $stock->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <div class="alert alert-info">Belum ada data stok.</div>
@endif

    {{-- Modal Tambah Stok --}}
    <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('stock.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStockModalLabel">Tambah Stok Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                        </div>

                           {{-- Kategori --}}
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>

                                    {{-- Opsi manual tambahan --}}
                                    @php
                                        $manualCategories = ['Furniture', 'Aksesoris', 'Computer', 'Monitor', 'Peripheral', 'Printer', 'Software', 'Properti', 'Mesin', 'Kendaraan', 'Gedung', 'Elektronik', 'Otomotif', 'Pendingin ruangan' ];
                                    @endphp
                                    @foreach($manualCategories as $manual)
                                        <option value="manual_{{ strtolower($manual) }}" {{ old('category_id') == 'manual_' . strtolower($manual) ? 'selected' : '' }}>
                                            {{ $manual }}
                                        </option>
                                    @endforeach

                                    {{-- Opsi dari database --}}
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Merk --}}
                            <div class="mb-3">
                            <label for="merk_code" class="form-label">Merk / Kode</label>
                            <select name="merk_code" class="form-select" required>
                                <option value="">-- Pilih Merk --</option>

                                {{-- Opsi manual tambahan --}}
                                @php
                                    $manualMerks = ['Kenko', 'Sidu', 'Casio', 'Joyko', 'Bantex', 'Hp', 'Logitech', 'Asus', 'Acer', 'Dell', 'Fujitsu', 'Lenovo', 'Microsoft', 'Apple', 'Samsung', 'Sony', 'Toshiba', 'LG', 'Panasonic', 'Sharp', 'Hitachi', 'Mitsubishi', 'Daikin', 'Gree', 'Polytron'];
                                @endphp
                                @foreach($manualMerks as $code)
                                    <option value="{{ strtolower($code) }}" {{ old('merk_code') == strtolower($code) ? 'selected' : '' }}>
                                        {{ ucfirst($code) }}
                                    </option>
                                @endforeach

                                {{-- Opsi dari stok --}}
                                @foreach ($merks as $merk)
                                    @php
                                        $merkName = is_object($merk) ? ($merk->name ?? '') : (is_array($merk) ? ($merk['name'] ?? '') : $merk);
                                    @endphp
                                    @if(!empty($merkName) && !in_array(ucfirst($merkName), $manualMerks))
                                        <option value="{{ strtolower($merkName) }}" {{ old('merk_code') == strtolower($merkName) ? 'selected' : '' }}>
                                            {{ ucfirst($merkName) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            </div>


                            {{-- Unit --}}
                            <div class="mb-3">
                            <label for="unit" class="form-label">Satuan</label>
                            <select name="unit" class="form-select" required>
                                <option value="">-- Pilih Satuan --</option>

                                {{-- Gabungkan manual dan database, lalu hilangkan duplikat --}}
                                @php
                                    $manualUnits = ['dus', 'pcs', 'set', 'keping', 'box', 'pack', 'unit', 'buah', 'rim', 'roll', 'batang', 'liter', 'kg', 'gram'];
                                    $dbUnits = $units->pluck('name')->map(fn($u) => strtolower($u))->toArray();
                                    $allUnits = collect(array_merge($manualUnits, $dbUnits))->unique();
                                @endphp

                                @foreach ($allUnits as $unit)
                                    <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>
                                        {{ ucfirst($unit) }}
                                    </option>
                                @endforeach
                            </select>
                            </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label for="unit_price" class="form-label">Harga Satuan</label>
                            <input type="number" name="unit_price" class="form-control" value="{{ old('unit_price') }}" required>
                        </div>

                        {{-- Stok Awal --}}
                        <div class="mb-3">
                            <label for="initial_stock" class="form-label">Stok Awal</label>
                            <input type="number" name="initial_stock" class="form-control" value="{{ old('initial_stock') }}" required>
                        </div>

                        {{-- Stok Masuk --}}
                        <div class="mb-3">
                            <label for="stock_in" class="form-label">Stok Masuk</label>
                            <input type="number" name="stock_in" class="form-control" value="{{ old('stock_in', 0) }}" required>
                        </div>

                        {{-- Sisa Stok --}}
                        <div class="mb-3">
                            <label for="stock_remaining" class="form-label">Sisa Stok</label>
                            <input type="number" name="stock_remaining" class="form-control" value="{{ old('stock_remaining') }}" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection 