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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('merk');
            $table->string('size')
                ->nullable()
                ->comment('ukuran barang, 0.25mm, 0.5mm, 20x20 dsb');
            $table->string('type')
                ->nullable()
                ->comment('tipe barang, ex: (kertas) foto, (pulpen) gel');
            $table->string('unit')
                ->nullable()
                ->comment('satuan barang, ex: unit, buah, box, dsb');
            $table->integer('price');
            $table->integer('stock');
            $table->integer('min_stock');
            $table->foreignId('category_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
