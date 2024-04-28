<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>categoria</th>
            <th>Cantidad</th>
            <th>Precio de compra / u</th>
            <th>Registro por</th>
            <th>fecha de perdida</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($perdidas as $perdida)
            <tr>
                <td>{{$perdida->id_salida_perdida}}</td>
                <td>{{$perdida->nombre_producto}}</td>
                <td>{{$perdida->nombre_categoria}}</td>
                <td>{{$perdida->cantidad}}</td>
                <td>{{$perdida->precio_compra}}</td>
                <td>{{$perdida->nombre_usuario}}</td>
                <td>{{$perdida->fecha_perdida}}</td>
                <td>{{$perdida->created}}</td>
                <td>{{$perdida->updated}}</td>
            </tr>
        @endforeach
    </tbody>
</table>