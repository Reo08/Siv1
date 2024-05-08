<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index(){
        $clientes = Clientes::paginate(20);
        return view('clientes.inde', compact('clientes'));
    }
    public function create(){
        return view('clientes.crear');
    }
    public function store(Request $request){
        $request->validate([
            'nit_cedula' => 'required|max:20',
            'nombre_cliente' => 'required|max:120',
            'correo_cliente' => 'required|email|max:200',
            'telefono' => 'required|max:20',

        ]);
        $buscarNit = Clientes::where('nit_cedula','=',$request->nit_cedula)->get();
        if(count($buscarNit)>0){
            return redirect()->route('clientes.index')->with('alert','El Nit o Cedula ya está registrado en un cliente ya existente.');
        }
        $buscarCorreo = Clientes::where('correo','=', $request->correo_cliente)->get();
        if(count($buscarCorreo)>0){
            return redirect()->route('clientes.index')->with('alert','El correo ya está registrado en un cliente ya existente.');
        }

        $nuevoCliente = new Clientes();
        $nuevoCliente->nit_cedula = $request->nit_cedula;
        $nuevoCliente->nombre_cliente = $request->nombre_cliente;
        $nuevoCliente->correo = $request->correo_cliente;
        $nuevoCliente->telefono = strval($request->telefono);
        $nuevoCliente->save();
        return redirect()->route('clientes.index');
    }

    public function edit($nit) {
        $buscarCliente = Clientes::where('nit_cedula','=',$nit)->first();
        return view('clientes.actualizar', compact('buscarCliente'));
    }
    public function update(Request $request,Clientes $nit){
        $request->validate([
            'nit_cedula' => 'required|max:20',
            'nombre_cliente' => 'required|max:120',
            'correo_cliente' => 'required|email|max:200',
            'telefono' => 'required|max:20',

        ]);

        $buscarCliente = Clientes::where('correo','=',$request->correo_cliente)->where('correo','!=',$nit->correo)->get();
        if(count($buscarCliente)>0){
            return redirect()->route('clientes.index')->with('alert','El correo ya está registrado en un cliente ya existente.');
        }
        $buscarCliente2 = Clientes::where('nit_cedula','=',$request->nit_cedula)->where('nit_cedula','!=',$nit->nit_cedula)->get();
        if(count($buscarCliente2)){
            return redirect()->route('clientes.index')->with('alert','El Nit o Cedula ya está registrado en un cliente ya existente.');
        }

        $nit->nit_cedula = $request->nit_cedula;
        $nit->nombre_cliente = $request->nombre_cliente;
        $nit->correo = $request->correo_cliente;
        $nit->telefono = strval($request->telefono);
        $nit->save();

        return redirect()->route('clientes.index')->with('alert','Cliente actualizado con éxito.');
    }

    public function destroy(Clientes $nit){
        $nit->delete();
        return redirect()->route('clientes.index')->with('alert','Cliente eliminado con éxito.');
    }
}
