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
        Schema::create('outgoing_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('qty')->default(0);
            $table->text('note')->nullable();
            $table->boolean('is_taken')->default(false);

            $table->foreign('operator_id')->references('id')->on('employees');
            $table->foreign('division_id')->references('id')->on('employees');
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_items');
        Schema::dropIfExists('item_outs');
    }
};
