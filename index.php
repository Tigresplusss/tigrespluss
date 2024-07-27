<?php
    // Incluye el archivo de inicio de sesión.
    include('login.php');
    
    // Establece la conexión a la base de datos y verifica si hay algún error.
    $conn = new mysqli("localhost", "root", "", "bd_tigres") or die("Conexion Fallida: " . $conn->connect_error);

    // Realiza una consulta para obtener los géneros de la tabla 'genero'.
    $generoQuery = $conn->query(" SELECT genero.idgenero, genero.nombre_genero FROM genero");

    // Almacena los resultados de la consulta en un arreglo.
    while ($row = $generoQuery->fetch_object()) {
        $generos[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Pelis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/jpg" href="./img/home.png"/>

    <style>
        body {
            background-color: #2b2b2b; /* Fondo gris oscuro */
            color: #e5e5e5;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .navbar {
            background-color: #141414;
        }

        .navbar-brand {
            color: #e50914 !important;
            font-weight: bold;
        }

        .nav-link {
            color: #e5e5e5 !important;
        }

        .dropdown-menu {
            background-color: #141414;
        }

        .dropdown-item {
            color: #e5e5e5 !important;
        }

        .dropdown-item:hover {
            background-color: #e50914;
        }

        .btn-outline-warning {
            color: #e50914 !important;
            border-color: #e50914 !important;
        }

        .btn-outline-warning:hover {
            background-color: #e50914 !important;
            color: #fff !important;
        }

        h1, h3 {
            color: #e5e5e5;
        }

        footer {
            text-align: center;
            color: #757575;
            padding: 20px 0;
        }

        .card {
            background-color: #333;
            border: none;
        }

        .card-title {
            color: #e5e5e5;
        }

        .card-img-top {
            max-height: 28rem;
            max-width: 18rem;
            margin: 0 auto;
        }

        .carousel-inner img {
            width: 100%;
            height: 499px;
        }

        @media (max-width: 575px) {
            .carousel-inner img {
                width: 100%;
                height: 220px;
            }
        }

        #icono {
            width: 40px;
            height: 40px;
        }

        .btn-dark {
            background-color: #e50914;
            border-color: #e50914;
        }

        .btn-dark:hover {
            background-color: #f40612;
            border-color: #f40612;
        }

        .container-fluid.bg-primary {
            background-color: #141414 !important;
        }
    </style>
</head>

<body style="background: rgb(21,0,80); background: linear-gradient(90deg, rgba(21,0,80,1) 0%, rgba(63,0,113,1) 37%, rgba(251,17,118,1) 100%);">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- icono o nombre -->
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-film"></i>
                <span class="text-warning">Top Tigres</span>
            </a>

            <!-- boton del menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- elementos del menu colapsable -->
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Películas
                        </a>
                        <ul class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdown">
                            <!-- Itera sobre los géneros y genera un elemento de lista para cada uno -->
                            <?php foreach ($generos as $genero) : ?>
                                <li><a class="dropdown-item" href="genero-menu-image.php?type=genero&idgenero=<?php echo $genero->idgenero; ?>"><?php echo $genero->nombre_genero; ?></a></li>
                            <?php endforeach; ?>    
                            <li><a class="dropdown-item" href="todas-menu-image.php">Todas</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="favoritas.php">Mis favoritas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="insertar.php">Registrar Peliculas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="registroUsuarios.php">Usuarios</a>
                    </li>
                </ul>

                <hr class="d-md-none text-white-50">

                <!-- enlaces redes sociales -->
                <ul class="navbar-nav  flex-row flex-wrap text-light">
                    <li class="nav-item col-6 col-md-auto p-3">
                        <a href="https://wa.me/51922565148" target="_blank"><i class="bi bi-whatsapp"></i></i></a>
                        <small class="d-md-none ms-2">WhatsApp</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <a href="https://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
                        <small class="d-md-none ms-2">Facebook</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <a href="https://github.com/TigresPlus/TigresPlus.git" target="_blank"><i class="bi bi-github"></i></a>
                        <small class="d-md-none ms-2">GitHub</small>
                    </li>
                </ul>

                <!--boton Informacion -->
                <!-- Verifica si el usuario no está logueado para mostrar el botón de ACCEDER -->
                <?php if ($_SESSION['user'] == 0 ) : ?>
                    <form class="d-flex">
                        <a href="logearse.php" class="btn btn-outline-warning d-none d-md-inline-block" type="button">ACCEDER</a>
                    </form>
                <!-- Si el usuario está logueado, muestra el botón de CERRAR SESIÓN -->
                <?php else: ?>
                    <form class="d-flex">
                        <a href="logout.php" class="btn btn-outline-warning d-none d-md-inline-block" type="button">CERRAR SESIÓN</a>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </nav>

    <!-- Establece la sesión del usuario a NULL si no está definida -->
    <?php if ((!isset($_SESSION['user']))){
        $_SESSION['user'] = NULL;
    } ?>
    
    <!-- Verifica si la sesión del usuario es 0 y la establece a NULL -->
    <?php if ($_SESSION['user'] == 0 ){
         $_SESSION['user'] = NULL;
    }?>
    
    <!-- Muestra diferentes mensajes dependiendo del estado de la sesión del usuario -->
    <?php if ( $_SESSION['user'] == NULL ): ?>
        <h1 class="display-2 mt-2 "><i class="bi bi-webcam-fill"></i><b> TIGRES+ </b> <i class="bi bi-webcam-fill"></i></h1>
        <div class="jumbotron text-center">
            <h3 class="mt-4 display-8"><i class="bi bi-exclamation-circle-fill"></i> IMPORTANTE!!! Actualmente te encuentras logueado, no podrás dar LIKES ni hacer comentarios en películas. Le recomiendo <a href="logearse.php">Iniciar Sesión</a> <i class="bi bi-emoji-wink-fill"></i></h3>
        </div>
    <?php else: ?>
        <div class="row" style="background: rgb(21,0,80); background: linear-gradient(90deg, rgba(21,0,80,1) 0%, rgba(63,0,113,1) 37%, rgba(251,37,118,1) 100%);">
            <div class="col">
                <div class="jumbotron text-center">
                    <h1 class="display-2 mt-2 "><i class="bi bi-webcam-fill"></i> LOS TIGRES+ <i class="bi bi-webcam-fill"></i></h1>
                    <h3 class="mt-4 display-8">Sitio web donde ver algunas pelis, donde tendrás la posibilidad de darles un LIKE y marcarlas como favoritas, como así también, dejar algún comentario de tu preferencia <i class="bi bi-emoji-sunglasses-fill"></i></h3>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div id="carouselExampleIndicators" class="carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="6000">
                <img src="./img/deadpool3.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="./img/accion2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="6000">
                <img src="./img/ficcion.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="./img/aventuras.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="6000">
                <img src="./img/terror.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Antes</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <div class="container mt-4">
        <div class="row m-0 justify-content-center">
            <div class="col-auto text-center col-12 col-md-6 mt-4">
                <div class="card" style="background: rgb(255,116,177); background: radial-gradient(circle, rgba(255,116,177,1) 0%, rgba(255,161,207,1) 100%); height: 25rem;">
                    <img src="./img/peliculas.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">TODAS LAS PELICULAS</h5>
                        <a href="todas-menu-image.php" class="btn btn-dark"><i class="bi bi-eye"></i> Ver</a>
                    </div>
                </div>
            </div>
            <div class="text-center col-12 col-md-6 mt-4">
                <div class="card" style="background: rgb(255,116,177); background: radial-gradient(circle, rgba(255,116,177,1) 0%, rgba(255,161,207,1) 100%); height: 25rem;">
                    <img src="./img/like.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Mis Favoritas</h5>
                        <a href="favoritas.php" class="btn btn-dark"><i class="bi bi-emoji-heart-eyes-fill"></i> Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-primary">
        <div class="row mt-5" style="background: rgb(144,94,150); background: radial-gradient(circle, rgba(144,94,150,1) 0%, rgba(213,139,221,1) 100%);">
            <footer>
                <p class="mt-3" style="color: white">Todos los derechos reservados | © 5-B-10 2024</p>
                <p style="color: white">Breña, Lima, Perú</p>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

</body>

</html>
