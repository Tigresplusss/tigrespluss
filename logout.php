<?php
	session_start(); // Inicia una nueva sesión o reanuda la sesión existente.
	session_destroy(); // Destruye todas las variables de sesión y finaliza la sesión actual.
	header('location:index.php'); // Redirige al usuario a la página 'index.php'.
?>
