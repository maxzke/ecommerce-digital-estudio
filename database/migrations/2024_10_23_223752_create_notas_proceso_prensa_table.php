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
        Schema::create('notas_proceso_prensa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_detalle_id');
            $table->foreign('nota_detalle_id')->references('id')->on('nota_detalles')->onDelete('cascade');
            $table->boolean('alerta')->default(false);
            $table->boolean('en_proceso')->default(false);
            $table->boolean('empaquetado')->default(false);
            $table->boolean('enviado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_proceso_prensa');
    }
};
