<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\Proveedor;
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

class ProductosController extends Controller
{
    public function index(){
        $productos = Productos::leftjoin('categorias', 'productos.id_categoria', '=', 'categorias.id_categoria')
        ->leftjoin('proveedor', 'productos.id_proveedor', '=', 'proveedor.id_proveedor')
        ->select('productos.*', 'categorias.nombre_categoria as categoria', 'proveedor.nombre_proveedor as nombre_proveedor')->orderBy('id_producto','desc')->paginate(25);
        $categorias = Categorias::all();
        return view('productos.inde', compact('productos', 'categorias'));
    }
    public function create(){
        $categorias = Categorias::all();
        $proveedores = Proveedor::all();

        return view('productos.crear', ["categorias"=>$categorias, "proveedores"=>$proveedores]);
    }

    public function store(Request $request){

        $request->validate([
            'select_categoria' => 'required',
            'select_proveedor' => 'required',
            'nombre_producto' => 'required|max:150',
            'detalles_producto' => 'required|max:250'
        ]);

        $categorias = Categorias::where('nombre_categoria', '=', limpiar_cadena($request->select_categoria))->first();
        $proveedores = Proveedor::where('nombre_proveedor', '=', limpiar_cadena($request->select_proveedor))->first();

        $nombreProducto = Productos::where('nombre_producto','=',limpiar_cadena($request->nombre_producto))->get();
        if(count($nombreProducto)>0){
            return redirect()->route('productos.index')->with('alert','El nombre ya esta registrado en un producto exitente.');
        }

        $productoNuevo = new Productos();
        $productoNuevo->nombre_producto = limpiar_cadena($request->nombre_producto);
        $productoNuevo->detalles_producto = limpiar_cadena($request->detalles_producto);
        $productoNuevo->id_categoria = $categorias->id_categoria;
        $productoNuevo->id_proveedor = $proveedores->id_proveedor;
        $productoNuevo->save();

        return redirect()->route('productos.index')->with('alert','Se ha agregado el producto con éxito.');
    }

    public function edit(Productos $id){

        $proveedor = Proveedor::where('id_proveedor','=',$id->id_proveedor)->first();
        $cat = Categorias::where('id_categoria','=',$id->id_categoria)->first();

        $categorias = Categorias::all();
        $proveedores = Proveedor::all();
        // return $cat->nombre_categoria;
        return view('productos.actualizar', ["categorias"=>$categorias, "proveedores"=>$proveedores, "id"=>$id, "pro"=>$proveedor, "cat"=>$cat]);
        // return view('productos.actualizar', ["categorias"=>$categorias, "proveedores"=>$proveedores, "id"=>$id]);
    }

    public function update(Request $request,Productos $id){
        $request->validate([
            'select_categoria' => 'required',
            'select_proveedor' => 'required',
            'nombre_producto' => 'required|max:150',
            'detalles_producto' => 'required|max:250'
        ]);

        $id->nombre_producto = limpiar_cadena($request->nombre_producto);
        $id->detalles_producto = limpiar_cadena($request->detalles_producto);
        $id->id_categoria = limpiar_cadena($request->select_categoria);
        $id->id_proveedor = limpiar_cadena($request->select_proveedor);
        $id->save();
        return redirect()->route('productos.index')->with('alert','Se ha actualizado el producto con éxito.');
    }

    public function destroy(Productos $id){
        $id->delete();
        return redirect()->route('productos.index')->with('alert','Se ha eliminado el producto con éxito.');
    }

    public function export(){
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }
}
