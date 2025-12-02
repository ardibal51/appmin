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
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')
                  ->constrained('purchase_requests')
                  ->onDelete('cascade'); // biar ikut kehapus
            $table->string('item_name');
            $table->integer('qty');
            $table->decimal('estimated_price', 12, 2);
            $table->timestamps();
            $table->softDeletes(); // kalau mau item ikut soft delete juga
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items'); // fix typo
    }
};
