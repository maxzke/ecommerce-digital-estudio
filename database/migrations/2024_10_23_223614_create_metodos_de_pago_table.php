<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metodos_de_pago', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        // Insert default on migration
        DB::table('metodos_de_pago')->insert(
            array(
                [
                    'nombre' => 'efectivo',
                ],
                [
                    'nombre' => 'transferencia - COPPEL',
                ],
                [
                    'nombre' => 'tarjeta - BANAMEX',
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodos_de_pago');
    }
};
