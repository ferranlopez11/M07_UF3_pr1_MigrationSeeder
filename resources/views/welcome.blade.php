<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40 !important;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .form-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #343a40;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: grey;
        }
       
    </style>

</head>

<body class="container">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FILMS</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/filmout/films">Todas las Pelis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/filmout/oldFilms">Pelis Antiguas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/filmout/newFilms">Pelis Nuevas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/filmout/sortFilms">Ordenar Pelis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/filmout/countFilms">Contar Pelis</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/filmout/filmsByYear">Pelis por Año</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/filmout/filmsByGenre">Pelis por Género</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h1 class="text-center mb-4">Registrar Nueva Película</h1>
                    @if (!empty($status))
                        <div class="alert alert-danger">{{ $status }}</div>
                    @endif
                    <form action="{{ route('createFilm') }}" method="POST">
                    {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Año:</label>
                            <input type="number" name="year" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Género:</label>
                            <input type="text" name="genre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">País:</label>
                            <input type="text" name="country" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duración (minutos):</label>
                            <input type="number" name="duration" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="img_url" class="form-label">URL de la imagen:</label>
                            <input type="text" name="img_url" class="form-control @error('img_url') is-invalid @enderror" required>
                            @error('img_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="storage_type" class="form-label">Guardar registro en:</label>
                            <select name="storage_type" class="form-control" required>
                                <option value="json">JSON</option>
                                <option value="db">Base de Datos</option>
                            </select>
                        </div><br>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom">Registrar Película</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>

</html>
