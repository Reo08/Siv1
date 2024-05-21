<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

function limpiar_cadena($cadena){
    $cadena= trim($cadena);
    $cadena=stripslashes($cadena);
    $cadena=str_ireplace("<script>","",$cadena);
    $cadena=str_ireplace("</script>","",$cadena);
    $cadena=str_ireplace("<script src","",$cadena);
    $cadena=str_ireplace("<script type=","",$cadena);
    $cadena=str_ireplace("SELECT * FROM","",$cadena);
    $cadena=str_ireplace("DELETE FROM","",$cadena);
    $cadena=str_ireplace("INSERT INTO","",$cadena);
    $cadena=str_ireplace("DROP TABLE","",$cadena);
    $cadena=str_ireplace("DROP DATABASE","",$cadena);
    $cadena=str_ireplace("TRUNCATE TABLE","",$cadena);
    $cadena=str_ireplace("SHOW TABLES","",$cadena);
    $cadena=str_ireplace("SHOW DATABSES","",$cadena);
    $cadena=str_ireplace("<?php","",$cadena);
    $cadena=str_ireplace("?>","",$cadena);
    $cadena=str_ireplace("--","",$cadena);
    $cadena=str_ireplace("^","",$cadena);
    $cadena=str_ireplace("<","",$cadena);
    $cadena=str_ireplace("[","",$cadena);
    $cadena=str_ireplace("]","",$cadena);
    $cadena=str_ireplace("==","",$cadena);
    $cadena=str_ireplace(";","",$cadena);
    $cadena=str_ireplace("::","",$cadena);
    $cadena=trim($cadena);
    $cadena=stripslashes($cadena);
    return $cadena;
}

class ConfiguracionesController extends Controller
{
    public function edit(){
        return view('configuraciones.edit');
    }

    public function update(Request $request,$id_usuario){
        $request->validate([
            "contrasena_nueva1" => "required|min:4",
            "contrasena_nueva2" => "required|min:4"
        ]);
        
        $usuario = User::where('identificacion','=',$id_usuario)->first();
        $usuario->contrasena = Hash::make(limpiar_cadena($request->contrasena_nueva1));
        $usuario->save();
        
        return redirect()->route('configuraciones.edit')->with('alert','Se ha cambiado la contraseña con éxito.');
    }

    public function hello(){
        return view('configuraciones.hello');
    }
}
