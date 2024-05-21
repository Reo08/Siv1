<?php

namespace App\Http\Controllers;

use App\Exports\EntradasExport;
use App\Models\Categorias;
use App\Models\Entradas;
use App\Models\Importes;
use App\Models\Perdidas;
use App\Models\Productos;
use App\Models\Proveedor;
use App\Models\SalidasPerdidas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

class EntradasController extends Controller
{
    public function index() {
        $entradas = Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->leftjoin('usuarios','entradas.id_usuario','=','usuarios.id_usuario')
        ->select('entradas.*', 'productos.*', 'categorias.*','usuarios.nombre as nombre_usuario')->distinct()->orderBy('id_entrada', 'desc')->paginate(20);
        $categorias = Categorias::all();
        return view('Entradas.inde',compact('entradas', 'categorias'));
        // return $entradas;
    }
    public function create(){
        $categorias = Categorias::all();

        return view('Entradas.crear', ["categorias" => $categorias]);
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
        $request->validate([
            "referencia" => "required|max:30",
            "nombre_producto" => "required|max:100",
            "sec_categoria" => "required",
            "descripcion_producto" => "required|max:250",
            "fecha_entrada" => "required",
            "costo_inversion" => "required|numeric",
            "precio_venta_distribuidor" => "required|numeric",
            "cantidad_entrada" => "required|numeric"
        ]);

        $verificarExistencia = Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->where('entradas.referencia','=',strval(limpiar_cadena($request->referencia)))
        ->where('precio_venta_distribuidor','=', limpiar_cadena($request->precio_venta_distribuidor))
        ->where('costo_inversion','=', limpiar_cadena($request->costo_inversion))->get();

        if(count($verificarExistencia)>0){
            return redirect()->route('entradas.index')->with('alert', 'Error, el producto ya se encuentra registrado.');
        }else {
            $buscarProducto = Productos::where('referencia','=',$request->referencia)->get();
            if(count($buscarProducto)==0){
                $productoNuevo = new Productos();
                $productoNuevo->referencia = $request->referencia;
                $productoNuevo->nombre_producto = $request->nombre_producto;
                $productoNuevo->descripcion_producto = limpiar_cadena($request->descripcion_producto);
                $productoNuevo->id_categoria = intval(limpiar_cadena($request->sec_categoria));
                $productoNuevo->save();
            }
            $entradaNueva = new Entradas();
            $entradaNueva->referencia = $request->referencia;
            $entradaNueva->cantidad_entrada = limpiar_cadena($request->cantidad_entrada);
            $entradaNueva->costo_inversion = limpiar_cadena($request->costo_inversion);
            $entradaNueva->precio_venta_distribuidor = limpiar_cadena($request->precio_venta_distribuidor);
            $entradaNueva->id_usuario = Auth::user()->id_usuario;
            $entradaNueva->fecha_ingreso = limpiar_cadena($request->fecha_entrada);
            $entradaNueva->save();
            

            $buscarCategoria = Categorias::where('id_categoria','=',intval($request->sec_categoria))->first();
            $perdidaRespaldo = new SalidasPerdidas();
            $perdidaRespaldo->id_entrada= $entradaNueva->id_entrada;
            $perdidaRespaldo->referencia = $request->referencia;
            $perdidaRespaldo->nombre_producto = $request->nombre_producto;
            $perdidaRespaldo->categoria = $buscarCategoria->nombre_categoria;
            $perdidaRespaldo->descripcion = $request->descripcion_producto;
            $perdidaRespaldo->cantidad = 0;
            $perdidaRespaldo->costo_inversion = $request->costo_inversion;
            $perdidaRespaldo->id_usuario = Auth::user()->id_usuario;
            $perdidaRespaldo->save();

            $nuevaPerdida = new Perdidas();
            $nuevaPerdida->id_salida_perdida = $perdidaRespaldo->id_salida_perdida;
            $nuevaPerdida->total_perdida = 0;
            $nuevaPerdida->save();

            $nuevoImporte = new Importes();
            $nuevoImporte->id_entrada = $entradaNueva->id_entrada;
            $nuevoImporte->referencia = $request->referencia;
            $nuevoImporte->cantidad_importe = limpiar_cadena($request->cantidad_entrada);
            $nuevoImporte->costo_inversion = limpiar_cadena($request->costo_inversion);
            $nuevoImporte->save();

            return redirect()->route('entradas.index')->with('alert','Se ha agregado la existencia con éxito.');
        }
    }
    public function edit($id){
        $entradas = Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->select('entradas.*', 'productos.*', 'categorias.*')->where('id_entrada','=',"$id")->distinct()->first();

        $categorias = Categorias::all();
        // $productos = Productos::all();
        // $proveedores = Proveedor::all();

        // return view('entradas.actualizar', compact('entradas','categorias','productos','proveedores'));
        return view('Entradas.actualizar', compact('entradas','categorias'));
        // return $entradas;
    }
    public function update(Request $request,Entradas $id){
        $request->validate([
            "nombre_producto" => "required|max:100",
            "sec_categoria" => "required",
            "descripcion_producto" => "required|max:250",
            "fecha_entrada" => "required",
        ]);

        $buscarProducto = Productos::where('referencia','=', $id->referencia)->first();
        $buscarProducto->nombre_producto = $request->nombre_producto;
        $buscarProducto->descripcion_producto = limpiar_cadena($request->descripcion_producto);
        $buscarProducto->id_categoria = intval(limpiar_cadena($request->sec_categoria));
        $buscarProducto->save();

        $id->id_usuario = Auth::user()->id_usuario;
        $id->fecha_ingreso = limpiar_cadena($request->fecha_entrada);
        $id->save();

        // Tabla de salidas perdidas
        $buscarCategoria = Categorias::where('id_categoria','=',intval($request->sec_categoria))->first();
        $buscarPerdida = SalidasPerdidas::where('id_entrada','=',$id->id_entrada)->first();
        $buscarPerdida->referencia = $id->referencia;
        $buscarPerdida->nombre_producto = $request->nombre_producto;
        $buscarPerdida->categoria = $buscarCategoria->nombre_categoria;
        $buscarPerdida->descripcion = $request->descripcion_producto;
        $buscarPerdida->save();

        return redirect()->route('entradas.index')->with('alert','Se ha actualizado la existencia con exito.');

    }
    public function editCantidad($id){
        $entradas = Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->select('entradas.*', 'productos.*', 'categorias.*')->where('id_entrada','=',$id)->distinct()->first();

        return view('Entradas.actualizarCantidad',compact('entradas'));
        // return $entradas;
    }
    public function updateCantidad(Request $request,Entradas $id){


        $request->validate([
            "sec_operacion" => "required",
            "cantidad_entrada" => "required|numeric",
        ]);
        $importe = Importes::where('referencia','=', $id->referencia)->where('id_entrada','=',$id->id_entrada)->where('costo_inversion','=',$id->costo_inversion)->first();
        $fecha = date("Y-m-d");

        if($request->sec_operacion == 1){
            // SUMA
            $importe->cantidad_importe = $importe->cantidad_importe + intval(limpiar_cadena($request->cantidad_entrada));
            $importe->save();
            $id->cantidad_entrada = $id->cantidad_entrada + intval(limpiar_cadena($request->cantidad_entrada));
            $id->fecha_ingreso = $fecha;
            $id->save();

            return redirect()->route('entradas.index')->with('alert','Existencias agregadas con éxito.');

        }else if($request->sec_operacion == 0){
            //RESTA
            if($request->cantidad_entrada > $id->cantidad_entrada){
                return redirect()->route('entradas.index')->with('alert','La cantidad que quiere eliminar es mayor a la cantidad que tiene en existencias.');
            }else {
                $id->cantidad_entrada = $id->cantidad_entrada - intval(limpiar_cadena($request->cantidad_entrada));
                $id->fecha_ingreso = $fecha;
                $id->save();

                $importe->cantidad_importe = $importe->cantidad_importe - intval(limpiar_cadena($request->cantidad_entrada));
                $importe->save();

                return redirect()->route('entradas.index')->with('alert','Existencias eliminadas con éxito.');
            }
        }
        

    }

