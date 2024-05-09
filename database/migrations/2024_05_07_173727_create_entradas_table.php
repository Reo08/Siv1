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
            $table->increments('id_entrada');
            $table->string('referencia');
            $table->integer('cantidad_entrada');
            $table->integer('costo_inversion');
            $table->integer('precio_venta_distribuidor');
            $table->unsignedInteger('id_usuario');
            $table->string('fecha_ingreso');
            $table->foreign('referencia')->references('referencia')->on('productos')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
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
