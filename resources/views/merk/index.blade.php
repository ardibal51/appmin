@extends('home.index')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Merk</h4>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMerk">
            Tambah Merk
        </button>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Modal Tambah Merk -->
    <div class="modal fade" id="modalTambahMerk" tabindex="-1" aria-labelledby="modalTambahMerkLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('merk.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahMerkLabel">Tambah Merk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Merk</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama merk" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.form.submit();">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Merk -->
    <table id="merkTable" class="table table-bordered table-hover table-sm">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nama Merk</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($merks as $merk)
                <tr>
                    <td>{{ $merk->id }}</td>
                    <td>{{ $merk->name }}</td>
                    <td class="text-center">
                        <form id="delete-form-{{ $merk->id }}" action="{{ route('merk.destroy', $merk->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $merk->id }}, '{{ $merk->name }}')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada merk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
function confirmDelete(merkId, merkName) {
    Swal.fire({
        title: 'Yakin ingin menghapus merk ini?',
        text: "Merk '" + merkName + "' akan dihapus permanen!",
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
            document.getElementById('delete-form-' + merkId).submit();
        }
    });
}

$(document).ready(function() {
    $('#merkTable').DataTable({
        paging: true,
        pageLength: 10,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: true,
        pagingType: 'full_numbers',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            paginate: {
                first: '«',
                previous: '‹',
                next: '›',
                last: '»'
            }
        },
        // ⬇️ ini yang penting, biar info + pagination cuma di bawah
        dom: 't<"d-flex justify-content-between align-items-center mt-2"i p>'
    });
});

</script>
@endsection
