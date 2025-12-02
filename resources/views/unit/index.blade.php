@extends('home.index')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Unit</h4>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUnit">
            Tambah Unit
        </button>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Modal Tambah Unit --}}
    <div class="modal fade" id="modalTambahUnit" tabindex="-1" aria-labelledby="modalTambahUnitLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('unit.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahUnitLabel">Tambah Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Unit</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama unit" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.form.submit();">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Unit --}}
    <table class="table table-bordered table-hover table-sm">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nama Unit</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($units as $unit)
                <tr>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td class="text-center">
                        <form id="delete-form-{{ $unit->id }}" action="{{ route('unit.destroy', $unit->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $unit->id }}, '{{ $unit->name }}')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada unit.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Laravel pakai komponen --}}
    @include('components.pagination', ['data' => $units])
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(unitId, unitName) {
    Swal.fire({
        title: 'Yakin ingin menghapus unit ini?',
        text: "Unit '" + unitName + "' akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger mx-1',
            cancelButton: 'btn btn-secondary mx-1'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        zIndex: 9999
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + unitId).submit();
        }
    });
}
</script>
@endsection
