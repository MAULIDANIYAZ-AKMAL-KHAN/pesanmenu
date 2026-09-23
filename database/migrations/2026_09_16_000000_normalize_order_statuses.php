<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Samakan status lama dengan nilai status yang digunakan aplikasi saat ini.
    public function up(): void
    {
        // Ubah kolom menjadi string agar status baru dapat disimpan.
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });

        // Migrasikan nilai status lama ke format internal berbahasa Inggris.
        DB::table('orders')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('orders')->where('status', 'Selesai')->update(['status' => 'completed']);
    }

    public function down(): void
    {
        DB::table('orders')->where('status', 'pending')->update(['status' => 'Pending']);
        DB::table('orders')->where('status', 'completed')->update(['status' => 'Selesai']);

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Diproses', 'Selesai'])->default('Pending')->change();
        });
    }
};