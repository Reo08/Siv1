<?php

namespace App\Http\Controllers;

use App\Exports\CategoriasExport;
use App\Models\Categorias;
use App\Models\Importes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoriasController extends Controller
{
    public function index() {
        $categorias = Categorias::orderBy('id_categoria', 'desc')->paginate(15);
        return view('categorias.inde', ['categorias'=> $categorias]);
    }

    public function create() {
        return view('categorias.crear');
    }

    public function store(Request $request){
        $nuevaCategoria = new Categorias();
        $nuevaCategoria->nombre_categoria = $request->nombre_categoria;
        $nuevaCategoria->save();
        return redirect()->route('categorias.index');
    }

    public function edit(Categorias $id){
        return view('categorias.actualizar', compact('id'));
    }
    public function update(Request $request, Categorias $id){

        $importes = Importes::where('id_categoria','=',$id->id_categoria)->get();

        $request->validate([
            'nombre_categoria'=> 'required|max:20'
        ]);

        $id->nombre_categoria = $request->nombre_categoria;
        $id->save();

        foreach ($importes as $importe) {
            $importe->nombre_categoria = $id->nombre_categoria;
            $importe->save();
        }

        return redirect()->route('categorias.index');
    }
    public function destroy(Categorias $id){
        $id->delete();
        return redirect()->route('categorias.index');
    }

    public function export(){
        return Excel::download(new CategoriasExport, 'categorias.xlsx');
    }
}
