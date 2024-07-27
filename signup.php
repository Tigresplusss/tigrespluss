<?php
    include('conn.php');

    // Verificar si se han enviado los datos del formulario
    if(isset($_POST['susername'])){
        $username = $_POST['susername'];
        $password = $_POST['spassword'];

        // Consultar si el nombre de usuario ya existe en la base de datos
        $query = $conn->query("SELECT * FROM user WHERE username='$username'");

        // Si el nombre de usuario ya existe
        if ($query->num_rows > 0){
            ?>
                <span>El nombre de usuario ya existe.</span>
            <?php 
        }

        // Verificar si el nombre de usuario contiene caracteres no válidos
        elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)){
            ?>
                <span style="font-size:11px;">Nombre de usuario no válido. No se permiten espacios ni caracteres especiales.</span>
            <?php 
        }

        // Verificar si la contraseña contiene caracteres no válidos
        elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $password)){
            ?>
                <span style="font-size:11px;">Contraseña invalida. No se permiten espacios ni caracteres especiales.</span>
            <?php 
        }
        else{
            // Encriptar la contraseña y agregar el nuevo usuario a la base de datos
            $mpassword = md5($password);
            $conn->query("INSERT INTO user (username, password) VALUES ('$username', '$mpassword')");
            ?>
                <span>Registro Exitoso.</span>
            <?php 
        }
    }
?>
