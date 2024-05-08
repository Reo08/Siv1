<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarioPredeterminado =  new User();
        $usuarioPredeterminado->nombre = "Administrador";
        $usuarioPredeterminado->correo = "sistemainventario2024@gmail.com";
        $usuarioPredeterminado->contrasena = Hash::make('12345');//asi se pone para utilizar bycript
        $usuarioPredeterminado->rol = "administrador";
        $usuarioPredeterminado->save();
    }
}
