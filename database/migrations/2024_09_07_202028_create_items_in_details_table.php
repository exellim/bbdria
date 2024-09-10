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
        Schema::create('items_in_details', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_code', 50)->references('receipt_code')->on('items_in');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->decimal('qty', 10, 2);
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_in_details');
    }
};
