<?php

namespace App\Http\Controllers;

use App\Exports\CategoriasExport;
use App\Models\Categorias;
use App\Models\Importes;
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

class CategoriasController extends Controller
{
    public function index() {
        $categorias = Categorias::orderBy('id_categoria', 'desc')->paginate(25);
        return view('categorias.inde', ['categorias'=> $categorias]);
    }

    public function create() {
        return view('categorias.crear');
    }

    public function store(Request $request){

        $request->validate([
            "nombre_categoria" => "required|max:120"
        ]);
        
        $nombreCategoria = Categorias::where('nombre_categoria','=',strtolower(limpiar_cadena($request->nombre_categoria)))->get();
        if(count($nombreCategoria)>0){
            return redirect()->route('categorias.index')->with('alert','La categoria ya existe.');
        }

        $nuevaCategoria = new Categorias();
        $nuevaCategoria->nombre_categoria = $request->nombre_categoria;
        $nuevaCategoria->save();
        return redirect()->route('categorias.index')->with('alert','Se ha agregado la categoria con exito.');

    }

    public function edit(Categorias $id){
        return view('categorias.actualizar', compact('id'));
    }
    public function update(Request $request, Categorias $id){

        // $importes = Importes::where('id_categoria','=',$id->id_categoria)->get();

        $request->validate([
            'nombre_categoria'=> 'required|max:120'
        ]);

        $id->nombre_categoria = limpiar_cadena($request->nombre_categoria);
        $id->save();

        // foreach ($importes as $importe) {
        //     $importe->nombre_categoria = $id->nombre_categoria;
        //     $importe->save();
        // }

        return redirect()->route('categorias.index')->with('alert','Se ha actualizado la categoria con éxito.');
    }
    public function destroy(Categorias $id){
        $id->delete();
        return redirect()->route('categorias.index')->with('alert','Se ha eliminado la categoria con éxito.');
    }

    public function export(){
        return Excel::download(new CategoriasExport, 'categorias.xlsx');
    }
}
