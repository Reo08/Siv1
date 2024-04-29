<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UsuariosController extends Controller
{
    public function index() {
        $usuarios = User::orderBy('identificacion', 'desc')->paginate(15);
        return view('usuarios.inde', compact('usuarios'));
    }
    public function create() {
        return view('usuarios.crear');
    }

    public function store(Request $request){
        $buscarUsuario = User::where('identificacion','=',$request->identificacion)->get();
        $request->validate([
            "rol" => "required",
            "nombre" => "required|max:50",
            "identificacion" => "required|max:20",
            "correo" => "required|email",
            "contrasena" => "required|min:4"
        ]);
        if(count($buscarUsuario)>0){
            $buscarUsuario2 = User::where('correo','=',$request->correo)->get();
            if(count($buscarUsuario2)>0){
                return redirect()->route('usuarios.index')->with('alert','La identificación y el correo ya están registrados en un usuario ya existente.');
            }else {
                return redirect()->route('usuarios.index')->with('alert','La identificación ya está registrada en un usuario ya existente.');
            }
            
        }else{
            $buscarUsuario2 = User::where('correo','=',$request->correo)->get();
            if(count($buscarUsuario2)>0){
                return redirect()->route('usuarios.index')->with('alert','El correo ya está registrado en un usuario ya existente.');
            }
        }

        $nuevoUsuario = new User();
        $nuevoUsuario->identificacion = $request->identificacion;
        $nuevoUsuario->nombre = $request->nombre;
        $nuevoUsuario->correo = $request->correo;
        $nuevoUsuario->contrasena = Hash::make($request->contrasena);
        $nuevoUsuario->rol = intval($request->rol) === 0 ? 'Empleado': 'Administrador';
        $nuevoUsuario->save();
        return redirect()->route('usuarios.index')->with('alert','Se ha agregado el usuario con éxito.');
    }

    public function edit($identificacion){
        $usuario = User::where('identificacion','=',$identificacion)->first();

        return view('usuarios.actualizar', compact('usuario'));
    }
    public function update(Request $request, $identificacion){
        $usuario = User::where('identificacion','=',$identificacion)->first();
        $request->validate([
            "rol" => "required",
            "nombre" => "required|max:50",
            "identificacion" => "required|max:20",
            "correo" => "required|email"
        ]);
        $usuario->identificacion = $request->identificacion;
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;

        if($request->contrasena1 && $request->contrasena2){
            $usuario->contrasena = Hash::make($request->contrasena1);
            $usuario->save();
            return redirect()->route('usuarios.index')->with('alert', 'Usuario actualizado con éxito.');
        }else if($request->contrasena1 || $request->contrasena2){
            return redirect()->route('usuarios.index')->with('alert', 'Falta llenar un campo de contraseña.');
        }else{
            $usuario->save();
            return redirect()->route('usuarios.index')->with('alert', 'Usuario actualizado con éxito.');
        }
    }

    public function destroy($identificacion){
        $usuario = User::where('identificacion','=',$identificacion)->first();
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('alert', 'Usuario eliminado con exito');
    }

    public function export(){
        // 
        return Excel::download(new UserExport, 'usuarios.xlsx');
    }
}
