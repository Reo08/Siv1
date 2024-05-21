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
        Schema::create('perdidas_credito', function (Blueprint $table) {
            $table->id('id_perdida_credito');
            $table->integer('id_salida_perdida_credito');
            $table->integer('total_debe');
            $table->foreign('id_salida_perdida_credito')->references('id_salida_perdida_credito')->on('salidas_perdidas_credito')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perdidas_credito');
    }
};
