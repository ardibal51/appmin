<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    // 📄 Tampilkan semua kategori
    public function index()
    {
        $categories = Category::orderBy('id')->get();
        return view('category.index', compact('categories'));
    }

    // 💾 Simpan kategori baru
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
            ]);

            // Buat kategori
            Category::create(['name' => $validatedData['name']]);

            // Redirect dengan pesan sukses untuk SweetAlert
            return redirect()->route('category.index')->with('success', 'Kategori "' . $validatedData['name'] . '" berhasil ditambahkan.');

        } catch (ValidationException $e) {
            // Jika validasi gagal, kembali dengan input, error, dan flash session
            // 'open_modal_kategori' agar modal terbuka otomatis di frontend.
            return redirect()->back()
                             ->withInput()
                             ->withErrors($e->errors())
                             ->with('open_modal_kategori', true);
        }
    }

    // ❌ Hapus kategori satuan
    public function destroy(Category $category)
    {
        $categoryName = $category->name;
        $category->delete();
        
        // Redirect dengan pesan sukses untuk SweetAlert
        return redirect()->route('category.index')->with('success', 'Kategori "' . $categoryName . '" berhasil dihapus.');
    }

    // 🔁 Update banyak kategori sekaligus
    public function updateMultiple(Request $request)
    {
        // Catatan: Anda mungkin ingin memastikan uniqueness dalam update multiple.
        // Untuk contoh ini, saya biarkan validasi yang ada.
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'required|string|max:255',
        ]);

        foreach ($request->categories as $id => $newName) {
            Category::where('id', $id)->update(['name' => $newName]);
        }

        return redirect()->route('category.index')->with('success', 'Semua kategori yang dipilih berhasil diperbarui.');
    }

    // 🧨 Hapus semua kategori
    public function destroyAll()
    {
        Category::truncate();
        return redirect()->route('category.index')->with('success', 'Semua kategori berhasil dihapus.');
    }

    // ✏️ Update kategori satuan
    public function update(Request $request, Category $category)
    {
        try {
            $validatedData = $request->validate([
                // Pastikan unik kecuali ID kategori saat ini
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            ]);

            $category->update(['name' => $validatedData['name']]);
            
            return redirect()->route('category.index')->with('success', 'Kategori berhasil diupdate menjadi "' . $validatedData['name'] . '".');

        } catch (ValidationException $e) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
    }
}