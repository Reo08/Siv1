<?php

namespace App\Http\Controllers;

use App\Exports\VentasExport;
use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Entradas;
use App\Models\FacturasClientes;
use App\Models\Ganancias;
use App\Models\PagosFacturas;
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
            return redirect()->route('ventas.index')->with('alert','Ya existe una factura con ese ID.');
        }

        $nuevaFactura = new FacturasClientes();
        $nuevaFactura->id_factura_cliente = limpiar_cadena($request->id_factura);
        $nuevaFactura->nit_cedula = limpiar_cadena(intval($request->selec_cliente));
        $nuevaFactura->id_usuario = Auth::user()->id_usuario;
        $nuevaFactura->fecha_factura = limpiar_cadena($request->fecha_factura);
        $nuevaFactura->save();

        return redirect()->route('ventas.index')->with('alert','Se ha agregado la factura con exito.');

        // $entrada = Entradas::where('id_producto','=',intval(limpiar_cadena($request->sec_producto)))->get();

        // $request->validate([
        //     "sec_categoria" => "required",
        //     "sec_producto" => "required",
        //     "fecha_venta" => "required",
        //     "precio_venta" => "required|numeric",
        //     "cantidad_venta" => "required|numeric"
        // ]);

        // if(count($entrada) != 0){//Esta validacion es por que si va a hacer una venta y no hay una existencia en entrada.
        //     $entrada = Entradas::where('id_producto','=',intval(limpiar_cadena($request->sec_producto)))->first();
        //     if($request->cantidad_venta > $entrada->cantidad_entrada){
        //         return redirect()->route('ventas.index')->with('alert','La cantidad que quiere vender es mayor a la cantidad que tiene en existencias.');
        //     }
        //     $nuevaVenta = new SalidasVentas();
        //     $nuevaVenta->id_producto = intval(limpiar_cadena($request->sec_producto));
        //     $nuevaVenta->cantidad = limpiar_cadena($request->cantidad_venta);
        //     $nuevaVenta->precio_venta = limpiar_cadena($request->precio_venta);
        //     $nuevaVenta->precio_compra = $entrada->precio_compra_entrada;
        //     $nuevaVenta->fecha_venta = limpiar_cadena($request->fecha_venta);
        //     $nuevaVenta->identificacion = Auth::user()->identificacion;//IMPORTANTE: Poner la identificacion de la sesion del usuario
        //     $nuevaVenta->save();

        //     $entrada->cantidad_entrada = $entrada->cantidad_entrada - intval(limpiar_cadena($request->cantidad_venta));
        //     $entrada->save();

        //     $nuevaGanancia = new Ganancias();
        //     $nuevaGanancia->id_salida_venta = $nuevaVenta->id_salida_venta;
        //     $nuevaGanancia->total_venta = limpiar_cadena($request->cantidad_venta) * limpiar_cadena($request->precio_venta);
        //     $nuevaGanancia->total_ganancia =  ($request->cantidad_venta * $request->precio_venta) - ($request->cantidad_venta * $entrada->precio_compra_entrada);
        //     $nuevaGanancia->save();
    
        //     return redirect()->route('ventas.index')->with('alert','Se ha agregado la venta con exito.');
        // }else {
        //     return redirect()->route('ventas.index')->with("alert","No hay una existencia creada de este producto en Entradas.");
        // }

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
            $nuevoPagoFactura->fecha_pago = $request->fecha_pago;
            $nuevoPagoFactura->monto = $request->pagado;
            $nuevoPagoFactura->save();
    
            return redirect()->route('ventas.index')->with('alert','Se ha agregado el pago con éxito.');
        }

    }
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


    // Productos de factura
    public function indexProductos(FacturasClientes $id_factura){
        $facturaProductos = SalidasVentas::leftjoin('entradas','salidas_ventas.id_entrada','=','entradas.id_entrada')
        ->leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->select('salidas_ventas.*','productos.nombre_producto', 'productos.referencia')->where('salidas_ventas.id_factura_cliente','=',$id_factura->id_factura_cliente)->distinct()->get();

        $cliente = Clientes::where('nit_cedula','=',$id_factura->nit_cedula)->first();

        $pagosFactura = PagosFacturas::where('id_factura_cliente','=',$id_factura->id_factura_cliente)->get();
        $hayPagos = "";
        if(count($pagosFactura)>0){
            $hayPagos = "si";
        }else {
            $hayPagos = "no";
        }

        
        return view('ventas.productos', compact('id_factura','facturaProductos','cliente','hayPagos'));
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
        $id_factura->save();

        $entrada = Entradas::where('id_entrada','=',$id_salida_venta->id_entrada)->first();
        $entrada->cantidad_entrada += $id_salida_venta->cantidad_entregada;
        $entrada->save();

        $id_salida_venta->delete();

        return redirect()->route('ventas.indexProductos', compact('id_factura'))->with('alert','Se ha eliminado el producto de venta con éxito.');
    }


    public function export(){
        return Excel::download( new VentasExport, 'ventas.xlsx');
    }
}
