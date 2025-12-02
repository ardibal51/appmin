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

        $unit = Unit::create($request->only('name'));

        // disini kalo mau pake ajax jgn di return redirect, harus kirim response json, kalo bisa pake try catch juga
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unit' => $unit,
            ], 201);
        }

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

    /**
     * Server-side endpoint for DataTables
     */
    public function table(Request $request)
    {
        $columns = $request->input('columns', []);

        $draw = intval($request->input('draw'));
        $start = intval($request->input('start', 0));
        $length = intval($request->input('length', 10));
        $searchValue = $request->input('search.value');

        $orderColumn = 'id';
        $orderDir = $request->input('order.0.dir', 'asc');

        if ($request->has('order.0.column')) {
            $orderIdx = intval($request->input('order.0.column'));
            if (isset($columns[$orderIdx]['data']) && in_array($columns[$orderIdx]['data'], ['id', 'name'])) {
                $orderColumn = $columns[$orderIdx]['data'];
            } else {
                $orderColumn = $orderIdx === 1 ? 'name' : 'id';
            }
        }

        $query = Unit::query();

        $recordsTotal = $query->count();

        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('id', 'like', "%{$searchValue}%");
            });
        }

        $recordsFiltered = $query->count();

        if (in_array($orderColumn, ['id', 'name'])) {
            $query->orderBy($orderColumn, $orderDir);
        }

        $units = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($units as $unit) {
            $action = '<form id="delete-form-' . $unit->id . '" action="' . route('unit.destroy', $unit->id) . '" method="POST" style="display:inline-block;">'
                . '<input type="hidden" name="_token" value="' . csrf_token() . '">'
                . '<input type="hidden" name="_method" value="DELETE">'
                . '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(' . $unit->id . ', \'' . addslashes($unit->name) . '\')">'
                . '<i class="bi bi-trash"></i> Hapus'
                . '</button></form>';

            $data[] = [
                'id' => $unit->id,
                'name' => $unit->name,
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
