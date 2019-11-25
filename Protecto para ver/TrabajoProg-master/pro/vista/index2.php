<?php
session_start();
if (isset($_SESSION['email']))
{
    echo $_SESSION['email'];
    echo $_SESSION['id'];
    header("Location: indexTareas.php");
}

?>
<!doctype html>

<html lang="es">
  <head>
    <title>Anotador</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="css\bootstrap.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="css\estilo.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

		<script>
			$(document).ready(function() {
				$("form").submit(function(event) {
						event.preventDefault();
						var nombre = $("#form-nombre").val();
						var email = $("#form-email").val();
						var password = $("#form-password").val();
						var passconfirm = $("#form-passconfirm").val();
						var submit = $("#form-submit").val();
						$( ".mensaje" ).load("insertUsuario.php", {
							nombre: nombre,
							email: email,
							password: password,
							passconfirm: passconfirm,
							submit: submit
						} );
				});
			});
		</script>

  </head>
  <nav class="navbar navbar-dark bg-dark">
  <ul class='nav'>
     <h2 class="color">Sistema de notas de “tareas pendientes”</h2>

  </ul>
  <ul>
  	<img src="images/logo1.png" width="150" height="70">
  </ul>



</nav>
  <body>
  	<center>
  		<div style="margin: 20px">
  		<img src="images/logo2.png" width="100" height="100">
         <div class="col-sm-4 col-md-4 col-lg-3"><br>
            <h3 class="color">Registrarse</h3><br />
			<form action="insertUsuario.php" method="POST" id="registro">
			<div class="form-group">
				<input type="text" name="nombre" class="form-control" id="form-nombre" autofocus required placeholder="Ingresa tu nombre">
		 	</div>
		 	<div class="form-group">
				<input type="email" name="email" class="form-control" id="form-email" required placeholder="Ingresa tu dirección de e-mail">
		 	</div>
		 	<div class="form-group">
		 	<input type="password" name="pass" class="form-control" id="form-password" required placeholder="Ingresa tu contraseña">
		 	</div>
			<div class="form-group">
			<input type="password" name="passconfirm" class="form-control" id="form-passconfirm" required placeholder="Confirma tu contraseña">
			</div>
		 	<button id="form-submit" type="submit" value="Registrarse" class="btn btn-success btn-block">Registrarse</button>
			</form>
      <p class="mensaje"></p>
			<br>
		</div>
	</div>
    </center>


	</body>
</html>
