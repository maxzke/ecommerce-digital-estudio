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
        Schema::create('nota_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_id');
            $table->foreign('nota_id')->references('id')->on('notas')->constrained()->onDelete('cascade');
            $table->text('descripcion_producto');
            $table->integer('cantidad');
            $table->decimal('precio', 9, 1);
            //Descuento en porcentaje %
            $table->integer('descuento')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_detalle');
    }
};
