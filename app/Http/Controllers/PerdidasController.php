<?php

namespace App\Http\Controllers;

use App\Exports\PerdidasExport;
use App\Models\Categorias;
use App\Models\Entradas;
use App\Models\Perdidas;
use App\Models\Productos;
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

class PerdidasController extends Controller
{
    public function index(){
        $perdidas = SalidasPerdidas::leftjoin('productos','salidas_perdidas.id_producto','=','productos.id_producto')
        ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        ->leftjoin('proveedor','productos.id_proveedor','=','proveedor.id_proveedor')
        ->leftjoin('usuarios','salidas_perdidas.identificacion','=','usuarios.identificacion')
        ->select('salidas_perdidas.*','salidas_perdidas.created_at as created','salidas_perdidas.updated_at as updated', 'productos.*', 'categorias.*','proveedor.*','usuarios.nombre as nombre_usuario')->distinct()->orderBy('id_salida_perdida', 'desc')->paginate(20);
        $categorias = Categorias::all();
        return view('perdidas.inde', compact('perdidas','categorias'));
    }
    public function create(){
        $categorias = Categorias::all();

        return view('perdidas.crear', compact('categorias'));
    }    
    public function productosCategoria($id){
        $productos = Productos::where('id_categoria','=', $id)->get();
        return json_encode($productos);
    }
    public function proveedoresSelect($id){
        $buscarEntrada = Entradas::where('id_producto','=',$id)->first();
        $res = [
            $buscarEntrada->precio_compra_entrada,
            $buscarEntrada->cantidad_entrada
        ];
        return json_encode($res);
    }
    
    public function store(Request $request){
        $entrada = Entradas::where('id_producto','=',intval(limpiar_cadena($request->sec_producto)))->get();

        $request->validate([
            "sec_categoria" => "required",
            "sec_producto" => "required",
            "fecha_perdida" => "required",
            "precio_compra" => "required|numeric",
            "cantidad_perdida" => "required|numeric"
        ]);

        if(count($entrada) != 0){//Esta validacion es por que si va a hacer una perdida y no hay una existencia en entrada.
            $entrada = Entradas::where('id_producto','=',intval($request->sec_producto))->first();
            if($request->cantidad_perdida > $entrada->cantidad_entrada){
                return redirect()->route('ventas.index')->with('alert','La cantidad que quiere registrar como pérdida es mayor a la cantidad que tiene en existencias');
            }
            $nuevaPerdida = new SalidasPerdidas();
            $nuevaPerdida->id_producto = intval($request->sec_producto);
            $nuevaPerdida->cantidad = limpiar_cadena($request->cantidad_perdida);
            $nuevaPerdida->precio_compra = limpiar_cadena($request->precio_compra);
            $nuevaPerdida->fecha_perdida = limpiar_cadena($request->fecha_perdida);
            $nuevaPerdida->identificacion = Auth::user()->identificacion;//IMPORTANTE: Poner la identificacion de la sesion del usuario
            $nuevaPerdida->save();

            $entrada->cantidad_entrada = $entrada->cantidad_entrada - $request->cantidad_perdida;
            $entrada->save();

            $perdida = new Perdidas();
            $perdida->id_salida_perdida = $nuevaPerdida->id_salida_perdida;
            $perdida->total_perdida = $request->cantidad_perdida * $request->precio_compra;
            $perdida->save();
    
            return redirect()->route('perdidas.index')->with('alert','Se ha agregado la pérdida con éxito.');
        }else {
            return redirect()->route('perdidas.index')->with("alert","No hay una existencia creada de este producto en Entradas.");
        }
    }

    public function destroy(SalidasPerdidas $id){
        $entradas = Entradas::where('id_producto','=',$id->id_producto)->first();
        $entradas->cantidad_entrada = $entradas->cantidad_entrada + $id->cantidad;
        $entradas->save();
        if($id->precio_compra != $entradas->precio_compra_entrada){
            return redirect()->route('perdidas.index')->with('alert','La venta no se puede eliminar, ya que el precio de compra es diferente al actual.');
        }
        $id->delete();
        return redirect()->route('perdidas.index')->with('alert','Se ha eliminado la perdida con éxito.');
    }

    public function export(){
        return Excel::download(new PerdidasExport, 'perdidas.xlsx');
    }
}
