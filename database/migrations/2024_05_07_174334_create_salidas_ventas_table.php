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
            $table->string('referencia');
            $table->string('fecha_solicitud');
            $table->string('fecha_entrega');
            $table->integer('cantidad_orden');
            $table->string('estado_pedido');
            $table->string('cantidad_elaborada');
            $table->strgin('cantidad_entregada');
            $table->string('nit_cedula');
            $table->unsignedInteger('id_usuario');
            $table->string('aplica_iva');
            $table->string('n_descuento_recargo');
            $table->string('descuento_o_recargo');
            $table->integer('valor_unidad');
            $table->integer('valor_total');
            $table->integer('debe');
            $table->integer('pagado');
            $table->string('fecha_limite_pago');
            $table->foreign('referencia')->references('referencia')->on('productos')->onDelete('cascade');
            $table->foreign('nit_cedula')->references('nit_cedula')->on('clientes')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
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
