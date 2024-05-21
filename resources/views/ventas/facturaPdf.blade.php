<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura N° {{$id_factura->id_factura_cliente}}</title>
    <link rel="stylesheet" href="{{public_path('/css/facturaPdf.css')}}">
</head>
<body>
    <div class="container">
        <section class="header">
            <h1>{{$razon_social}}</h1>
            <p>{{$direccion}}</p>
            <p>Nit {{$nit_cedula}}</p>
            <p>Cel: {{$celular}}</p>
            <p>CIUU: {{$codigo_ciuu}}</p>
        </section>
        <section class="customer-info">
            <h3>Informacion del cliente</h3>
            <strong>{{$cliente->nombre_cliente}}</strong>
            <p><strong>Telefono:</strong> {{$cliente->telefono}}</p>
            <p><strong>Correo electrónico:</strong> {{$cliente->correo}}</p>
        </section>
        <section class="invoice-details">
            @if ($id_factura->factura_electronica === null)
            <p><strong>Factura N°: {{$id_factura->id_factura_cliente}}</strong></p>
            @else
            <p><strong>Factura: {{$id_factura->factura_electronica}}</strong></p>
            @endif
            <p><strong>Fecha: {{$fecha}}</strong></p>
        </section>
        <section class="invoice-table">
            <table>
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unidad</th>
                        <th>Precio total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facturaProductos as $producto)
                        <tr>
                            <td>{{$producto->referencia}}</td>
                            <td>{{$producto->nombre_producto}}</td>
                            <td>{{$producto->cantidad_orden}}</td>
                            <td>${{number_format($producto->valor_unidad,0,',','.')}}</td>
                            <td>${{number_format($producto->valor_total,0,',','.')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <section class="cont_price">
            <table>
                <tr>
                    <td><p><strong>Total a pagar:</strong></p></td>
                    <td><p> ${{number_format($id_factura->valor_total,0,',','.')}}</p></td>
                </tr>
                <tr>
                    <td><p><strong>Importe pagado:</strong></p></td>
                    <td><p> ${{number_format($id_factura->pagado,0,',','.')}}</p></td>
                </tr>
                <tr>
                    <td><p><strong>Saldo:</strong></p></td>
                    <td><p> ${{number_format($id_factura->debe,0,',','.')}}</p></td>
                </tr>
            </table>
        </section>
    </div>
</body>
</html>