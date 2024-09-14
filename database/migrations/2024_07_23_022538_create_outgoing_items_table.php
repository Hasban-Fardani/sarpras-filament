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
            $table->integer('total_items')->default(0);
            $table->text('note')->nullable();

            $table->foreign('operator_id')->references('id')->on('employees');
            $table->foreign('division_id')->references('id')->on('employees');
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
