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
        Schema::create('incoming_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('supplier_id');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('total_items')->default(0);

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_items');
        Schema::dropIfExists('item_ins');
    }
};
