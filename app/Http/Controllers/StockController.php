<?php
namespace App\Http\Controllers;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Merk;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StockController extends Controller
{
    // Menampilkan semua stok + master data + filter pencarian
    public function index(Request $request)
    {
        $query = Stock::with(['category', 'merk']);

        // Filter berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $stocks = $query->get();
        $categories = Category::orderBy('name')->get();
        $merks = Merk::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('stock.index', compact('stocks', 'categories', 'merks', 'units'));
    }

    // Form tambah stok (jika pakai halaman terpisah)
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $merks = Merk::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('stock.create', compact('categories', 'merks', 'units'));
    }

    // Simpan stok baru dari modal form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|string|max:255', // bisa ID atau manual
            'merk_code' => 'required|string|max:255',   // bisa ID atau manual
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'initial_stock' => 'required|integer|min:0',
            'stock_remaining' => 'required|integer|min:0',
        ]);

        // Tangani kategori manual
        if (Str::startsWith($validated['category_id'], 'manual_')) {
            $manualName = ucfirst(Str::after($validated['category_id'], 'manual_'));
            $category = Category::firstOrCreate(['name' => $manualName]);
            $validated['category_id'] = $category->id;
        }

        // Tangani merk manual (optional, kalau pakai prefix manual_)
        if (Str::startsWith($validated['merk_code'], 'manual_')) {
            $manualMerk = ucfirst(Str::after($validated['merk_code'], 'manual_'));
            $merk = Merk::firstOrCreate(['name' => $manualMerk]);
            $validated['merk_code'] = $merk->name;
        }

        Stock::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'merk_code' => $validated['merk_code'],
            'unit' => $validated['unit'],
            'unit_price' => $validated['unit_price'],
            'initial_stock' => $validated['initial_stock'],
            'stock_remaining' => $validated['stock_remaining'],
        ]);

        return redirect()->route('stock.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    // Form edit stok
    public function edit(Stock $stock)
    {
        $categories = Category::orderBy('name')->get();
        $merks = Merk::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('stock.edit', compact('stock', 'categories', 'merks', 'units'));
    }

    // Update stok
    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'initial_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'stock_remaining' => 'required|integer|min:0',
        ]);

        $stock->update($validated);

        return redirect()->route('stock.index')->with('success', 'Stok berhasil diperbarui.');
    }

    // Hapus stok
    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('stock.index')->with('success', 'Stok berhasil dihapus.');
    }
}
