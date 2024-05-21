<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre proveedor</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($proveedores as $proveedor)
            <tr>
                <td>{{$proveedor->id_proveedor}}</td>
                <td>{{$proveedor->nombre_proveedor}}</td>
                <td>{{$proveedor->correo_proveedor}}</td>
                <td>{{$proveedor->telefono_proveedor}}</td>
                <td>{{$proveedor->created_at}}</td>
                <td>{{$proveedor->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>