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
        Schema::create('salidas_ventas', function (Blueprint $table) {
            $table->increments('id_salida_venta');
            $table->unsignedInteger('id_producto');
            $table->integer('cantidad');
            $table->integer('precio_venta');
            $table->integer('precio_compra');
            $table->string('identificacion')->nullable();
            $table->string('fecha_venta');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->foreign('identificacion')->references('identificacion')->on('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas_ventas');
    }
};