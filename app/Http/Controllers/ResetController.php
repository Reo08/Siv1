<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Entradas;
use App\Models\Ganancias;
use App\Models\Importes;
use App\Models\Perdidas;
use App\Models\Productos;
use App\Models\Proveedor;
use App\Models\SalidasPerdidas;
use App\Models\SalidasVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    public function destroy(){
        Categorias::all()->each(function ($categoria) {
            $categoria->delete();
        });
        Proveedor::all()->each(function ($proveedor) {
            $proveedor->delete();
        });
        Productos::all()->each(function ($producto){
            $producto->delete();
        });
        Entradas::all()->each(function ($entrada){
            $entrada->delete();
        });
        SalidasVentas::all()->each(function ($ventas){
            $ventas->delete();
        });

        SalidasPerdidas::all()->each(function ($perdidas){
            $perdidas->delete();
        });
        Importes::all()->each(function ($importes){
            $importes->delete();
        });
        Ganancias::all()->each(function ($ganancias){
            $ganancias->delete();
        });
        Perdidas::all()->each(function ($perdidas){
            $perdidas->delete();
        });

        // Categorias::all()->delete();
        // Proveedor::all()->delete();
        // Productos::all()->delete();
        // SalidasVentas::all()->delete();
        // SalidasPerdidas::all()->delete();
        // Importes::all()->delete();
        // Ganancias::all()->delete();
        // Perdidas::all()->delete(); 


        DB::statement('ALTER TABLE categorias AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE proveedor AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE productos AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE entradas AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE salidas_ventas AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE salidas_perdidas AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE importes_pagados AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE ganancias AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE perdidas AUTO_INCREMENT = 1');

        return redirect()->route('inicio.index')->with('alert','Todos los datos se han eliminado con éxito.');
        
    }
}
