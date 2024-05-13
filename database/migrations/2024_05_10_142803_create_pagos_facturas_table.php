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
        Schema::create('pagos_facturas', function (Blueprint $table) {
            $table->increments('id_pago_factura');
            $table->integer('id_factura_cliente');
            $table->string('fecha_pago');
            $table->integer('monto');
            $table->foreign('id_factura_cliente')->references('id_factura_cliente')->on('facturas_clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_facturas');
    }
};
