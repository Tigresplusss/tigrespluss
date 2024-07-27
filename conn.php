<?php
// Establecer la conexión con la base de datos
$conn = new mysqli("localhost", "root", "", "bd_tigres");

// Verificar si hubo un error en la conexión
if ($conn->connect_error) {
    // Si hay un error, mostrar un mensaje y terminar la ejecución del script
    die("Connection failed: " . $conn->connect_error);
}


?>
