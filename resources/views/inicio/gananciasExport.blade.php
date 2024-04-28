<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ID de venta</th>
            <th>Cantidad de productos</th>
            <th>Precio de venta</th>
            <th>Venta total</th>
            <th>Ganancia total</th>
            <th>Fecha de resgistro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ganancias as $ganancia)
            <tr>
                <td>{{$ganancia->id_ganancia}}</td>
                <td>{{$ganancia->id_salida_venta}}</td>
                <td>{{$ganancia->cantidad}}</td>
                <td>{{$ganancia->precio_venta}}</td>
                <td>{{$ganancia->total_venta}}</td>
                <td>{{$ganancia->total_ganancia}}</td>
                <td>{{$ganancia->created_at}}</td>
                <td>{{$ganancia->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>