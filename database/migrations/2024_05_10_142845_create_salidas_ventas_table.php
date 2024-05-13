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
        Schema::create('salidas_ventas', function (Blueprint $table) {
            $table->increments('id_salida_venta');
            $table->integer('id_factura_cliente');
            $table->unsignedInteger('id_entrada');
            $table->string('fecha_solicitud');
            $table->string('fecha_entrega');
            $table->integer('cantidad_orden');
            $table->string('estado_pedido');
            $table->integer('cantidad_elaborada');
            $table->integer('cantidad_entregada');
            $table->integer('nit_cedula');
            $table->unsignedInteger('id_usuario');
            $table->string('aplica_iva');
            $table->integer('descuento_o_recargo');
            $table->integer('valor_unidad');
            $table->integer('valor_total');
            $table->foreign('id_entrada')->references('id_entrada')->on('entradas')->onDelete('cascade');
            $table->foreign('nit_cedula')->references('nit_cedula')->on('clientes')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_factura_cliente')->references('id_factura_cliente')->on('facturas_clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas_ventas');
    }
};
