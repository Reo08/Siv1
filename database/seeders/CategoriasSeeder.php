<?php

namespace Database\Seeders;

use App\Models\Categorias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoria = new Categorias();
        $categoria->nombre_categoria = "negro";
        $categoria->save();

        $categoria2 = new Categorias();
        $categoria2->nombre_categoria = "blanco";
        $categoria2->save();

        $categoria3 = new Categorias();
        $categoria3->nombre_categoria = "gris";
        $categoria3->save();
    }
}
