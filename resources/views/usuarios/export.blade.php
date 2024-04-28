<table>
    <thead>
        <tr>
            <th>Identificación</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{$usuario->identificacion}}</td>
                <td>{{$usuario->nombre}}</td>
                <td>{{$usuario->correo}}</td>
                <td>{{$usuario->rol}}</td>
                <td>{{$usuario->created_at}}</td>
                <td>{{$usuario->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>