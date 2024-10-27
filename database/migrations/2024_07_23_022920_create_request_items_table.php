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
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->foreign('division_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->foreign('operator_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->text('perihal')->nullable();
            $table->string('sifat')->nullable();
            $table->enum('status', ['draf', 'diajukan', 'disetujui', 'ditolak'])->default('draf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};
