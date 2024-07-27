<?php
    // Inicia una sesión en PHP
    session_start();

    // Incluye el archivo de conexión a la base de datos
    include('conn.php');

    // Ejecuta una consulta SQL para obtener la información del usuario basado en el ID almacenado en la sesión
    $query = $conn->query("SELECT * FROM user WHERE userid = '".$_SESSION['user']."'");

    // Obtiene el resultado de la consulta como un array
    $row = $query->fetch_array();

    // Almacena el nombre de usuario en una variable
    $user = $row['username'];
?>
