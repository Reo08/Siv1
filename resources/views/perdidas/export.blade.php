<table>
    <thead>
        <tr>
            <th>#</th>
            <th>ID existencia</th>
            <th>Referencia</th>
            <th>Nombre producto</th>
            <th>Categoria</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Costo inversion</th>
            <th>Editar cantidad</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($perdidas as $perdida)
            <tr>
                <td>{{$perdida->id_salida_perdida}}</td>
                <td>{{$perdida->id_entrada}}</td>
                <td>{{$perdida->referencia}}</td>
                <td>{{$perdida->nombre_producto}}</td>
                <td>{{$perdida->categoria}}</td>
                <td>{{$perdida->descripcion}}</td>
                <td>{{$perdida->cantidad}}</td>
                <td>${{number_format($perdida->costo_inversion,0,',','.')}}</td>
                <td>{{$perdida->created_at}}</td>
                <td>{{$perdida->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>