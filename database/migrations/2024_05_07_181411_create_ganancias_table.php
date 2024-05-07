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
        Schema::create('ganancias', function (Blueprint $table) {
            $table->id('id_ganancia');
            $table->unsignedInteger('id_salida_venta');
            $table->integer('total_venta');
            $table->integer('total_ganancia');
            $table->foreign('id_salida_venta')->references('id_salida_venta')->on('salidas_ventas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ganancias');
    }
};
