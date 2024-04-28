<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>categoria</th>
            <th>Cantidad</th>
            <th>Precio de venta / u</th>
            <th>Venta por</th>
            <th>Fecha de venta</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ventas as $venta)
            <tr>
                <td>{{$venta->id_salida_venta}}</td>
                <td>{{$venta->nombre_producto}}</td>
                <td>{{$venta->nombre_categoria}}</td>
                <td>{{$venta->cantidad}}</td>
                <td>{{$venta->precio_venta}}</td>
                <td>{{$venta->nombre_usuario}}</td>
                <td>{{$venta->fecha_venta}}</td>
                <td>{{$venta->created}}</td>
                <td>{{$venta->updated}}</td>
            </tr>
        @endforeach
    </tbody>
</table>