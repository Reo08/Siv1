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
            $table->integer('id_factura_cliente');
            $table->integer('total_debe');
            $table->foreign('id_factura_cliente')->references('id_factura_cliente')->on('facturas_clientes')->onDelete('cascade');
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
