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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('purpose'); // keperluan PR
            $table->unsignedBigInteger('requested_by'); // user yang request
            $table->string('status')->default('draft'); // status PR (draft, approved, dll)
            
            // kalau nanti mau relasi ke vendor
            $table->unsignedBigInteger('vendor_id')->nullable();

            $table->timestamps();
            $table->softDeletes(); // penting untuk fitur restore
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
