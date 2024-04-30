<?php

namespace App\Http\Controllers;

use App\Exports\VentasExport;
use App\Models\Categorias;
use App\Models\Entradas;
use App\Models\Ganancias;
use App\Models\Productos;
use App\Models\Proveedor;
use App\Models\SalidasVentas;
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

class VentasController extends Controller
{
    public function index(){
        $ventas = SalidasVentas::leftjoin('productos','salidas_ventas.id_producto','=','productos.id_producto')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->leftjoin('proveedor','productos.id_proveedor','=','proveedor.id_proveedor')
        ->leftjoin('usuarios','salidas_ventas.identificacion','=','usuarios.identificacion')
        ->select('salidas_ventas.*','salidas_ventas.created_at as created','salidas_ventas.updated_at as updated', 'productos.*', 'categorias.*','proveedor.*','usuarios.nombre as nombre_usuario')->distinct()->orderBy('id_salida_venta', 'desc')->paginate(20);
        $categorias = Categorias::all();
        return view('ventas.inde',compact('ventas','categorias'));
        // return view('ventas.inde');
    }
    public function create(){
        $categorias = Categorias::all();
        return view('ventas.crear', compact('categorias'));
    }
    public function productosCategoria($id){
        $productos = Productos::where('id_categoria','=', $id)->get();
        // return response()->json($productos);
        return json_encode($productos);
    }
    public function proveedoresSelect($id){
        $buscarProducto = Productos::where('id_producto','=', $id)->first();
        $proveedor = Proveedor::where('id_proveedor','=',$buscarProducto->id_proveedor)->get(); 
        $buscarEntrada = Entradas::where('id_producto','=',$id)->first();
        $res = [
            $proveedor,
            $buscarEntrada->precio_venta_entrada,
            $buscarEntrada->cantidad_entrada
        ];
        return json_encode($res);
    }

    public function store(Request $request){
        $entrada = Entradas::where('id_producto','=',intval(limpiar_cadena($request->sec_producto)))->get();

        $request->validate([
            "sec_categoria" => "required",
            "sec_producto" => "required",
            "fecha_venta" => "required",
            "precio_venta" => "required|numeric",
            "cantidad_venta" => "required|numeric"
        ]);

        if(count($entrada) != 0){//Esta validacion es por que si va a hacer una venta y no hay una existencia en entrada.
            $entrada = Entradas::where('id_producto','=',intval(limpiar_cadena($request->sec_producto)))->first();
            if($request->cantidad_venta > $entrada->cantidad_entrada){
                return redirect()->route('ventas.index')->with('alert','La cantidad que quiere vender es mayor a la cantidad que tiene en existencias.');
            }
            $nuevaVenta = new SalidasVentas();
            $nuevaVenta->id_producto = intval(limpiar_cadena($request->sec_producto));
            $nuevaVenta->cantidad = limpiar_cadena($request->cantidad_venta);
            $nuevaVenta->precio_venta = limpiar_cadena($request->precio_venta);
            $nuevaVenta->precio_compra = $entrada->precio_compra_entrada;
            $nuevaVenta->fecha_venta = limpiar_cadena($request->fecha_venta);
            $nuevaVenta->identificacion = Auth::user()->identificacion;//IMPORTANTE: Poner la identificacion de la sesion del usuario
            $nuevaVenta->save();

            $entrada->cantidad_entrada = $entrada->cantidad_entrada - intval(limpiar_cadena($request->cantidad_venta));
            $entrada->save();

            $nuevaGanancia = new Ganancias();
            $nuevaGanancia->id_salida_venta = $nuevaVenta->id_salida_venta;
            $nuevaGanancia->total_venta = limpiar_cadena($request->cantidad_venta) * limpiar_cadena($request->precio_venta);
            $nuevaGanancia->total_ganancia =  ($request->cantidad_venta * $request->precio_venta) - ($request->cantidad_venta * $entrada->precio_compra_entrada);
            $nuevaGanancia->save();
    
            return redirect()->route('ventas.index')->with('alert','Se ha agregado la venta con exito.');
        }else {
            return redirect()->route('ventas.index')->with("alert","No hay una existencia creada de este producto en Entradas.");
        }

    }


    public function destroy(SalidasVentas $id){
        $entradas = Entradas::where('id_producto','=',$id->id_producto)->first();
        $entradas->cantidad_entrada = $entradas->cantidad_entrada + $id->cantidad;
        $entradas->save();
        $id->delete();
        return redirect()->route('ventas.index');
    }


    public function export(){
        return Excel::download( new VentasExport, 'ventas.xlsx');
    }
}
