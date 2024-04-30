<?php

namespace App\Http\Controllers;

use App\Exports\ProveedoresExport;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

class ProveedoresController extends Controller
{

    public function index(){
        $proveedores = Proveedor::orderBy('id_proveedor', 'desc')->paginate(25);
        return view('proveedores.inde', compact('proveedores'));
    }
    public function create(){
        return view('proveedores.crear');
    }

    public function store(Request $request){

        $request->validate([
            'nombre_proveedor' => "required|max:100",
            'correo_proveedor' => "required|email",
            'telefono_proveedor' => "required|numeric",
            'direccion_proveedor' => "required"
        ]);

        $buscarCorreo = User::where('correo','=',limpiar_cadena($request->correo_proveedor))->get();
        if(count($buscarCorreo) > 0){
            return redirect()->route('proveedores.index')->with('alert','El correo ya se encuentra registrado.');
        }
        $buscarNombre = User::where('nombre','=',limpiar_cadena($request->nombre_proveedor))->get();
        if(count($buscarNombre) > 0){
            return redirect()->route('proveedores.index')->with('alert','El nombre del proveedor ya esta registrado.');
        }


        $nuevoProveedor = new Proveedor();
        $nuevoProveedor->nombre_proveedor = limpiar_cadena($request->nombre_proveedor);
        $nuevoProveedor->direccion_proveedor = limpiar_cadena($request->direccion_proveedor);
        $nuevoProveedor->telefono_proveedor = limpiar_cadena($request->telefono_proveedor);
        $nuevoProveedor->correo_proveedor = limpiar_cadena($request->correo_proveedor);
        $nuevoProveedor->save();

        return redirect()->route('proveedores.index')->with('alert','Se ha agregado el proveedor con éxito.');
    }
    public function edit(Proveedor $id){
        return view('proveedores.actualizar',compact('id'));
    }

    public function update(Request $request,Proveedor $id){
        $request->validate([
            'nombre_proveedor' => "required|max:100",
            'correo_proveedor' => "required|email",
            'telefono_proveedor' => "required|numeric",
            'direccion_proveedor' => "required"
        ]);

        $id->nombre_proveedor = limpiar_cadena($request->nombre_proveedor);
        $id->direccion_proveedor = limpiar_cadena($request->direccion_proveedor);
        $id->telefono_proveedor = limpiar_cadena($request->telefono_proveedor);
        $id->correo_proveedor = limpiar_cadena($request->correo_proveedor);
        $id->save();

        return redirect()->route('proveedores.index');
    }
    public function destroy(Proveedor $id){
        $id->delete();
        return redirect()->route('proveedores.index');
    }

    public function export(){
        return Excel::download(new ProveedoresExport, 'proveedores.xlsx');
    }
}
