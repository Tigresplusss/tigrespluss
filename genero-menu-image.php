<?php
require_once 'conn.php'; // Incluye el archivo de conexión a la base de datos.
require_once 'login.php'; // Incluye el archivo de manejo de sesiones o autenticación.

if (isset($_GET['type'], $_GET['idgenero'])) {
    // Verifica si los parámetros 'type' e 'idgenero' están presentes en la URL.
    $type = $_GET['type']; // Asigna el valor del parámetro 'type' a la variable $type.
    $idgenero  = (int)$_GET['idgenero']; // Asigna el valor del parámetro 'idgenero' a la variable $idgenero y lo convierte a entero.

    switch ($type) {
        // Dependiendo del valor de 'type', ejecuta el código dentro del case correspondiente.
        case 'genero':
            // Realiza una consulta SQL para obtener las películas según el género especificado.
            $peliculasQuery = $conn->query("
                SELECT pelicula.id, 
                pelicula.url_imagen,
                pelicula.titulo, genero.nombre_genero
        
                FROM pelicula 
                
                LEFT JOIN genero
                ON pelicula.genero_idgenero = genero.idgenero   

                WHERE pelicula.genero_idgenero = {$idgenero}
            ");

            // Inicializa un array para almacenar los resultados de la consulta.
            while ($row = $peliculasQuery->fetch_object()) {
                // Itera sobre los resultados de la consulta y los agrega al array $peliculas.
                $peliculas[] = $row;
            }
    }
}

// Las siguientes líneas están comentadas, pero pueden ser usadas para depuración.
//echo '<pre>', print_r($peliculas, true), '</pre>'; // Muestra el contenido del array $peliculas para depuración.
//die(); // Detiene la ejecución del script.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Define la codificación de caracteres como UTF-8. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Asegura la compatibilidad con versiones antiguas de Internet Explorer. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define la escala de la página para dispositivos móviles. -->
    <title>Peliculas</title> <!-- Define el título de la página que se muestra en la pestaña del navegador. -->
    <link rel="icon" type="image/jpg" href="./img/genre.png"/> <!-- Define el ícono que se muestra en la pestaña del navegador. -->

    <style>
        .chat-button {
            /* Estilos para el botón de chat que se muestra en la esquina inferior derecha. */
            padding: 15px;
            height: 50px;
            width: 100px;
            border-radius: 20px;
            background-color: #E45826;
            box-shadow: 0px 3px 12px rgba(0, 0, 0, 0.2);
            background-size: 50%;
            position: fixed;
            bottom: 30px;
            right: 30px;
            text-align: center;
            font-weight: bold;
            color: white;
        }

        h1 {
            /* Estilos para los títulos de la página. */
            margin: 70px;
            text-align: center;
        }

        #titulo {
            /* Estilos específicos para el ID 'titulo'. */
            color: #F0A500;
            font-size: 55px;
            text-transform: uppercase;
            font-weight: 800;
            text-shadow: 2px 5px #000;
        }

        * {
            /* Asegura que el padding y el borde se incluyan en el tamaño total del elemento. */
            box-sizing: border-box;
        }

        body {
            /* Estilos para el cuerpo de la página. */
            margin: 20px;
            padding-top: 0;
            background: url(img/tigre.jpeg);
            background-position: center;
            background-size: 100%;
            font-family: Helvetica;
        }

        img {
            /* Estilos para las imágenes de las películas. */
            width: 300px;
            padding: 5px;
            height: 450px;
        }

        .container .item {
            /* Estilos para los contenedores de las imágenes de las películas. */
            float: left;
            position: relative;
            margin-left: 20px;
        }

        .overlay {
            /* Estilos para el overlay que aparece sobre la imagen cuando se pasa el ratón. */
            position: absolute;
            top: 0.2em;
            bottom: 0;
            left: 0.1em;
            right: 0;
            height: 443px;
            width: 295px;
            opacity: 0;
            transition: .5s ease;
            background-color: rgba(56, 53, 53, 0.568);
        }

        .container:hover .overlay {
            /* Cambia la opacidad del overlay cuando el usuario pasa el ratón sobre el contenedor. */
            opacity: 1;
        }

        a:link,
        a:visited,
        a:active {
            /* Estilos para los enlaces en diferentes estados. */
            text-decoration: none;
        }

        a:hover {
            /* Estilo para los enlaces cuando el usuario pasa el ratón sobre ellos. */
            color: yellow;
        }

        .text {
            /* Estilos para el texto dentro del overlay. */
            color: white;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
            font-weight: bold;
        }

        /* Media queries para ajustar el diseño en diferentes tamaños de pantalla. */
        @media (max-width: 1319px) { .container { margin-left: 10em; } }
        @media (max-width: 1267px) { .container { margin-left: 8em; } }
        @media (max-width: 1209px) { .container { margin-left: 5em; } }
        @media (max-width: 1157px) { .container { margin-left: 3em; } }
        @media (max-width: 1108px) { .container { margin-left: 2em; } }
        @media (max-width: 1035px) { .container { margin-left: 1em; } }
        @media (max-width: 1015px) { .container { margin-left: 9em; } }
        @media (max-width: 961px) { .container { margin-left: 8em; } }
        @media (max-width: 927px) { .container { margin-left: 6em; } }
        @media (max-width: 889px) { .container { margin-left: 5em; } }
        @media (max-width: 835px) { .container { margin-left: 4em; } }
        @media (max-width: 791px) { .container { margin-left: 3em; } }
        @media (max-width: 767px) { .container .item { margin-left: 10em; } #titulo { font-size: 37px; } }
        @media (max-width: 687px) { .container .item { margin-left: 8em; } }
        @media (max-width: 639px) { .container .item { margin-left: 6em; } }
        @media (max-width: 597px) { .container .item { margin-left: 4em; } }
        @media (max-width: 561px) { .container .item { margin-left: 3em; } }
        @media (max-width: 529px) { .container .item { margin-left: 1em; } }
        @media (max-width: 412px) { .container .item { margin-left: -0.7em; } }
        @media (max-width: 397px) { .container .item { margin-left: -1em; } }
        @media (max-width: 360px) { .container .item { margin-left: -1.8em; } }
        @media (max-width: 280px) { .container .item { margin-left: -4em; } h1 { margin: 10px; text-align: center; } }
    </style>
</head>

<body>
<?php
    // Muestra el título correspondiente dependiendo del valor de $idgenero.
    if ($idgenero == 1) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS TERROR</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 2) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS ACCIÓN</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 3) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS AVENTURAS</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 4) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS CIENCIA FICCIÓN</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 5) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS DRAMA</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 6) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS FANTASÍA</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 7) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS MUSICAL</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 8) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS SUSPENSO</h1>
        </div>
    <?php } ?>

    <?php
    if ($idgenero == 9) {
    ?>
        <div id="cont-titulo">
            <h1 id="titulo"> PELICULAS COMEDIA</h1>
        </div>
    <?php } ?>

    <!-- Itera sobre el array $peliculas y muestra cada película. -->
    <?php foreach ($peliculas as $pelicula) : ?>
        <div class="container">
            <div class="item">
                <img clas="image" src="<?php echo $pelicula->url_imagen ?>" alt=""> <!-- Muestra la imagen de la película. -->
                <div class="overlay">
                    <a class="text" href="pelicula.php?type=pelicula&id=<?php echo $pelicula->id; ?>"><?php echo $pelicula->titulo ?></a>
                    <!-- Muestra el título de la película con un enlace a su página de detalles. -->
                </div>
            </div>
        </div>

        <!-- Botón para volver a la página principal. -->
        <a href="index.php" class="chat-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z" />
            </svg>
            Volver</a>

    <?php endforeach; ?>
</body>
</html>
