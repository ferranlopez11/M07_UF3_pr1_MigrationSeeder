<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador de Actores</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="container">
    <h1 class="mt-4">Contador de Actores</h1>
    <p class="lead">El número total de actores registrados es:</p>

    <div class="alert alert-primary">
        <h2>{{ $actorCount }}</h2>
    </div>

    <a href="/" class="btn btn-secondary mt-4">Volver al inicio</a>
</body>

</html>
