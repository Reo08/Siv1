<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem de inventarios</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Kannada:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    @vite("resources/css/app.css")
</head>
<body>
    <main>
        <form action="{{route('create')}}" method="POST">
            @csrf
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li> ⚠ {{$error}}</li>
                    @endforeach
                </ul>
            @endif
            <input type="text" name="correo" placeholder="Correo" rerquired>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button>Ingresar</button>
        </form>
    </main>
</body>
</html>
