<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SesionController extends Controller
{
    public function create(Request $request){
        $credenciales = $request->validate([
            'correo' => "required|email",
            'contrasena' => "required"
        ]);

        $usuario = User::where('correo',$request->correo)->first();

        if(!$usuario){
            throw ValidationException::withMessages([
                'correo' => 'Estas credenciales no coinciden con nuestros registros'
            ]);
        }
        if(Hash::check($request->contrasena,$usuario->contrasena)){//Asi es para comparar las contraseñas que estan en bycript 
            Auth::login($usuario);
            $request->session()->regenerate();
            return redirect()->intended('inicio');
        }

        throw ValidationException::withMessages([
            'correo' => 'Estas credenciales no coinciden con nuestros registros'
        ]);
    }

    public function destroy(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}
