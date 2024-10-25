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
       Schema::create('outgoing_item_details', function (Blueprint $table) {
           $table->id();
           $table->foreignId('outgoing_item_id')->constrained()->onDelete('cascade');
           $table->foreignId('item_id')->constrained()->onDelete('cascade');
           $table->integer('qty');
           $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_item_details');
        Schema::dropIfExists('item_out_details');
    }
};
