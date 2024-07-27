<?php
	session_start(); // Inicia una nueva sesión o reanuda la sesión existente.
	if(isset($_SESSION['user'])){ // Verifica si hay una sesión activa con un usuario.
		header('location:index.php'); // Redirige al usuario a la página de inicio si ya está autenticado.
	}
?>

<?php include('header.php'); ?>  <!-- Incluye el archivo 'header.php' que contiene la estructura del encabezado, como los enlaces a estilos y scripts. -->
<body>
<div class="container">
	<div style="height:50px;">
	</div>
    <div class="row" id="loginform">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Acceso
                    	<span class="pull-right"><span class="glyphicon glyphicon-pencil"></span> <a style="text-decoration:none; cursor:pointer; color:white;" id="signup">Inscribirse</a></span>
                    </h3>
                </div>
            	<div class="panel-body">
                	<form role="form" id="logform">
                    	<fieldset>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus>
                        	</div>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Password" name="password" id="password" type="password">
                        	</div>
                        	<button type="button" id="loginbutton" class="btn btn-lg btn-primary btn-block"><span class="glyphicon glyphicon-log-in"></span> <span id="logtext">Ingresar</span></button>
                    	</fieldset>
                	</form>
            	</div>
            </div>
        </div>
    </div>

    <div class="row" id="signupform" style="display:none;">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Inscribirse
                    	<span class="pull-right"><span class="glyphicon glyphicon-log-in"></span> <a style="text-decoration:none; cursor:pointer; color:white;" id="login">Acceso</a></span>
                    </h3>
                </div>
            	<div class="panel-body">
                	<form role="form" id="signform">
                    	<fieldset>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Username" name="susername" id="susername" type="text" autofocus>
                        	</div>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Password" name="spassword" id="spassword" type="password">
                        	</div>
                        	<button type="button" id="signupbutton" class="btn btn-lg btn-primary btn-block"><span class="glyphicon glyphicon-check"></span> <span id="signtext">Inscribirse</span></button>
                    	</fieldset>
                	</form>
            	</div>
            </div>
        </div>
    </div>

    <div id="myalert" style="display:none;">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="alert alert-info"> 
    			<center><span id="alerttext"></span></center> 
    		</div>
   	 	</div>
    </div>
</div>
<script src="custom.js"></script>
</body>
</html>
