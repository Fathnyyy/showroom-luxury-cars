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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand'); // Merk mobil
            $table->string('model'); // Model mobil
            $table->integer('year'); // Tahun produksi
            $table->decimal('price', 15, 2); // Harga
            $table->string('color'); // Warna
            $table->string('transmission'); // Transmisi (Manual/Automatic)
            $table->string('fuel_type'); // Jenis bahan bakar
            $table->integer('mileage'); // Kilometer
            $table->text('description'); // Deskripsi
            $table->string('image')->nullable(); // Gambar utama
            $table->json('gallery')->nullable(); // Galeri gambar
            $table->string('status')->default('available'); // Status (available/sold/reserved)
            $table->boolean('featured')->default(false); // Mobil unggulan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
