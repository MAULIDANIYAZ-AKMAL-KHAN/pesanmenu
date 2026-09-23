<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel rincian item yang membentuk setiap pesanan.
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            
            // Hubungkan detail ke pesanan dan hapus detail saat pesanan dihapus.
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // Hubungkan detail ke menu dan hapus detail saat menu dihapus.
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade');

            $table->integer('quantity');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
