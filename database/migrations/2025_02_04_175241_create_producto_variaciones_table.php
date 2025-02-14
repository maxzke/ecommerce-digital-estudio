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
        Schema::create('producto_variaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->constrained()->onDelete('cascade');
            $table->decimal('precio_variacion', 9, 2)->default(0); // Precio adicional
            $table->integer('stock')->default(0); // Stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_variaciones');
    }
};
