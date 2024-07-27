<?php 
	include('conn.php'); // Incluye el archivo de conexión a la base de datos.
	session_start(); // Inicia una nueva sesión o reanuda la sesión existente.
	if(isset($_POST['username'])){ // Verifica si se ha enviado el nombre de usuario a través del formulario.
		$username=$_POST['username']; // Obtiene el nombre de usuario del formulario.
		$password=md5($_POST['password']); // Encripta la contraseña con MD5.

		$query=$conn->query("select * from user where username='$username' and password='$password'"); // Ejecuta la consulta para verificar las credenciales del usuario.

		if ($query->num_rows>0){ // Si se encuentra una coincidencia en la base de datos.
			$row=$query->fetch_array(); // Obtiene los datos del usuario.
			$_SESSION['user']=(int)$row['userid']; // Guarda el ID del usuario en la sesión.
		}
		else{
			?>
  				<span>Error de inicio de sesión. Usuario no encontrado.</span> <!-- Muestra un mensaje de error si las credenciales no coinciden. -->
  			<?php 
		}
	}


?>
