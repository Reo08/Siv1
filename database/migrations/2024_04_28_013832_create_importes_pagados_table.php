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
        Schema::create('importes_pagados', function (Blueprint $table) {
            $table->id('id_importe');
            $table->unsignedInteger('id_entrada');
            $table->unsignedInteger('id_producto');
            $table->integer('cantidad_importe');
            $table->integer('precio_compra');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importes_pagados');
    }
};
