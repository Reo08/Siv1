<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre categoria</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
            <tr>
                <td>{{$categoria->id_categoria}}</td>
                <td>{{$categoria->nombre_categoria}}</td>
                <td>{{$categoria->created_at}}</td>
                <td>{{$categoria->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>