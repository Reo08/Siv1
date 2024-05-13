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
        Schema::create('perdidas', function (Blueprint $table) {
            $table->id('id_perdida');
            $table->unsignedInteger('id_salida_perdida');
            $table->integer('total_perdida');
            $table->string('fecha_perdida');
            $table->foreign('id_salida_perdida')->references('id_salida_perdida')->on('salidas_perdidas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perdidas');
    }
};
