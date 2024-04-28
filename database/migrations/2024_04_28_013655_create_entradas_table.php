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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id('id_entrada');
            $table->unsignedInteger('id_producto');
            $table->integer('cantidad_entrada');
            $table->integer('precio_compra_entrada');
            $table->integer('precio_venta_entrada');
            $table->string('identificacion')->nullable();
            $table->string('fecha_entrada');
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
        Schema::dropIfExists('entradas');
    }
};
