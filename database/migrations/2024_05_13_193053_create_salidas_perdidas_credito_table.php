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
        Schema::create('salidas_perdidas_credito', function (Blueprint $table) {
            $table->integer('id_salida_perdida_credito')->primary();
            $table->integer('id_factura_cliente');
            $table->integer('nit_cedula');
            $table->integer('id_usuario');
            $table->integer('valor_total');
            $table->integer('debe');
            $table->integer('pagado');
            $table->string('fecha_factura');
            $table->string('fecha_limite_pago');
            $table->string('factura_electronica');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas_perdidas_credito');
    }
};
