<?php
// Incluye archivos necesarios para la conexión y manejo de sesiones
require_once 'conn.php';
require_once 'login.php';

// Verifica si el usuario está autenticado, de lo contrario redirige al login
if ($_SESSION['user'] == NULL ) { 
    header('location:logearse.php');
    exit(); // Termina la ejecución si el usuario no está autenticado
}

// Establece la conexión con la base de datos
$conecta = @mysqli_connect("localhost", "root", "", "bd_tigres") or die("Error en la conexión");

// Verifica si el formulario fue enviado
if (isset($_POST['btn'])) {
    // Obtiene los datos del formulario, asignando valores por defecto si no están definidos
    $id = isset($_POST['txtid']) ? $_POST['txtid'] : '';
    $tit = isset($_POST['txttit']) ? $_POST['txttit'] : '';
    $des = isset($_POST['txtdes']) ? $_POST['txtdes'] : '';
    $url_imagen = isset($_POST['txturl_imagen']) ? $_POST['txturl_imagen'] : '';
    $anio_estreno = isset($_POST['txtanio_estreno']) ? $_POST['txtanio_estreno'] : '';
    $director = isset($_POST['txtdirector']) ? $_POST['txtdirector'] : '';
    $url_trailer = isset($_POST['txturl_trailer']) ? $_POST['txturl_trailer'] : '';
    $genero_idgenero = isset($_POST['txtgenero_idgenero']) ? $_POST['txtgenero_idgenero'] : '';
    $idpais = isset($_POST['txtidpais']) ? $_POST['txtidpais'] : '';
    $iddistribuidora = isset($_POST['txtiddistribuidora']) ? $_POST['txtiddistribuidora'] : '';
    $likes = isset($_POST['txtlikes']) ? $_POST['txtlikes'] : '';
    $boton = $_POST['btn']; // Obtiene el valor del botón presionado

    // Determina la acción a realizar en base al valor del botón
    switch ($boton) {
        case "insertar":
            // Consulta SQL para insertar un nuevo registro en la tabla 'pelicula'
            $sql = "INSERT INTO pelicula(id, titulo, descripcion, url_imagen, anio_estreno, director, url_trailer, genero_idgenero, idpais, iddistribuidora, likes) VALUES('$id', '$tit', '$des', '$url_imagen', '$anio_estreno', '$director', '$url_trailer', '$genero_idgenero', '$idpais', '$iddistribuidora', '$likes')";
            break;
        case "actualizar":
            // Consulta SQL para actualizar un registro existente en la tabla 'pelicula'
            $sql = "UPDATE pelicula SET titulo='$tit', descripcion='$des', url_imagen='$url_imagen', anio_estreno='$anio_estreno', director='$director', url_trailer='$url_trailer', genero_idgenero='$genero_idgenero', idpais='$idpais', iddistribuidora='$iddistribuidora', likes='$likes' WHERE id='$id'";
            break;
        case "eliminar":
            // Consulta SQL para eliminar un registro de la tabla 'pelicula'
            $sql = "DELETE FROM pelicula WHERE id='$id'";
            break;
    }

    // Ejecuta la consulta SQL si se ha definido
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
    <title>Registro de Películas</title>
    <!-- Enlaces a los estilos de Bootstrap, DataTables y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="logo.jpg">
    <style>
        /* Estilos personalizados para el cuerpo de la página */
        body {
            background-color: #c7f7f7;
            font-family: Arial, sans-serif;
        }
        /* Estilos para el título principal */
        .main-title {
            color: #343a40;
            margin-bottom: 30px;
            font-weight: 600;
        }
        /* Estilos para los botones personalizados */
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
        /* Estilos para el encabezado del modal */
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        /* Estilos para el cuerpo del modal */
        .modal-body {
            background-color: #ffffff;
        }
        /* Estilos para la tabla con fondo oscuro */
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
        /* Estilos para la descripción en la tabla */
        .table-description {
            white-space: normal;
        }
        /* Estilos para el diálogo del modal */
        .modal-dialog {
            max-width: 600px;
        }
        .modal-content {
            border-radius: 10px;
        }
        /* Estilos para el contenedor del marquee */
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
    <!-- Contenedor para el marquee -->
    <div class="marquee-container">
        Instituto Argentina
    </div>
    <div class="container">
        <!-- Título principal de la página -->
        <h1 class="main-title text-center">Registro de Películas</h1>
        <!-- Botón para abrir el modal de registro -->
        <button type="button" class="btn btn-custom btn-custom-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-plus"></i> Registrar
        </button>
        <!-- Tabla para mostrar los registros de películas -->
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th class="table-description">Descripción</th>
                    <th>Portada</th>
                    <th>Estreno</th>
                    <th>Director</th>
                    <th>Trailer</th>
                    <th>Género</th>
                    <th>País</th>
                    <th>Distribuidora</th>
                    <th>Likes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener todos los registros de películas
                $data = mysqli_query($conecta, "SELECT * FROM pelicula ORDER BY id");
                // Itera sobre cada registro y lo muestra en la tabla
                while ($row = mysqli_fetch_array($data)) {
                    echo "<tr>
                        <td style='text-align: center'>{$row['id']}</td>
                        <td style='text-align: center'>{$row['titulo']}</td>
                        <td style='text-align: center' class='table-description'>{$row['descripcion']}</td>
                        <td><img src='{$row['url_imagen']}' width='100%'></td>
                        <td style='text-align: center'>{$row['anio_estreno']}</td>
                        <td style='text-align: center'>{$row['director']}</td>
                        <td style='text-align: center'><a href='{$row['url_trailer']}' target='_blank'>Ver trailer</a></td>
                        <td style='text-align: center'>{$row['genero_idgenero']}</td>
                        <td style='text-align: center'>{$row['idpais']}</td>
                        <td style='text-align: center'>{$row['iddistribuidora']}</td>
                        <td style='text-align: center'>{$row['likes']}</td>
                        <td>
                            <!-- Botón para editar el registro en el modal -->
                            <button type='button' class='btn btn-custom btn-custom-success' data-bs-toggle='modal' data-bs-target='#exampleModal' data-id='{$row['id']}' data-tit='{$row['titulo']}' data-des='{$row['descripcion']}' data-url_imagen='{$row['url_imagen']}' data-anio_estreno='{$row['anio_estreno']}' data-director='{$row['director']}' data-url_trailer='{$row['url_trailer']}' data-genero_idgenero='{$row['genero_idgenero']}' data-idpais='{$row['idpais']}' data-iddistribuidora='{$row['iddistribuidora']}' data-likes='{$row['likes']}'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <!-- Formulario para eliminar el registro -->
                            <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='txtid' value='{$row['id']}'>
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

        <!-- Modal para registrar y editar películas -->
        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario dentro del modal -->
                        <form method="POST" action="">
                            <div class="mb-3 d-none">
                                <label for="txtid" class="form-label">ID</label>
                                <input type="text" class="form-control" name="txtid" id="txtid">
                            </div>
                            <div class="mb-3">
                                <label for="txttit" class="form-label">Título</label>
                                <input type="text" class="form-control" name="txttit" id="txttit">
                            </div>
                            <div class="mb-3">
                                <label for="txtdes" class="form-label">Descripción</label>
                                <input type="text" class="form-control" name="txtdes" id="txtdes">
                            </div>
                            <div class="mb-3">
                                <label for="txturl_imagen" class="form-label">URL Imagen</label>
                                <input type="text" class="form-control" name="txturl_imagen" id="txturl_imagen">
                            </div>
                            <div class="mb-3">
                                <label for="txtanio_estreno" class="form-label">Año Estreno</label>
                                <input type="text" class="form-control" name="txtanio_estreno" id="txtanio_estreno">
                            </div>
                            <div class="mb-3">
                                <label for="txtdirector" class="form-label">Director</label>
                                <input type="text" class="form-control" name="txtdirector" id="txtdirector">
                            </div>
                            <div class="mb-3">
                                <label for="txturl_trailer" class="form-label">URL Trailer</label>
                                <input type="text" class="form-control" name="txturl_trailer" id="txturl_trailer">
                            </div>
                            <div class="mb-3">
                                <label for="txtgenero_idgenero" class="form-label">Género</label>
                                <input type="text" class="form-control" name="txtgenero_idgenero" id="txtgenero_idgenero">
                            </div>
                            <div class="mb-3">
                                <label for="txtidpais" class="form-label">País</label>
                                <input type="text" class="form-control" name="txtidpais" id="txtidpais">
                            </div>
                            <div class="mb-3">
                                <label for="txtiddistribuidora" class="form-label">Distribuidora</label>
                                <input type="text" class="form-control" name="txtiddistribuidora" id="txtiddistribuidora">
                            </div>
                            <div class="mb-3 d-none">
                                <label for="txtlikes" class="form-label">Likes</label>
                                <input type="text" class="form-control" name="txtlikes" id="txtlikes">
                            </div>
                            <!-- Botones para enviar el formulario o cerrar el modal -->
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

        <!-- Scripts necesarios para el funcionamiento de DataTables y Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
        <script>
            $(document).ready(function () {
                // Inicializa DataTables para la tabla
                $('#example').DataTable();

                // Configura el modal para mostrar los datos del registro a editar
                $('#exampleModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Botón que activó el modal
                    var id = button.data('id'); // Extrae la información de los atributos data-*
                    var tit = button.data('tit');
                    var des = button.data('des');
                    var url_imagen = button.data('url_imagen');
                    var anio_estreno = button.data('anio_estreno');
                    var director = button.data('director');
                    var url_trailer = button.data('url_trailer');
                    var genero_idgenero = button.data('genero_idgenero');
                    var idpais = button.data('idpais');
                    var iddistribuidora = button.data('iddistribuidora');
                    var likes = button.data('likes');

                    var modal = $(this);
                    // Rellena los campos del formulario en el modal con la información del registro
                    modal.find('#txtid').val(id || '');
                    modal.find('#txttit').val(tit || '');
                    modal.find('#txtdes').val(des || '');
                    modal.find('#txturl_imagen').val(url_imagen || '');
                    modal.find('#txtanio_estreno').val(anio_estreno || '');
                    modal.find('#txtdirector').val(director || '');
                    modal.find('#txturl_trailer').val(url_trailer || '');
                    modal.find('#txtgenero_idgenero').val(genero_idgenero || '');
                    modal.find('#txtidpais').val(idpais || '');
                    modal.find('#txtiddistribuidora').val(iddistribuidora || '');
                    modal.find('#txtlikes').val(likes || '');

                    // Configura el título y los botones del modal según si se está editando o creando un nuevo registro
                    if (id) {
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
                return confirm('¿Deseas eliminar este registro?');
            }
        </script>
    </div>
</body>
</html>
