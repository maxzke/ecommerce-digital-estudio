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
        Schema::create('producto_variacion_atributo_valor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_variacion_id');
            $table->foreign('producto_variacion_id')->references('id')->on('producto_variaciones')->constrained()->onDelete('cascade');
            $table->foreignId('atributo_valor_id');
            $table->foreign('atributo_valor_id')->references('id')->on('atributo_valores')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atributo_valor_producto_variacion');
    }
};
