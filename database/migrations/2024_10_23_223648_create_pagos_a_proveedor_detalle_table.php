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
        Schema::create('pagos_a_proveedor_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagos_a_proveedor_id');
            $table->foreign('pagos_a_proveedor_id')->references('id')->on('pagos_a_proveedor');
            $table->text('concepto');
            $table->integer('cantidad');
            $table->decimal('importe', 9, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_a_proveedor_detalle');
    }
};
