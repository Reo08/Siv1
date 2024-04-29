<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConfiguracionesController extends Controller
{
    public function edit(){
        return view('configuraciones.edit');
    }

    public function update(Request $request,$identificacion){
        $request->validate([
            "contrasena_nueva1" => "required|min:4",
            "contrasena_nueva2" => "required|min:4"
        ]);
        
        $usuario = User::where('identificacion','=',$identificacion)->first();
        $usuario->contrasena = Hash::make($request->contrasena_nueva1);
        $usuario->save();
        
        return redirect()->route('configuraciones.edit')->with('alert','Se ha cambiado la contraseña con éxito.');
    }

    public function hello(){
        return view('configuraciones.hello');
    }
}
