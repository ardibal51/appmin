@extends('home.index')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Permintaan Pembelian</h2>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPRModal">
            Tambah PR
        </button>

        <form id="delete-all-pr-form" method="POST" action="{{ route('purchase-requests.destroyAll') }}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger" onclick="confirmDeleteAllPR()">Hapus Semua History</button>
        </form>
    </div>

    {{-- ⬇️ Tabel PR dengan DataTables --}}
    <table id="prTable" class="table table-bordered display">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Keperluan</th>
                <th>Quantity</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($purchaseRequests as $index => $pr)
                @php $rowCount = count($pr->items); @endphp
                @foreach ($pr->items as $itemIndex => $item)
                <tr>
                    @if ($itemIndex == 0)
                        <td rowspan="{{ $rowCount }}">{{ $index + 1 }}</td>
                    @endif

                    <td>{{ $item->item_name }}</td>
                    <td>{{ $pr->purpose }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->estimated_price, 0, ',', '.') }}</td>

                    @if ($itemIndex == 0)
                        <td rowspan="{{ $rowCount }}">
                            <form id="delete-pr-form-{{ $pr->id }}" method="POST" action="{{ route('purchase-requests.destroy', $pr->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletePR({{ $pr->id }})">Hapus</button>
                            </form>
                        </td>
                    @endif
                </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada permintaan pembelian</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>  

{{-- Modal Tambah PR --}}
<div class="modal fade" id="createPRModal" tabindex="-1" aria-labelledby="createPRModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('purchase-requests.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPRModalLabel">Tambah Permintaan Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="purpose" class="form-label">Keperluan</label>
                        <input type="text" name="purpose" id="purpose" class="form-control" required>
                    </div>

                    <div id="items">
                        <div class="row mb-2">
                            <div class="col">
                                <input type="text" name="items[0][item_name]" class="form-control" placeholder="Nama Barang" required>
                            </div>
                            <div class="col">
                                <input type="number" name="items[0][qty]" class="form-control" placeholder="QTY" required>
                            </div>
                            <div class="col">
                                <input type="number" name="items[0][estimated_price]" class="form-control" placeholder="Taksiran Harga" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary" onclick="addItem()">Tambah Barang</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let index = 1;

function addItem() {
    const html = `
        <div class="row mb-2">
            <div class="col">
                <input type="text" name="items[${index}][item_name]" class="form-control" placeholder="Nama Barang" required>
            </div>
            <div class="col">
                <input type="number" name="items[${index}][qty]" class="form-control" placeholder="QTY" required>
            </div>
            <div class="col">
                <input type="number" name="items[${index}][estimated_price]" class="form-control" placeholder="Taksiran Harga" required>
            </div>
        </div>
    `;
    document.getElementById('items').insertAdjacentHTML('beforeend', html);
    index++;
}

// ✅ Binding ke window supaya bisa dipanggil dari tombol onclick
window.confirmDeletePR = function(prId) {
    Swal.fire({
        title: 'Yakin mau hapus PR ini?',
        text: "Data PR akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-danger mx-1',
            cancelButton: 'btn btn-secondary mx-1'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-pr-form-' + prId).submit();
        }
    });
};

window.confirmDeleteAllPR = function() {
    Swal.fire({
        title: 'Yakin mau hapus semua history PR?',
        text: "Semua data PR akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-danger mx-1',
            cancelButton: 'btn btn-secondary mx-1'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-all-pr-form').submit();
        }
    });
};

$(document).ready(function() {
    $('#prTable').DataTable({
        paging: true,
        pageLength: 10,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>
@endpush
