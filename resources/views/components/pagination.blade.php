@if ($data->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-2">
        <div>
            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
        </div>
        <div>
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
