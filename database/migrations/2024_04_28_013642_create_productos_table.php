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
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id_producto');
            $table->string('nombre_producto')->unique();
            $table->string('detalles_producto');
            $table->unsignedInteger('id_categoria');
            $table->unsignedInteger('id_proveedor');
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
