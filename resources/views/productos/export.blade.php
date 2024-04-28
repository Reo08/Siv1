<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre producto</th>
            <th>Categoria</th>
            <th>Proveedor</th>
            <th>Detalles</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto) 
            <tr>
                <td>{{$producto->id_producto}}</td>
                <td>{{$producto->nombre_producto}}</td>
                <td>{{$producto->categoria}}</td>
                <td>{{$producto->nombre_proveedor}}</td>
                <td>{{$producto->detalles_producto}}</td>
                <td>{{$producto->created_at}}</td>
                <td>{{$producto->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>