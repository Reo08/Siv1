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
        Schema::create('salidas_perdidas', function (Blueprint $table) {
            $table->increments('id_salida_perdida');
            $table->integer('id_entrada');
            $table->integer('referencia');
            $table->string('nombre_producto');
            $table->string('categoria');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->integer('costo_inversion');
            $table->unsignedInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas_perdidas');
    }
};
