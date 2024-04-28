<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Categoria</th>
            <th>Cantidad</th>
            <th>Precio de compra/u</th>
            <th>Precio de venta / u</th>
            <th>Entrada por</th>
            <th>Fecha de entrada</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entradas as $entrada)
            <tr>
                <td class="td-menos">{{$entrada->id_entrada}}</td>
                <td>{{$entrada->nombre_producto}}</td>
                <td>{{$entrada->nombre_categoria}}</td>
                <td>{{$entrada->cantidad_entrada}}</td>
                <td>{{$entrada->precio_compra_entrada}}</td>
                <td>{{$entrada->precio_venta_entrada}}</td>
                <td>{{$entrada->nombre_usuario}}</td>
                <td>{{$entrada->fecha_entrada}}</td>
                <td>{{$entrada->created}}</td>
                <td>{{$entrada->updated}}</td>
            </tr>
        @endforeach
    </tbody>
</table>