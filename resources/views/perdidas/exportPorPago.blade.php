<table>
    <thead>
        <tr>
            <th>#</th>
            <th>ID factura</th>
            <th>Fecha de factura</th>
            <th>Cliente</th>
            <th>Valor total</th>
            <th>Debe</th>
            <th>Pagado</th>
            <th>Fecha limite</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($perdidasFacturas as $factura)
        <tr>
            <td>{{$factura->id_salida_perdida_credito}}</td>
            <td>{{$factura->id_factura_cliente}}</td>
            <td>{{$factura->fecha_factura}}</td>
            <td>{{$factura->nombre_cliente}}</td>
            <td>${{number_format($factura->valor_total,0,',','.')}}</td>
            <td>${{number_format($factura->debe,0,',','.')}}</td>
            <td>${{number_format($factura->pagado,0,',','.')}}</td>
            <td>{{$factura->fecha_limite_pago}}</td>
            <td>{{$factura->created_at}}</td>
            <td>{{$factura->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>