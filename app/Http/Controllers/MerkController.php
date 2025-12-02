<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    // 📄 Tampilkan semua merk
    public function index()
    {
        $merks = Merk::orderBy('id')->get();
        return view('merk.index', compact('merks'));
    }

    // 💾 Simpan merk baru dari modal
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:merks,name',
        ]);

        Merk::create([
            'name' => $request->name,
        ]);

        return redirect()->route('merk.index')->with('success', 'Merk berhasil ditambahkan');
    }

    // 🔄 Update merk
    public function update(Request $request, Merk $merk)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:merks,name,' . $merk->id,
        ]);

        $merk->update([
            'name' => $request->name,
        ]);

        return redirect()->route('merk.index')->with('success', 'Merk berhasil diupdate');
    }

    // ❌ Hapus merk satuan
    public function destroy(Merk $merk)
    {
        $merk->delete();
        return redirect()->route('merk.index')->with('success', 'Merk berhasil dihapus');
    }

    // 🔁 Update banyak merk sekaligus
    public function updateMultiple(Request $request)
    {
        $request->validate([
            'merks' => 'required|array',
            'merks.*' => 'required|string|max:255',
        ]);

        foreach ($request->merks as $id => $newName) {
            Merk::where('id', $id)->update(['name' => $newName]);
        }

        return redirect()->route('merk.index')->with('success', 'Merk berhasil diperbarui');
    }

    // 🧨 Hapus semua merk
    public function destroyAll()
    {
        Merk::truncate();
        return redirect()->route('merk.index')->with('success', 'Semua merk berhasil dihapus');
    }
}