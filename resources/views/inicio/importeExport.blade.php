<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Entrada</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio de compra/u</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($importes as $importe)
            <tr>
                <td>{{ $importe->id_importe }}</td>
                <td>{{ $importe->id_entrada }}</td>
                <td>{{ $importe->nombre_producto }}</td>
                <td>{{ $importe->cantidad_importe }}</td>
                <td>{{ $importe->precio_compra }}</td>
                <td>{{ $importe->created }}</td>
                <td>{{ $importe->updated }}</td>
            </tr>
        @endforeach
    </tbody>
</table>