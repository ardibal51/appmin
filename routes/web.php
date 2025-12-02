<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendorController;

// 🏠 Homepage
Route::get('/', function () {
    return view('home.index');
})->name('home');

// 📦 Modul Stok
Route::resource('stock', StockController::class);

// 📝 Modul Purchase Request (PR)
Route::resource('purchase-requests', PurchaseRequestController::class);
Route::delete('/purchase-requests/destroy-all', [PurchaseRequestController::class, 'destroyAll'])
    ->name('purchase-requests.destroyAll');

// 🏷️ Modul Merk
Route::get('/merk', [MerkController::class, 'index'])->name('merk.index');
Route::post('/merk', [MerkController::class, 'store'])->name('merk.store');
Route::put('/merk/{merk}', [MerkController::class, 'update'])->name('merk.update');
Route::delete('/merk/{merk}', [MerkController::class, 'destroy'])->name('merk.destroy');
Route::post('/merk/update-multiple', [MerkController::class, 'updateMultiple'])->name('merk.updateMultiple');
Route::delete('/merk/destroy-all', [MerkController::class, 'destroyAll'])->name('merk.destroyAll');

// 📏 Modul Unit
Route::get('/unit', [UnitController::class, 'index'])->name('unit.index');
Route::post('/unit', [UnitController::class, 'store'])->name('unit.store');
Route::post('/unit/table', [UnitController::class, 'table'])->name('unit.table'); // nih buat manggil data pake datatable
Route::put('/unit/{unit}', [UnitController::class, 'update'])->name('unit.update');
Route::delete('/unit/{unit}', [UnitController::class, 'destroy'])->name('unit.destroy');
Route::post('/unit/update-multiple', [UnitController::class, 'updateMultiple'])->name('unit.updateMultiple');
Route::delete('/unit/destroy-all', [UnitController::class, 'destroyAll'])->name('unit.destroyAll');
Route::get('/unit/export', [UnitController::class, 'export'])->name('unit.export');
Route::post('/unit/{unit}/restore', [UnitController::class, 'restore'])->name('unit.restore');

// 🗂️ Modul Kategori
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::post('/category/update-multiple', [CategoryController::class, 'updateMultiple'])->name('category.updateMultiple');
Route::delete('/category/destroy-all', [CategoryController::class, 'destroyAll'])->name('category.destroyAll');

// 🧾 Modul Vendor
Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
Route::post('/vendor', [VendorController::class, 'store'])->name('vendor.store');
Route::get('/vendor/print', [VendorController::class, 'print'])->name('vendor.print');
Route::get('/vendor/{vendor}/edit', [VendorController::class, 'edit'])->name('vendor.edit');
Route::put('/vendor/{vendor}', [VendorController::class, 'update'])->name('vendor.update');
Route::delete('/vendor/{vendor}', [VendorController::class, 'destroy'])->name('vendor.destroy');
Route::post('/vendor/{vendor}/restore', [VendorController::class, 'restore'])->name('vendor.restore');
Route::get('/vendor/export', [VendorController::class, 'export'])->name('vendor.export');
Route::delete('/vendor/destroy-all', [VendorController::class, 'destroyAll'])->name('vendor.destroyAll');
