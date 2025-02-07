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
        Schema::create('abonos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('nota_id');
            $table->foreign('nota_id')->references('id')->on('notas')->onDelete('cascade');
            $table->foreignId('metodo_de_pago_id');
            $table->foreign('metodo_de_pago_id')->references('id')->on('metodos_de_pago');
            $table->decimal('importe', 9, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_abono');
    }
};
