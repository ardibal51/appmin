@extends('home.index')

@section('content')
<div class="container">
    <h4>Edit Stock Item</h4>

    <form action="{{ route('stock.update', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="initial_stock" class="form-label">Initial Stock</label>
            <input type="number" name="initial_stock" class="form-control" value="{{ $stock->initial_stock }}" required>
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" name="unit" class="form-control" value="{{ $stock->unit }}" required>
        </div>

        <div class="mb-3">
            <label for="stock_remaining" class="form-label">Stock Remaining</label>
            <input type="number" name="stock_remaining" class="form-control" value="{{ $stock->stock_remaining }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('stock.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection