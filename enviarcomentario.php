<?php
// Incluir el archivo de conexión y el archivo de sesión
require_once 'login.php';  // Este archivo debe iniciar la sesión y autenticar al usuario
require_once 'conn.php';   // Este archivo debe establecer la conexión con la base de datos

// Obtener el ID del usuario desde la sesión
$idusuario = $_SESSION['user']; 

// Obtener el comentario enviado mediante el método POST
$comentario = $_POST['comentario'];

// Obtener los parámetros 'type' e 'id' de la URL mediante el método GET
$type = $_GET['type']; 
$idpelicula = (int)$_GET['id']; // Convertir el ID de la película a un entero para evitar problemas de tipo

// Escapar el comentario para prevenir inyecciones SQL
$comentario = mysqli_real_escape_string($conn, $comentario);

// Insertar el comentario en la base de datos
$resultado = mysqli_query($conn,
    'INSERT INTO comentarios (comentario, idpelicula, idusuario) 
    VALUES ("' . $comentario . '", "' . $idpelicula . '", "' . $idusuario . '")');
// La consulta SQL inserta el comentario, el ID de la película y el ID del usuario en la tabla 'comentarios'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentario Enviado</title>
    <!-- Incluir Bootstrap CSS desde CDN para estilos rápidos y responsivos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Incluir Bootstrap Icons desde CDN para usar íconos en la página -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Incluir el ícono personalizado para la pestaña del navegador -->
    <link rel="icon" type="image/jpg" href="./img/sent.png"/>
</head>

<body style="background: url(./img/backcoment1.jpg); background-size:100%;">
    <!-- Espaciado superior para separación -->
    <br></br>
    <br></br>
    <!-- Mensaje de confirmación y botón de regreso al inicio -->
    <div class="text-center mt-5">
        <h1 style="font-weight: bolder; color: black; -webkit-text-stroke: 1.5px black;">
            <!-- Íconos de Bootstrap para mejorar la presentación -->
            <i class="bi bi-send-check-fill"></i> Se ha registrado su comentario... <i class="bi bi-check-circle-fill"></i>
        </h1>
        <!-- Botón para regresar a la página de inicio -->
        <a role="button" class="btn btn-primary mt-4" href="index.php">
            <!-- Ícono de Bootstrap para la flecha de regreso -->
            <i class="bi bi-chevron-double-left"></i> Volver al Inicio
        </a>
    </div>
</body>
</html>
