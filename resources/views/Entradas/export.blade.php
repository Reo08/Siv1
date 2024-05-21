<table>
    <thead>
        <tr>
            <th>Tabla Productos (Existencias)</th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th>ID existencia</th>
            <th>Referencia</th>
            <th>Nombre producto</th>
            <th>Categoria</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Costo de inversion</th>
            <th>Precio de venta distribuidor</th>
            <th>Registrado por</th>
            <th>Fecha de fabricación</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entradas as $entrada)
            <tr>
                <td>{{$entrada->id_entrada}}</td>
                <td>{{$entrada->referencia}}</td>
                <td>{{$entrada->nombre_producto}}</td>
                <td>{{$entrada->nombre_categoria}}</td>
                <td>{{$entrada->descripcion_producto}}</td>
                <td>{{$entrada->cantidad_entrada}}</td>
                <td>{{$entrada->costo_inversion}}</td>
                <td>{{$entrada->precio_venta_distribuidor}}</td>
                <td>{{$entrada->nombre_usuario}}</td>
                <td>{{$entrada->fecha_ingreso}}</td>
                <td>{{$entrada->created_at}}</td>
                <td>{{$entrada->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Tabla Importes pagados</th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th>ID importe</th>
            <th>ID existencia</th>
            <th>Referencia</th>
            <th>Nombre producto</th>
            <th>Cantidad</th>
            <th>Costo de inversion</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($importes as $importe)
            <tr>
                <td>{{$importe->id_importe}}</td>
                <td>{{$importe->id_entrada}}</td>
                <td>{{$importe->referencia_producto}}</td>
                <td>{{$importe->nombre_producto}}</td>
                <td>{{$importe->cantidad_importe}}</td>
                <td>{{$importe->costo_inversion}}</td>
                <td>{{$importe->created_at}}</td>
                <td>{{$importe->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
