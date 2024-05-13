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
        Schema::create('facturas_clientes', function (Blueprint $table) {
            $table->integer('id_factura_cliente')->primary();
            $table->integer('nit_cedula');
            $table->unsignedInteger('id_usuario');
            $table->integer('valor_total')->nullable();
            $table->integer('debe')->nullable();
            $table->integer('pagado')->nullable();
            $table->string('fecha_factura');
            $table->string('fecha_limite_pago');
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
        Schema::dropIfExists('facturas_clientes');
    }
};
