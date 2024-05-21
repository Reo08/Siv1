<table>
    <thead>
        <tr>
            <th>Nit/Cedula</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Tipo</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td>{{$cliente->nit_cedula}}</td>
                <td>{{$cliente->nombre_cliente}}</td>
                <td>{{$cliente->correo}}</td>
                <td>{{$cliente->telefono}}</td>
                <td>{{$cliente->tipo_cliente}}</td>
                <td>{{$cliente->created_at}}</td>
                <td>{{$cliente->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>