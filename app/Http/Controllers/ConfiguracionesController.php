<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{
    public function edit(){
        return view('configuraciones.edit');
    }

    public function update($identificacion){
        $usuario = User::where('identificacion','=',$identificacion)->first();
        $usuario->save();
        
        return redirect()->route('configuraciones.edit')->with('alert','Se ha cambiado la contraseña con exito.');
    }

    public function hello(){
        return view('configuraciones.hello');
    }
}
