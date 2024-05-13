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
            $table->integer('id_factura_cliente');
            $table->integer('total_ganancia');
            $table->foreign('id_factura_cliente')->references('id_factura_cliente')->on('facturas_clientes')->onDelete('cascade');
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
