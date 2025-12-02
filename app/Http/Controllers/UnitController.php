<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    // 🧾 Tampilkan semua unit + search + pagination
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $units = $query->orderBy('id', 'asc')
                       ->paginate(10)
                       ->appends($request->all());

        return view('unit.index', compact('units'));
    }

    // ➕ Simpan unit baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
        ]);

        Unit::create($request->only('name'));

        return redirect()->route('unit.index')->with('success', 'Unit berhasil ditambahkan');
    }

    // ✏️ Update unit
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units')->ignore($unit->id),
            ],
        ]);

        $unit->update($request->only('name'));

        return redirect()->route('unit.index')->with('success', 'Unit berhasil diperbarui');
    }

    // 🗑️ Soft delete unit
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('unit.index')->with('success', 'Unit berhasil dihapus');
    }

    // ♻️ Restore unit yang dihapus
    public function restore($id)
    {
        $unit = Unit::withTrashed()->findOrFail($id);
        $unit->restore();

        return redirect()->route('unit.index')->with('success', 'Unit berhasil direstore');
    }

    // 🔁 Update banyak unit sekaligus
    public function updateMultiple(Request $request)
    {
        $request->validate([
            'units' => 'required|array',
            'units.*' => 'required|string|max:255',
        ]);

        foreach ($request->units as $id => $newName) {
            Unit::where('id', $id)->update(['name' => $newName]);
        }

        return redirect()->route('unit.index')->with('success', 'Unit berhasil diperbarui');
    }

    // 🧹 Soft delete semua unit
    public function destroyAll()
    {
        Unit::query()->delete();
        return redirect()->route('unit.index')->with('success', 'Semua unit berhasil dihapus');
    }

    // 🚮 Hapus permanen semua unit yang sudah di-soft delete
    public function forceDestroyAll()
    {
        Unit::onlyTrashed()->forceDelete();
        return redirect()->route('unit.index')->with('success', 'Semua unit dihapus permanen');
    }
}
