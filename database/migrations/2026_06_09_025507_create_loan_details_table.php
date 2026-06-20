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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel loans (Cascade: jika transaksi dihapus, detail ikut terhapus)
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade');
            // Menghubungkan ke tabel items
            $table->foreignId('item_id')->constrained('items')->onDelete('restrict');
            $table->integer('quantity'); // Jumlah barang yang dipinjam
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_details');
    }
};
