<?php
    // Incluye archivos necesarios para la conexión a la base de datos y la gestión de sesiones
    require_once 'conn.php';
    require_once 'login.php';

    // Verifica si el usuario no está autenticado, redirige al login si es así
    if ($_SESSION['user'] == NULL) { 
        header('location:logearse.php');
        exit();
    }

    // Conecta a la base de datos
    $conecta = @mysqli_connect("localhost", "root", "", "bd_tigres") or die("Error en la conexión");

    // Verifica si el formulario ha sido enviado
    if (isset($_POST['btn'])) {
        // Obtiene los valores enviados a través del formulario
        $userid = isset($_POST['txtuserid']) ? $_POST['txtuserid'] : '';
        $username = isset($_POST['txtusername']) ? $_POST['txtusername'] : '';
        $password = isset($_POST['txtpassword']) ? $_POST['txtpassword'] : '';
        $boton = $_POST['btn'];

        // Prepara la consulta SQL dependiendo del valor del botón
        switch ($boton) {
            case "insertar":
                // Consulta SQL para insertar un nuevo registro
                $sql = "INSERT INTO user(userid,username, password) VALUES('$userid', '$username','$password')";
                break;
            case "actualizar":
                // Consulta SQL para actualizar un registro existente
                $sql = "UPDATE user SET username='$username', password='$password' WHERE userid='$userid'";
                break;
            case "eliminar":
                // Consulta SQL para eliminar un registro
                $sql = "DELETE FROM user WHERE userid='$userid'";
                break;
        }

        // Ejecuta la consulta SQL si está definida
        if ($sql) {
            mysqli_query($conecta, $sql);
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <!-- Incluye los archivos de estilo CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="logo.jpg">
    <style>
        /* Estilos personalizados para la página */
        body {
            background-color: #c7f7f7;
            font-family: Arial, sans-serif;
        }
        .main-title {
            color: #343a40;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .btn-custom {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-custom-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-custom-primary:hover {
            background-color: #0056b3;
        }
        .btn-custom-success {
            background-color: #28a745;
            color: white;
        }
        .btn-custom-success:hover {
            background-color: #218838;
        }
        .btn-custom-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-custom-danger:hover {
            background-color: #c82333;
        }
        .btn-custom-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-custom-secondary:hover {
            background-color: #5a6268;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-body {
            background-color: #ffffff;
        }
        .table-dark {
            background-color: blue;
            color: white;
        }
        .table-dark th, .table-dark td {
            padding: 10px;
            text-align: center;
        }
        .table-dark th {
            font-weight: bold;
        }
        .modal-dialog {
            max-width: 600px;
        }
        .modal-content {
            border-radius: 10px;
        }
        .marquee-container {
            margin-bottom: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Contenedor para el mensaje de bienvenida o marca -->
    <div class="marquee-container">
        Instituto Argentina
    </div>
    <div class="container">
        <!-- Título principal de la página -->
        <h1 class="main-title text-center">Registro de Usuarios</h1>
        <!-- Botón para abrir el modal de registro -->
        <button type="button" class="btn btn-custom btn-custom-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-plus"></i> Registrar
        </button>
        <!-- Tabla para mostrar los registros de usuarios -->
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Usuario</th>
                    <th style="text-align: center">Contraseña</th>
                    <th style="text-align: center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener todos los registros de usuarios
                $data = mysqli_query($conecta, "SELECT * FROM user ORDER BY userid");
                while ($row = mysqli_fetch_array($data)) {
                    // Muestra cada registro en una fila de la tabla
                    echo "<tr>
                        <td style='text-align: center'>{$row['userid']}</td>
                        <td style='text-align: center'>{$row['username']}</td>
                        <td style='text-align: center'>{$row['password']}</td>
                        <td style='text-align: center'>
                            <!-- Botón para editar el registro (abre el modal) -->
                            <button type='button' class='btn btn-custom btn-custom-success' data-bs-toggle='modal' data-bs-target='#exampleModal' data-userid='{$row['userid']}' data-username='{$row['username']}' data-password='{$row['password']}'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <!-- Formulario para eliminar el registro -->
                            <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='txtuserid' value='{$row['userid']}'>
                                <button type='submit' class='btn btn-custom btn-custom-danger' name='btn' value='eliminar' onclick='return confirmDelete();'>
                                    <i class='fas fa-trash'></i>
                                </button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal para registrar o editar usuarios -->
        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <div class="mb-3 d-none">
                                <label for="txtuserid" class="form-label">ID</label>
                                <input type="text" class="form-control" name="txtuserid" id="txtuserid">
                            </div>
                            <div class="mb-3">
                                <label for="txtusername" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="txtusername" id="txtusername">
                            </div>
                            <div class="mb-3">
                                <label for="txtpassword" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="txtpassword" id="txtpassword">
                            </div>
                            <!-- Botones para insertar o actualizar el registro -->
                            <button type="submit" class="btn btn-custom btn-custom-primary" name="btn" value="insertar">
                                <i class="fas fa-plus"></i> Insertar
                            </button>
                            <button type="submit" class="btn btn-custom btn-custom-primary" name="btn" value="actualizar">
                                <i class="fas fa-pencil-alt"></i> Actualizar
                            </button>
                            <button type="button" class="btn btn-custom btn-custom-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts necesarios para el funcionamiento del modal y la tabla -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
        <script>
            $(document).ready(function () {
                // Inicializa DataTable para la tabla de usuarios
                $('#example').DataTable();

                // Configura el modal al abrirlo
                $('#exampleModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Botón que activó el modal
                    var userid = button.data('userid'); // Extrae información de los atributos data-*
                    var username = button.data('username');
                    var password = button.data('password');

                    var modal = $(this);
                    modal.find('#txtuserid').val(userid || '');
                    modal.find('#txtusername').val(username || '');
                    modal.find('#txtpassword').val(password || '');

                    // Cambia el título y los botones del modal dependiendo de si hay un ID
                    if (userid) {
                        modal.find('.modal-title').text('Editar Registro');
                        modal.find('button[name="btn"][value="insertar"]').hide();
                        modal.find('button[name="btn"][value="actualizar"]').show();
                    } else {
                        modal.find('.modal-title').text('Registrar');
                        modal.find('button[name="btn"][value="insertar"]').show();
                        modal.find('button[name="btn"][value="actualizar"]').hide();
                    }
                });
            });

            // Función para confirmar la eliminación de un registro
            function confirmDelete() {
                return confirm('¿Está seguro de que desea eliminar este registro?');
            }
        </script>
    </div>
</body>
</html>
