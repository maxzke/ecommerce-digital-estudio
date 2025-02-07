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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->enum('tipo', ['carrito', 'venta', 'cotizacion', 'cancelada'])->default('venta');
            $table->boolean('facturar')->default(FALSE);
            $table->boolean('pagado')->default(FALSE);
            //cuando todos los productos se finalizan y se entregan
            $table->boolean('finalizado')->default(FALSE);
            //detalles cancelacion o cotizacion
            $table->text('detalles')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
