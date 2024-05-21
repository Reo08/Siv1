<?php

namespace App\Http\Controllers;

use App\Exports\FacturasExport;
use App\Exports\VentasExport;
use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Entradas;
use App\Models\FacturasClientes;
use App\Models\Ganancias;
use App\Models\PagosFacturas;
use App\Models\Productos;
use App\Models\Proveedor;
use App\Models\SalidasPerdidasCredito;
use App\Models\SalidasVentas;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $facturas = FacturasClientes::leftjoin('clientes', 'facturas_clientes.nit_cedula','=','clientes.nit_cedula')
        ->select('facturas_clientes.*','clientes.*')->distinct()->orderBy('id_factura_cliente','desc')->paginate(20);
        // $ventas = SalidasVentas::leftjoin('productos','salidas_ventas.referencia','=','productos.referencia')
        // ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
        // ->leftjoin('usuarios','salidas_ventas.id_usuario','=','usuarios.id_usuario')
        // ->leftjoin('clientes','salidas_ventas.nit_cedula','=','clientes.nit_cedula')
        // ->select('salidas_ventas.*','clientes.*', 'productos.*','categorias.*','usuarios.nombre as nombre_usuario')->distinct()->orderBy('id_salida_venta', 'desc')->paginate(20);
        $clientes = Clientes::all();
        return view('ventas.inde',compact('facturas','clientes'));
        // return $facturas;
    }
    public function create(){
        $clientes =  Clientes::all();
        // $categorias = Categorias::all();
        // $entradas = Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')->select('entradas.*','productos.*')->distinct()->get();
        return view('ventas.crear', compact('clientes'));
    }

    public function store(Request $request){
        $request->validate([
            "id_factura" => "required",
            "fecha_factura" => "required",
            "selec_cliente" => "required",
        ]);
        $verificarFactura = FacturasClientes::where('id_factura_cliente','=', limpiar_cadena($request->id_factura))->get();
        if(count($verificarFactura)>0){
            return redirect()->route('ventas.create')->with('alert','Ya existe una factura con ese ID.');
        }
        $verficarFacturaPerdida = SalidasPerdidasCredito::where('id_factura_cliente','=',$request->id_factura)->get();
        if(count($verficarFacturaPerdida)>0){
            return redirect()->route('ventas.create')->with('alert','Ya existe una factura con ese ID en la sección Pérdidas por falta de pago.');
        }

        if($request->factura_electronica === "no"){

            $nuevaFactura = new FacturasClientes();
            $nuevaFactura->id_factura_cliente = limpiar_cadena($request->id_factura);
            $nuevaFactura->nit_cedula = limpiar_cadena(intval($request->selec_cliente));
            $nuevaFactura->id_usuario = Auth::user()->id_usuario;
            $nuevaFactura->fecha_factura = limpiar_cadena($request->fecha_factura);
            $nuevaFactura->save();

            $nuevaGanancia = new Ganancias();
            $nuevaGanancia->id_factura_cliente = limpiar_cadena($request->id_factura);
            $nuevaGanancia->total_ganancia = 0;
            $nuevaGanancia->save();
    
            return redirect()->route('ventas.index')->with('alert','Se ha agregado la factura con exito.');
        }else if($request->factura_electronica === "si"){
            $verificarFacturaElectronica = FacturasClientes::where('factura_electronica','=',$request->num_factura_electronica)->get();
            if(count($verificarFacturaElectronica)>0){
                return redirect()->route('ventas.create')->with('alert','Ese numero de factura electronica ya esta registrado.');
            }
            $nuevaFactura = new FacturasClientes();
            $nuevaFactura->id_factura_cliente = limpiar_cadena($request->id_factura);
            $nuevaFactura->nit_cedula = limpiar_cadena(intval($request->selec_cliente));
            $nuevaFactura->id_usuario = Auth::user()->id_usuario;
            $nuevaFactura->fecha_factura = limpiar_cadena($request->fecha_factura);
            $nuevaFactura->factura_electronica = limpiar_cadena($request->num_factura_electronica);
            $nuevaFactura->save();

            $nuevaGanancia = new Ganancias();
            $nuevaGanancia->id_factura_cliente = limpiar_cadena($request->id_factura);
            $nuevaGanancia->total_ganancia = 0;
            $nuevaGanancia->save();

            return redirect()->route('ventas.index')->with('alert','Se ha agregado la factura con exito.');
        }

    }
    public function editAbonarFactura(FacturasClientes $id_factura){
        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();
        return view('ventas.editarAbonarFactura',compact('id_factura','cliente'));
    }
    public function updateAbonarFactura(Request $request, FacturasClientes $id_factura){
        $request->validate([
            "pagado" => "required|numeric",
            "fecha_pago" => "required"
        ]);

        if(limpiar_cadena($request->pagado)>$id_factura->debe){
            return redirect()->route('ventas.editAbonarFactura', compact('id_factura'))->with('alert','Error, la cantidad que esta ingresando es mayor de lo que debe.');
        }
        if($request->pagado <= 0){
            return redirect()->route('ventas.editAbonarFactura', compact('id_factura'))->with('alert','Error, ingrese una cantidad para generar el abono/pago de la factura.');
        }

        if($request->pagado >0){
            $id_factura->pagado === null ? $id_factura->pagado = $request->pagado : $id_factura->pagado += $request->pagado;
            $id_factura->debe -=$request->pagado;
            $id_factura->save();

            $nuevoPagoFactura = new PagosFacturas();
            $nuevoPagoFactura->id_factura_cliente = $id_factura->id_factura_cliente;
            $nuevoPagoFactura->nit_cedula = $id_factura->nit_cedula;
            $nuevoPagoFactura->fecha_pago = $request->fecha_pago;
            $nuevoPagoFactura->monto = $request->pagado;
            $nuevoPagoFactura->save();

            $Ganancia = Ganancias::where('id_factura_cliente','=', $id_factura->id_factura_cliente)->first();
            $Ganancia->total_ganancia = $id_factura->pagado;
            $Ganancia->save();
  
    
            return redirect()->route('ventas.index')->with('alert','Se ha agregado el pago con éxito.');
        }

    }

    // PAGOS
    public function indexPagos(FacturasClientes $id_factura){

        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();

        $pagos = PagosFacturas::where('id_factura_cliente','=',$id_factura->id_factura_cliente)->where('nit_cedula','=',$id_factura->nit_cedula)->orderBy('id_pago_factura','desc')->paginate(25);

        return view('ventas.verPagos', compact('cliente','id_factura','pagos'));
    }
    public function destroyPago(PagosFacturas $id_pago){
        $factura = FacturasClientes::where('id_factura_cliente','=',$id_pago->id_factura_cliente)->first();
        $factura->pagado -= $id_pago->monto;
        $factura->debe += $id_pago->monto;
        $factura->save();

        $Ganancia = Ganancias::where('id_factura_cliente','=', $id_pago->id_factura_cliente)->first();
        $Ganancia->total_ganancia -= $id_pago->monto;
        $Ganancia->save();

        $id_pago->delete();
        return redirect()->route('ventas.index')->with('alert','Se ha eliminado el pago con éxito.');
    }
    // Fin PAGOS
    public function editFechaFactura(FacturasClientes $id_factura){
        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();
        return view('ventas.editarFechaLimite', compact('id_factura','cliente'));
    }
    public function updateFechaFactura(Request $request,FacturasClientes $id_factura){
        $request->validate([
            "fecha_limite_pago" => "required"
        ]);

        $id_factura->fecha_limite_pago = $request->fecha_limite_pago;
        $id_factura->save();
        return redirect()->route('ventas.index')->with('alert','Se ha modificado la fecha de pago con éxito.');
    }

    public function destroy(FacturasClientes $id_factura){
        $id_factura->delete();
        return redirect()->route('ventas.index')->with('alert','Se ha eliminado la factura con éxito.');
    }

    public function createFacturaPdf(FacturasClientes $id_factura){
        return view('ventas.formFacturaCrear',compact('id_factura'));
    }
    public function storeFacturaPdf(Request $request, FacturasClientes $id_factura){

        $request->validate([
            "razon_social" => "required|max:50",
            "nit_cedula" => "required|numeric",
            "direccion" => "required|max:50",
            "celular" => "required|numeric",
            "codigo_ciuu" => "required|numeric"
        ]);

        $facturaProductos = SalidasVentas::leftjoin('entradas','salidas_ventas.id_entrada','=','entradas.id_entrada')
        ->leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->select('salidas_ventas.*','productos.nombre_producto', 'productos.referencia')->where('salidas_ventas.id_factura_cliente','=',$id_factura->id_factura_cliente)->distinct()->get();
        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();
        $fecha = date("Y-m-d");

        $datos = [
            "cliente" => $cliente,
            "id_factura" => $id_factura,
            "facturaProductos" => $facturaProductos,
            "fecha" => $fecha,
            "razon_social" => $request->razon_social,
            "nit_cedula" => $request->nit_cedula,
            "direccion" => $request->direccion,
            "celular" => $request->celular,
            "codigo_ciuu" => $request->codigo_ciuu
        ];
        $pdf = Pdf::loadView('ventas.facturaPdf', $datos);
        return $pdf->stream();
    }
    public function facturaPdf(FacturasClientes $id_factura){

        $facturaProductos = SalidasVentas::leftjoin('entradas','salidas_ventas.id_entrada','=','entradas.id_entrada')
        ->leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->select('salidas_ventas.*','productos.nombre_producto', 'productos.referencia')->where('salidas_ventas.id_factura_cliente','=',$id_factura->id_factura_cliente)->distinct()->get();
        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();
        $fecha = date("Y-m-d");

        $datos = [
            "cliente" => $cliente,
            "id_factura" => $id_factura,
            "facturaProductos" => $facturaProductos,
            "fecha" => $fecha
        ];

        $pdf = Pdf::loadView('ventas.facturaPdf', $datos);
        return $pdf->stream();

        // $pdf = Pdf::loadView('ventas.facturaPdf', $datos);
        // return $pdf->download('Factura.pdf');
        // return view('ventas.facturaPdf',compact('cliente','id_factura','facturaProductos','fecha'));
    }


    // Productos de factura
    public function indexProductos(FacturasClientes $id_factura){
        $facturaProductos = SalidasVentas::leftjoin('entradas','salidas_ventas.id_entrada','=','entradas.id_entrada')
        ->leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->select('salidas_ventas.*','productos.nombre_producto', 'productos.referencia')->where('salidas_ventas.id_factura_cliente','=',$id_factura->id_factura_cliente)->distinct()->get();
        $cantidadTotalEntregadas = 0;

        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();

        $pagosFactura = PagosFacturas::where('id_factura_cliente','=',$id_factura->id_factura_cliente)->get();
        $hayPagos = "";
        if(count($pagosFactura)>0){
            $hayPagos = "si";
        }else {
            $hayPagos = "no";
        }

        foreach ($facturaProductos as $producto) {
            $cantidadTotalEntregadas += $producto->cantidad_entregada;
        }

        return view('ventas.productos', compact('id_factura','facturaProductos','cliente','hayPagos','cantidadTotalEntregadas'));
    }
    public function createProducto(FacturasClientes $id_factura){

        $entradas = Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->select('entradas.*','productos.*')->distinct()->get();

        $categorias = Categorias::all();

        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();
        return view('ventas.productosAgregar', compact('id_factura','cliente','categorias'));
    }

    public function categoriasSelect($id){
        $entradas = Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->select('entradas.*','productos.*')->where('productos.id_categoria','=',$id)->distinct()->get();
        return json_encode($entradas);
    }
    public function productosExistencia($id){
        // $productos = Productos::where('id_categoria','=', $id)->get();
        $entrada = Entradas::where('id_entrada','=',$id)->first();
        // return response()->json($productos);
        return json_encode($entrada);
    }
    public function pedirFacturaElectronica($id){
        $factura = FacturasClientes::where('id_factura_cliente','=',$id)->first();
        $tieneFacturaElectronica = "";

        if($factura->factura_electronica === null){
            $tieneFacturaElectronica = "no";
        }else {
            $tieneFacturaElectronica = "si";

        }
        return json_encode($tieneFacturaElectronica);
    }
    public function enviarRetencion(Request $request, $id){
        // Aqui se agregaro el valor del porcentaje de retencion y el valor total sin iva(por si agregar el iva)
        $factura = FacturasClientes::where('id_factura_cliente','=',$id)->first();
        $factura->porcentaje_retencion += $request->retencion * $request->cantidad;
        $factura->valor_total_sin_iva += ($request->precioVentaSinIva * $request->cantidad) + ($request->retencion * $request->cantidad);
        $factura->save();

        return json_encode($factura);

    }
    public function storeProducto(Request $request,FacturasClientes $id_factura){
        $request->validate([
            "fecha_solicitud" => "required",
            "fecha_entrega" => "required",
            "sec_existencia" => "required",
            "cantidad_orden" => "required|numeric",
            "sec_estado_pedido" => "required",
            "cantidad_elaborada" => "required|numeric",
            "cantidad_entregada" => "required|numeric",
            "n_descuento_recargo" => "required|numeric",
            "aplica_iva" => "required",
            "valor_unidad" => "required|numeric",
            "valor_total" => "required|numeric",
        ]);
        if(intval($request->cantidad_orden)<intval($request->cantidad_entregada)){
            return redirect()->route('ventas.createProducto', compact('id_factura'))->with('alert','La cantidad de la entrega es mayor a la cantidad de la orden.');
        }
        
        $verificarProducto = SalidasVentas::where("id_factura_cliente",'=', $id_factura->id_factura_cliente)->where('id_entrada','=', limpiar_cadena(intval($request->sec_existencia)))->get();
        if(count($verificarProducto)>0){
            return redirect()->route('ventas.createProducto', compact('id_factura'))->with('alert','El producto ya esta agregado en la factura.');
        }
        
        $nuevoProductoFactura = new SalidasVentas();
        $nuevoProductoFactura->id_factura_cliente = $id_factura->id_factura_cliente;
        $nuevoProductoFactura->id_entrada = intval($request->sec_existencia);
        $nuevoProductoFactura->fecha_solicitud = limpiar_cadena($request->fecha_solicitud);
        $nuevoProductoFactura->fecha_entrega = limpiar_cadena($request->fecha_entrega);
        $nuevoProductoFactura->cantidad_orden = limpiar_cadena($request->cantidad_orden);
        $nuevoProductoFactura->estado_pedido = limpiar_cadena($request->sec_estado_pedido);
        $nuevoProductoFactura->cantidad_elaborada = limpiar_cadena(intval($request->cantidad_elaborada));
        $nuevoProductoFactura->cantidad_entregada = limpiar_cadena(intval($request->cantidad_entregada));
        $nuevoProductoFactura->nit_cedula = limpiar_cadena(intval($id_factura->nit_cedula));
        $nuevoProductoFactura->id_usuario = Auth::user()->id_usuario;
        $nuevoProductoFactura->aplica_iva = limpiar_cadena($request->aplica_iva);
        $nuevoProductoFactura->descuento_o_recargo = limpiar_cadena(intval($request->n_descuento_recargo));
        $nuevoProductoFactura->valor_unidad = limpiar_cadena($request->valor_unidad);
        $nuevoProductoFactura->valor_total = limpiar_cadena($request->valor_total);
        $nuevoProductoFactura->save();

        $facturaProductos = SalidasVentas::where('id_factura_cliente','=',$id_factura->id_factura_cliente)->get();
        $total_venta = 0;
        foreach ($facturaProductos as $producto) {
            $total_venta += $producto->valor_total;
        }
        $id_factura->valor_total = $total_venta;
        $id_factura->debe = $total_venta;
        $id_factura->save();

        if(intval($request->cantidad_entregada)>0){
            $entrada = Entradas::where('id_entrada','=',intval($request->sec_existencia))->first();
            $entrada->cantidad_entrada -= intval($request->cantidad_entregada);
            $entrada->save();
        }

        return redirect()->route('ventas.indexProductos', compact('id_factura'))->with('alert','Se ha agregado el producto a la factura con éxito.');
    }

    public function editProducto(FacturasClientes $id_factura, SalidasVentas $id_salida_venta){

        $entradaProducto = Entradas::where('id_entrada','=', $id_salida_venta->id_entrada)->first();

        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();
        // return $id_salida_venta;
        return view('ventas.productosEditar', compact('id_factura','cliente','id_salida_venta','entradaProducto'));
    }
    public function updateProducto(Request $request,FacturasClientes $id_factura, SalidasVentas $id_salida_venta){
        $request->validate([
            "fecha_solicitud" => "required",
            "fecha_entrega" => "required",
            "sec_estado_pedido" => "required",
            "cantidad_elaborada" => "required|numeric",
            "cantidad_entregada" => "required|numeric"
        ]);
        if(intval($request->cantidad_entregada)>$id_salida_venta->cantidad_orden){
            return redirect()->route('ventas.indexProductos', compact('id_factura'))->with('alert','Error, la cantidad de entrega que esta ingresando es mayor a la cantidad de orden.');
        }

        if(intval($request->cantidad_entregada)>$id_salida_venta->cantidad_entregada){
            // Editando el producto para agregar mas cantidad entregada, la diferencia se resta en la existencia de entrada
            $diferencia = intval($request->cantidad_entregada) -$id_salida_venta->cantidad_entregada;
            $entrada = Entradas::where('id_entrada','=',$id_salida_venta->id_entrada)->first();
            $entrada->cantidad_entrada -= $diferencia;
            $entrada->save();

        }else if(intval($request->cantidad_entregada)<$id_salida_venta->cantidad_entregada){
            // Esitando el producto para disminuir la cantidad entregada, la diferencia se suma en la existencia de la entrada
            $diferencia = $id_salida_venta->cantidad_entregada -intval($request->cantidad_entregada);
            $entrada = Entradas::where('id_entrada','=',$id_salida_venta->id_entrada)->first();
            $entrada->cantidad_entrada += $diferencia;
            $entrada->save();
        }

        $id_salida_venta->fecha_solicitud = limpiar_cadena($request->fecha_solicitud);
        $id_salida_venta->fecha_entrega = limpiar_cadena($request->fecha_entrega);
        $id_salida_venta->estado_pedido = limpiar_cadena($request->sec_estado_pedido);
        $id_salida_venta->cantidad_elaborada = limpiar_cadena(intval($request->cantidad_elaborada));
        $id_salida_venta->cantidad_entregada = limpiar_cadena(intval($request->cantidad_entregada));
        $id_salida_venta->save();

        return redirect()->route('ventas.indexProductos', compact('id_factura'))->with('alert','Se ha actualizado el producto con éxito.');
    }
    public function destroyProducto(FacturasClientes $id_factura, SalidasVentas $id_salida_venta){
        $id_factura->valor_total -= $id_salida_venta->valor_total;
        $id_factura->debe -= $id_salida_venta->valor_total;
        $id_factura->porcentaje_retencion = null;
        $id_factura->valor_total_sin_iva = null;
        $id_factura->save();

        $entrada = Entradas::where('id_entrada','=',$id_salida_venta->id_entrada)->first();
        $entrada->cantidad_entrada += $id_salida_venta->cantidad_entregada;
        $entrada->save();

        $id_salida_venta->delete();

        return redirect()->route('ventas.indexProductos', compact('id_factura'))->with('alert','Se ha eliminado el producto de venta con éxito.');
    }


    public function exportFacturas(){
        return Excel::download( new FacturasExport, 'Facturas.xlsx');
    }
}
