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
        Schema::create('pagos_a_proveedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreignId('metodo_de_pago_id');
            $table->foreign('metodo_de_pago_id')->references('id')->on('metodos_de_pago');
            $table->string('folio')->nullable();
            $table->boolean('facturado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_a_proveedor');
    }
};
