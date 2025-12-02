<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    /**
     * Menampilkan daftar PR
     */
    public function index()
    {
        $purchaseRequests = PurchaseRequest::with('items')->get();   
        $vendors = Vendor::all();

        return view('pr.index', compact('purchaseRequests', 'vendors'));
    }

    /**
     * Menampilkan form create PR (jika pakai halaman terpisah)
     */
    public function create()
    {
        return view('pr.create');
    }

    /**
     * Menyimpan data PR baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purpose' => 'required|string',
            'items' => 'required|array',
        ]);

        $pr = PurchaseRequest::create([
            'purpose' => $validated['purpose'],
            'requested_by' => 1, 
            'status' => 'draft',
        ]);

        foreach ($validated['items'] as $item) {
            $pr->items()->create($item);
        }

        return redirect()->route('purchase-requests.index')->with('success', 'PR berhasil dibuat');
    }

    /**
     * Menampilkan detail PR (biar route resource gak error)
     */
    public function show($id)
    {
        return redirect()->route('purchase-requests.index')->with('info', 'Fitur detail PR belum tersedia.');
    }

    /**
     * Menghapus semua history PR dan itemnya
     */
    public function destroyAll()
    {
        PurchaseRequestItem::query()->delete();
        PurchaseRequest::query()->delete();

        return redirect()->back()->with('success', 'Semua history permintaan pembelian berhasil dihapus.');
    }

    /**
     * Menghapus satu PR (pakai model binding biar clean)
     */
   public function destroy(PurchaseRequest $purchaseRequest)
{
    $purchaseRequest->items()->delete();
    $purchaseRequest->delete(); // soft delete
    return redirect()->route('purchase-requests.index')->with('success', 'PR berhasil dihapus');
}


    /**
     * Restore PR yang sudah dihapus (fitur tambahan)
     */
    public function restore($id)
    {
        $purchaseRequest = PurchaseRequest::withTrashed()->findOrFail($id);
        $purchaseRequest->restore();

        return redirect()->back()->with('success', 'PR berhasil direstore.');
    }
}
