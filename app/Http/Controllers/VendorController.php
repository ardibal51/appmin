<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // Tampilkan semua vendor di halaman utama + fitur pencarian
    public function index(Request $request)
    {
        $query = Vendor::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $vendors = $query->get();

        return view('vendor.index', compact('vendors'));
    }

    // Tampilkan form tambah vendor (kalau pakai halaman terpisah)
    public function create()
    {
        return view('vendors.create');
    }

    // Simpan data vendor baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Vendor::create($validated);

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil ditambahkan!');
    }

    // Tampilkan form edit vendor (kalau pakai halaman terpisah)
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendors.edit', compact('vendor'));
    }

    // Update data vendor
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $vendor->update($validated);

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil diperbarui!');
    }
    
    // Tampilkan semua vendor di halaman cetak
    public function print()
    {
        $vendors = Vendor::all();
        return view('vendor.print', compact('vendors'));
    }

    // Hapus vendor berdasarkan ID
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus.');
    }
}
