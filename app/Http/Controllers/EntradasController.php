<?php

namespace App\Http\Controllers;

use App\Exports\EntradasExport;
use App\Models\Categorias;
use App\Models\Entradas;
use App\Models\Importes;
use App\Models\Productos;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EntradasController extends Controller
{
    public function index() {
        $entradas = Entradas::leftjoin('productos','entradas.id_producto','=','productos.id_producto')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->leftjoin('usuarios','entradas.identificacion','=','usuarios.identificacion')
        ->select('entradas.*','entradas.created_at as created','entradas.updated_at as updated', 'productos.*', 'categorias.*','usuarios.nombre as nombre_usuario')->distinct()->orderBy('id_entrada', 'desc')->paginate(15);
        return view('entradas.inde',compact('entradas'));
    }
    public function create(){
        $categorias = Categorias::all();

        return view('entradas.crear', ["categorias" => $categorias]);
    }
    public function productosCategoria($id){
        $productos = Productos::where('id_categoria','=', $id)->get();
        return json_encode($productos);
    }
    public function proveedoresSelect($id){
        $buscarProducto = Productos::where('id_producto','=', $id)->first();
        $proveedor = Proveedor::where('id_proveedor','=',$buscarProducto->id_proveedor)->get(); 
        return json_encode($proveedor);
    }


    public function store(Request $request){
        // return $importe[0]->precio_compra === intval($request->precio_compra) ? "son iguales" : "no son iguales";
        $verificarExistencia = Entradas::where('id_producto', '=', intval($request->sec_producto))->get();
        if(count($verificarExistencia) > 0){
            return redirect()->route('entradas.index')->with('alert', 'El producto ya se encuentra registrado');
        }else {
            $nuevaEntrada = new Entradas();
            $nuevaEntrada->id_producto = intval($request->sec_producto);
            $nuevaEntrada->cantidad_entrada = $request->cantidad;
            $nuevaEntrada->precio_compra_entrada = $request->precio_compra;
            $nuevaEntrada->precio_venta_entrada = $request->precio_venta;
            $nuevaEntrada->fecha_entrada = $request->fecha_entrada;
            $nuevaEntrada->identificacion = Auth::user()->identificacion; //IMPORTANTE: Poner la identificacion de la sesion del usuario
            $nuevaEntrada->save();

            $nuevoImporte = new Importes();
            $nuevoImporte->id_entrada = $nuevaEntrada->id_entrada;
            $nuevoImporte->id_producto = intval($request->sec_producto);
            $nuevoImporte->cantidad_importe = $request->cantidad;
            $nuevoImporte->precio_compra = $request->precio_compra;
            $nuevoImporte->save();
            return redirect()->route('entradas.index');
        }

    }
    public function edit($id){
        $entradas = Entradas::leftjoin('productos','entradas.id_producto','=','productos.id_producto')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->leftjoin('proveedor','productos.id_proveedor','=','proveedor.id_proveedor')
        ->select('entradas.*', 'productos.*', 'categorias.*','proveedor.*')->where('id_entrada','=',"$id")->distinct()->first();

        // $categorias = Categorias::all();
        // $productos = Productos::all();
        // $proveedores = Proveedor::all();

        // return view('entradas.actualizar', compact('entradas','categorias','productos','proveedores'));
        return view('entradas.actualizar', compact('entradas'));
        // return $entradas;
    }
    public function update(Request $request,Entradas $id){

        if($request->precio_compra != $id->precio_compra_entrada){
            $importe =  Importes::where('id_entrada','=',$id->id_entrada)->where('id_producto','=',$id->id_producto)->where('precio_compra','=',$id->precio_compra_entrada)->first();
            $importe->cantidad_importe = $importe->cantidad_importe - $id->cantidad_entrada;
            $importe->save();


            $nuevoImporte = new Importes();
            $nuevoImporte->id_entrada = $id->id_entrada;
            $nuevoImporte->id_producto = $id->id_producto;
            $nuevoImporte->cantidad_importe = $id->cantidad_entrada;
            $nuevoImporte->precio_compra = $request->precio_compra;
            $nuevoImporte->save();
        }


        $id->id_producto = intval($request->id_producto);
        $id->precio_compra_entrada = $request->precio_compra;
        $id->precio_venta_entrada = $request->precio_venta;
        $id->fecha_entrada = $request->fecha_entrada;
        //$nuevaEntrada->identificacion = "12345"; //IMPORTANTE: Poner la identificacion de la sesion del usuario
        $id->save();

        return redirect()->route('entradas.index');
    }
    public function editCantidad($id){
        $entradas = Entradas::leftjoin('productos','entradas.id_producto','=','productos.id_producto')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->leftjoin('proveedor','productos.id_proveedor','=','proveedor.id_proveedor')
        ->select('entradas.*', 'productos.*', 'categorias.*','proveedor.*')->where('id_entrada','=',"$id")->distinct()->first();

        return view('entradas.actualizarCantidad', compact('entradas'));
        // return $entradas;
    }
    public function updateCantidad(Request $request,Entradas $id){
        $importe = Importes::where('id_producto','=', $id->id_producto)->where('id_entrada','=',$id->id_entrada)->where('precio_compra','=',$id->precio_compra_entrada)->first();

        if($request->sec_operacion == 1){
            $importe->cantidad_importe = $importe->cantidad_importe + $request->cantidad_entrada;
            $importe->save();
            $id->cantidad_entrada = $id->cantidad_entrada + $request->cantidad_entrada;
            $id->save();

            return redirect()->route('entradas.index')->with('alert','Existencias agregadas con exito');

        }else if($request->sec_operacion == 0){
            if($request->cantidad_entrada > $id->cantidad_entrada){
                return redirect()->route('entradas.index')->with('alert','La cantidad que quiere eliminar es mayor a la cantidad que tiene en existencias');
            }else {
                $id->cantidad_entrada = $id->cantidad_entrada - $request->cantidad_entrada;
                $id->save();

                $importe->cantidad_importe = $importe->cantidad_importe - $request->cantidad_entrada;
                $importe->save();

                return redirect()->route('entradas.index')->with('alert','Existencias eliminadas con exito');
            }
        }
        

    }

    public function destroy(Entradas $id){
        $importe = Importes::where('id_producto','=',$id->id_producto)->where('id_entrada','=',$id->id_entrada)->where('precio_compra','=',$id->precio_compra_entrada)->first();
        $importe->cantidad_importe = $importe->cantidad_importe - $id->cantidad_entrada;
        $importe->save();
        $id->delete();
        return redirect()->route('entradas.index');
    }

    public function export(){
        return Excel::download(new EntradasExport, 'entradas.xlsx');
    }
}