    public function destroy(Entradas $id){
        // $importe = Importes::where('id_producto','=',$id->id_producto)->where('id_entrada','=',$id->id_entrada)->where('precio_compra','=',$id->precio_compra_entrada)->first();
        // $importe->cantidad_importe = $importe->cantidad_importe - $id->cantidad_entrada;
        // $importe->save();
        $buscarEntradas =  Entradas::where('referencia','=',$id->referencia)->where('id_entrada','!=',$id->id_entrada)->get();
        if(count($buscarEntradas)=== 0){
            // "No tiene mas entradas a demas de esta, puede eliminar el producto";
            $producto = Productos::where('referencia','=',$id->referencia)->first();
            $producto->delete();

            $id->delete();
            $buscarPerdida = SalidasPerdidas::where('id_entrada','=',$id->id_entrada)->first();
            if($buscarPerdida->cantidad === 0){
                $buscarPerdida->delete();
            }
            return redirect()->route('entradas.index')->with('alert','Se ha eliminado el resgistro de la existencia con éxito.');
            
        }else {
            // "Tiene mas entradas, no puede eliminar el producto";
            $id->delete();
            $buscarPerdida = SalidasPerdidas::where('id_entrada','=',$id->id_entrada)->first();
            if($buscarPerdida->cantidad === 0){
                $buscarPerdida->delete();
            }
            return redirect()->route('entradas.index')->with('alert','Se ha eliminado el resgistro de la existencia con éxito.');
        }

    }

    public function export(){
        return Excel::download(new EntradasExport, 'Productos_existencias.xlsx');
    }
}
