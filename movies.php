<?php 
    require_once 'conn.php'; // Incluye el archivo 'conn.php' para establecer la conexión a la base de datos.
    require_once 'login.php'; // Incluye el archivo 'login.php' para la gestión de sesiones y autenticación.

    if (isset($_POST['liked'])) { // Verifica si se ha enviado una solicitud para dar un "me gusta".
        $pelid = $_POST['pelid']; // Obtiene el ID de la película desde la solicitud POST.
        
        // Consulta la base de datos para obtener la película correspondiente.
        $result = mysqli_query($conn, "SELECT * FROM pelicula WHERE id=$pelid");
        $row = mysqli_fetch_array($result); // Obtiene la fila de resultados como una matriz.
        $n = $row['likes']; // Obtiene el número actual de "me gusta" para la película.

        // Inserta un nuevo registro en la tabla 'likes' para el usuario y la película.
        mysqli_query($conn, "INSERT INTO likes (pelid, userid) VALUES ($pelid,{$_SESSION['user']})");
        
        // Incrementa el número de "me gusta" en la base de datos.
        mysqli_query($conn, "UPDATE pelicula SET likes=$n+1 WHERE id=$pelid");
        
        echo $n+1; // Devuelve el nuevo número de "me gusta" para actualizar la interfaz.
        exit(); // Sale del script para evitar la ejecución de código adicional.
    }

    if (isset($_POST['unliked'])) { // Verifica si se ha enviado una solicitud para eliminar un "me gusta".
        $pelid = $_POST['pelid']; // Obtiene el ID de la película desde la solicitud POST.
        
        // Consulta la base de datos para obtener la película correspondiente.
        $result = mysqli_query($conn, "SELECT * FROM pelicula WHERE id=$pelid");
        $row = mysqli_fetch_array($result); // Obtiene la fila de resultados como una matriz.
        $n = $row['likes']; // Obtiene el número actual de "me gusta" para la película.

        // Elimina el registro correspondiente de la tabla 'likes'.
        mysqli_query($conn, "DELETE FROM likes WHERE pelid=$pelid AND userid={$_SESSION['user']}");
        
        // Decrementa el número de "me gusta" en la base de datos.
        mysqli_query($conn, "UPDATE pelicula SET likes=$n-1 WHERE id=$pelid");
        
        echo $n-1; // Devuelve el nuevo número de "me gusta" para actualizar la interfaz.
        exit(); // Sale del script para evitar la ejecución de código adicional.
    }

    // Consulta para obtener información sobre las películas junto con datos relacionados de otras tablas.
    $pelicula = mysqli_query($conn,"SELECT pelicula.id, 
    pelicula.titulo, pelicula.descripcion, pelicula.url_imagen,
    pelicula.anio_estreno,pais.nombre_pais, pelicula.director, 
    pelicula.url_trailer, pelicula.likes, genero.nombre_genero, distribuidora.nombre_empresa

    FROM pelicula  
    
    LEFT JOIN genero
    ON pelicula.genero_idgenero = genero.idgenero   

    LEFT JOIN pais
    ON pelicula.idpais = pais.idpais 

    LEFT JOIN distribuidora
    ON pelicula.iddistribuidora = distribuidora.iddistribuidora 
    "); 

    //echo '<pre>', print_r($peliculas, true), '</pre>'; 
    //die(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peliculas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <style>
        .like, .unlike, .likes_count {
            color: blue;
        }
        .hide {
            display: none;
        }
        .fa-thumbs-up, .fa-thumbs-o-up {
            transform: rotateY(-180deg);
            font-size: 1.3em;
        }
    </style>
</head>
<body>

    <?php while ($row = mysqli_fetch_array($pelicula)) { // Recorre cada fila de resultados de la consulta de películas ?>
        <div class="pelicula">
            <div class="container-fluid">
                <div class="row mt-4">
                    <h1><?php echo $row['titulo']; // Muestra el título de la película ?></h1> 

                    <div class="col-8 col-sm-7 col-md-3">
                        <img src="<?php echo $row['url_imagen'] ?>" alt="" width="100%" height="500">
                    </div>

                    <div class="col-12 col-sm-5 col-md-2">
                        <p>Género: <?php echo $row['nombre_genero']; ?></p>
                        <p>Pais: <?php echo $row['nombre_pais']; ?></p>
                        <p>Año de estreno: <?php echo $row['anio_estreno']; ?></p>
                        <p>Dirigida por: <?php echo $row['director']; ?></p>
                        <p>Distribuida por: <?php echo $row['nombre_empresa']; ?></p>
                        <a class="btn btn-primary mt-3" href="<?php echo $row['url_trailer']; ?>" target="_blank" role="button">Ver Trailer</a>
                    </div>

                    <div class="col-12 col-sm-8 col-md-5">
                        <h3 class="mt-3">SINOPSIS</h3>
                        <p><?php echo $row['descripcion']; ?></p>
                    </div>

                    <div class="col-12 col-sm-3 col-md-2">
                        <p>jijrijrijriji</p>

                        <?php 
                        // Consulta si el usuario ya ha dado "me gusta" a la película.
                        $results = mysqli_query($conn, "SELECT * FROM likes WHERE userid={$_SESSION['user']} AND pelid=".$row['id']."");
                        
                        if (mysqli_num_rows($results) == 1): ?>
                            <!-- El usuario ya ha dado "me gusta" a la película -->
                            <span class="unlike fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span> 
                            <span class="like hide fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span> 
                        <?php else: ?>
                            <!-- El usuario no ha dado "me gusta" a la película -->
                            <span class="like fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span> 
                            <span class="unlike hide fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span> 
                        <?php endif ?>

                        <span class="likes_count"><?php echo $row['likes']; ?> likes</span>
                    </div>
                </div>
            </div>    
        </div>
    <?php } ?>

<script src="jquery.min.js"></script>
<script>
    $(document).ready(function(){
        // Cuando el usuario hace clic en "me gusta"
        $('.like').on('click', function(){
            var pelid = $(this).data('id'); // Obtiene el ID de la película
            $post = $(this);

            $.ajax({
                url: 'movies.php',
                type: 'post',
                data: {
                    'liked': 1,
                    'pelid': pelid
                },
                success: function(response){
                    $post.parent().find('span.likes_count').text(response + " likes"); // Actualiza el conteo de "me gusta"
                    $post.addClass('hide'); // Oculta el ícono de "me gusta"
                    $post.siblings().removeClass('hide'); // Muestra el ícono de "no me gusta"
                }
            });
        });

        // Cuando el usuario hace clic en "no me gusta"
        $('.unlike').on('click', function(){
            var pelid = $(this).data('id'); // Obtiene el ID de la película
            $post = $(this);

            $.ajax({
                url: 'movies.php',
                type: 'post',
                data: {
                    'unliked': 1,
                    'pelid': pelid
                },
                success: function(response){
                    $post.parent().find('span.likes_count').text(response + " likes"); // Actualiza el conteo de "me gusta"
                    $post.addClass('hide'); // Oculta el ícono de "no me gusta"
                    $post.siblings().removeClass('hide'); // Muestra el ícono de "me gusta"
                }
            });
        });
    });
</script>

</body>
</html>
