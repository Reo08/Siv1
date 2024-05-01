<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedor = new Proveedor();
        $proveedor->nombre_proveedor = "pro1";
        $proveedor->correo_proveedor = "pro1@gmail.com";
        $proveedor->telefono_proveedor = 1223;
        $proveedor->direccion_proveedor = "pro1";
        $proveedor->save();
    }
}
