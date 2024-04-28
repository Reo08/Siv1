<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    public function index(){
        $proveedores = Proveedor::orderBy('id_proveedor', 'desc')->paginate(15);
        return view('proveedores.inde', compact('proveedores'));
    }
    public function create(){
        return view('proveedores.crear');
    }

    public function store(Request $request){

        $request->validate([
            'nombre_proveedor' => "required",
            'correo_proveedor' => "required",
            'telefono_proveedor' => "required",
            'direccion_proveedor' => "required"
        ]);
        $nuevoProveedor = new Proveedor();
        $nuevoProveedor->nombre_proveedor = $request->nombre_proveedor;
        $nuevoProveedor->direccion_proveedor = $request->direccion_proveedor;
        $nuevoProveedor->telefono_proveedor = $request->telefono_proveedor;
        $nuevoProveedor->correo_proveedor = $request->correo_proveedor;
        $nuevoProveedor->save();

        // $proveedores = Proveedor::orderBy('id_proveedor', 'desc')->paginate(15);
        // return redirect()->route('proveedores.index', compact('proveedores'));
        return redirect()->route('proveedores.index');
    }
    public function edit(Proveedor $id){
        return view('proveedores.actualizar',compact('id'));
    }

    public function update(Request $request,Proveedor $id){
        $request->validate([
            'nombre_proveedor' => "required",
            'correo_proveedor' => "required",
            'telefono_proveedor' => "required",
            'direccion_proveedor' => "required"
        ]);

        $id->nombre_proveedor = $request->nombre_proveedor;
        $id->direccion_proveedor = $request->direccion_proveedor;
        $id->telefono_proveedor = $request->telefono_proveedor;
        $id->correo_proveedor = $request->correo_proveedor;
        $id->save();

        // $proveedores = Proveedor::orderBy('id_proveedor', 'desc')->paginate(15);
        // return redirect()->route('proveedores.index', compact('proveedores'));
        return redirect()->route('proveedores.index');
    }
    public function destroy(Proveedor $id){
        $id->delete();
        return redirect()->route('proveedores.index');
    }
}
