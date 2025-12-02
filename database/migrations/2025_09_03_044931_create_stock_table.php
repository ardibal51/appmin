<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama barang
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // kategori
            $table->string('merk_code')->nullable(); // merk / code
            $table->decimal('unit_price', 15, 2)->default(0); // harga satuan
            $table->integer('initial_stock')->default(0); // stok awal
            $table->string('unit', 50)->nullable(); // pcs, set, dll
            $table->integer('stock_remaining')->default(0); // stok tersisa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
