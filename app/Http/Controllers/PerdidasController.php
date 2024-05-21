<?php

namespace App\Http\Controllers;

use App\Exports\PerdidasExport;
use App\Exports\PerdidasPorPagoExport;
use App\Models\Categorias;
use App\Models\Entradas;
use App\Models\FacturasClientes;
use App\Models\Perdidas;
use App\Models\PerdidasCredito;
use App\Models\Productos;
use App\Models\SalidasPerdidas;
use App\Models\SalidasPerdidasCredito;
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

class PerdidasController extends Controller
{
    public function index(){
        return view('perdidas.inde');
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
    


    // Perdidas por daño
    public function indexPorDano(){
        // $perdidas = SalidasPerdidas::leftjoin('entradas','salidas_perdidas.id_entrada','=','entradas.id_entrada')
        // ->leftjoin('productos','entradas.referencia','=','productos.referencia')
        // ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        // ->select('salidas_perdidas.*','entradas.*','productos.*','categorias.*')->get();
        $perdidas = SalidasPerdidas::orderBy('id_salida_perdida','desc')->paginate(20);
        return view('perdidas.porDano',compact('perdidas'));
    }
    public function editPorDano(SalidasPerdidas $id_perdida){
        $entrada = Entradas::where('id_entrada','=',$id_perdida->id_entrada)->first();

        $verificarEntrada = Entradas::where('id_entrada','=',$id_perdida->id_entrada)->get();
        if(count($verificarEntrada)>0){
            $producto = Productos::where('referencia','=',$entrada->referencia)->first();
            return view('perdidas.porDanoEditar',compact('id_perdida','producto'));
        }else {
            return redirect()->route('perdidas.porDano')->with('alert','No se puede editar porque la existencia fue eliminada.');
        }

    }

    public function updatePorDano(Request $request, SalidasPerdidas $id_perdida){
        $request->validate([
            "sec_operacion" => "required",
            "cantidad_perdida" => "required|numeric"
        ]);
        if($request->sec_operacion == 1){
            // SUMA
            // Si suma aqui en perdida entonces resta en entradas
            // $importe->cantidad_importe = $importe->cantidad_importe + intval(limpiar_cadena($request->cantidad_entrada));
            // $importe->save();

            $id_perdida->cantidad = $id_perdida->cantidad + intval(limpiar_cadena($request->cantidad_perdida));
            $id_perdida->save();
            
            $entrada = Entradas::where('id_entrada','=', $id_perdida->id_entrada)->first();
            $entrada->cantidad_entrada -= intval(limpiar_cadena($request->cantidad_perdida));
            $entrada->save();

            // Tabla de perdidas totales
            $perdida = Perdidas::where('id_salida_perdida','=',$id_perdida->id_salida_perdida)->first();
            $perdida->total_perdida = $entrada->costo_inversion * $id_perdida->cantidad;
            $perdida->save();


            return redirect()->route('perdidas.porDano')->with('alert','Pérdidas agregadas con éxito.');

        }else if($request->sec_operacion == 0){
            if($request->cantidad_perdida > $id_perdida->cantidad){
                return redirect()->route('perdidas.porDanoEditar',$id_perdida->id_salida_perdida)->with('alert','Error, la cantidad que quiere quitar es mayor a la cantidad que tiene en pérdidas.');
            }else {
                // RESTA
                // Si resta aqui en perdida entonces suma en entradas
                $id_perdida->cantidad = $id_perdida->cantidad - intval(limpiar_cadena($request->cantidad_perdida));
                $id_perdida->save();

                $entrada = Entradas::where('id_entrada','=', $id_perdida->id_entrada)->first();
                $entrada->cantidad_entrada += intval(limpiar_cadena($request->cantidad_perdida));
                $entrada->save();

                // Tabla de perdidas totales
                $perdida = Perdidas::where('id_salida_perdida','=',$id_perdida->id_salida_perdida)->first();
                $perdida->total_perdida = $entrada->costo_inversion * $id_perdida->cantidad;
                $perdida->save();

                // $importe->cantidad_importe = $importe->cantidad_importe - intval(limpiar_cadena($request->cantidad_entrada));
                // $importe->save();

                return redirect()->route('perdidas.porDano')->with('alert','Perdidas eliminadas con éxito.');
            }
        }

    }
    public function destroyPorDano(SalidasPerdidas $id_perdida){
        $buscarEntrada = Entradas::where('id_entrada','=', $id_perdida->id_entrada)->get();
        if(count($buscarEntrada)>0){
            $entrada = Entradas::where('id_entrada','=', $id_perdida->id_entrada)->first();
            if($id_perdida->cantidad>0){
                $entrada->cantidad_entrada += $id_perdida->cantidad;
                $entrada->save();
            }

        }
        $id_perdida->delete();
        return redirect()->route('perdidas.porDano')->with('alert','Se ha eliminado la pérdida con éxito.');
    }

    // Perdidas por pago
    public function indexPorPago(){
        $perdidasFacturas = SalidasPerdidasCredito::leftjoin('clientes','salidas_perdidas_credito.nit_cedula','=','clientes.nit_cedula')->orderBy('id_salida_perdida_credito', 'desc')->paginate(20);
        return view('perdidas.porPago',compact('perdidasFacturas'));
    }
    public function createPorPago(){
        return view('perdidas.porPagoCrear');
    }
    public function storePorPago(Request $request){
        $request->validate([
            "id_factura" => "required|numeric"
        ]);

        $buscarFactura = FacturasClientes::where('id_factura_cliente','=',limpiar_cadena($request->id_factura))->get();
        if(count($buscarFactura) === 0){
            return redirect()->route('perdidas.porPagoCreate')->with('alert','No exite una factura con ese ID.');
        }

        $nuevaFacturaPerdida =  new SalidasPerdidasCredito(); 
        $nuevaFacturaPerdida->id_salida_perdida_credito = $buscarFactura[0]->id_factura_cliente;
        $nuevaFacturaPerdida->id_factura_cliente = $buscarFactura[0]->id_factura_cliente;
        $nuevaFacturaPerdida->nit_cedula = $buscarFactura[0]->nit_cedula;
        $nuevaFacturaPerdida->id_usuario = $buscarFactura[0]->id_usuario;
        $nuevaFacturaPerdida->valor_total = $buscarFactura[0]->valor_total;
        $nuevaFacturaPerdida->debe = $buscarFactura[0]->debe;
        $nuevaFacturaPerdida->pagado = $buscarFactura[0]->pagado === null ? 0 : $buscarFactura[0]->pagado;
        $nuevaFacturaPerdida->fecha_factura = $buscarFactura[0]->fecha_factura;
        $nuevaFacturaPerdida->fecha_limite_pago = $buscarFactura[0]->fecha_limite_pago === null ? "Sin fecha" : $buscarFactura[0]->fecha_limite_pago;
        $nuevaFacturaPerdida->factura_electronica = $buscarFactura[0]->factura_electronica === null ? "Sin factura" : $buscarFactura[0]->factura_electronica;
        $nuevaFacturaPerdida->save();

        $nuevaPerdidaCredito = new PerdidasCredito();
        $nuevaPerdidaCredito->id_salida_perdida_credito = $buscarFactura[0]->id_factura_cliente;
        $nuevaPerdidaCredito->total_debe = $nuevaFacturaPerdida->debe;
        $nuevaPerdidaCredito->save();

        return redirect()->route('perdidas.porPago')->with('alert','Se ha agregado la factura a pérdidas con éxito.');
    }
    public function destroyPorPago(SalidasPerdidasCredito $id_porPago){
        $id_porPago->delete();
        return redirect()->route('perdidas.porPago')->with('alert','Se ha eliminado la pérdida con éxito.');
    }

    public function exportPorDano(){
        return Excel::download(new PerdidasExport, 'perdidas_por_daño.xlsx');
    }
    public function exportPorPago(){
        return Excel::download(new PerdidasPorPagoExport, 'Perdidas_por_pago.xlsx');
    }
}
