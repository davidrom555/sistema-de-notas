<?php
require_once 'RepositorioUsuario.php';
session_start();
if (isset($_SESSION['email']))
{
	header("Location: indexTareas.php");
}

if ( ! empty( $_POST ) )
{
  if ( isset( $_POST['email'] ) && isset( $_POST['password'] ) )
	{
		$mail = $_POST['email'];
		$s = new RepositorioUsuario();
		$c = $s->Seleccionando($mail);
		{
			if($c['activo'] == 1)
			{
				if (password_verify($_POST['password'], $c['clave'] ))
				{
					$_SESSION['email'] = $c['mail'];
					$_SESSION['id'] = $c['id'];
					$_SESSION['nombre'] = $c['nombre'];
					$_SESSION['admin'] = $c['es_administrador'];
					$_SESSION['activo'] = $c['activo'];
					header('Location: indexTareas.php');
				}
			}
			else {
				echo "Cuenta Desactivada";
			}
		}


  }
}

?>

<!doctype html>

<html lang="es">
  <head>
    <title>Anotador</title>

	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css\bootstrap.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="css\estilo.css" rel="stylesheet" type="text/css"/>
  </head>
  <nav class="navbar navbar-dark bg-dark">
  <ul class="nav">
     <h2 font color="#FFFFFD">Sistema de notas de “tareas pendientes”</h2>

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
            <h3 class="color">Login</h3><br />
			<form action="" name="myForm" method="POST" onsubmit="return validateForm()">
		 	<div class="form-group">
				<input type="email" name="email" class="form-control" id="email"  required placeholder="Ingresa tu email">
		 	</div>
		 	<div class="form-group">
		 	<input type="password" name="password" class="form-control"  id="password" required placeholder="Contraseña">
		 	</div>

		 	 <button type="submit" value="Login" class="btn btn-success btn-block">Login</button>
		 	<br>
			<b><font color="#686464">¿No tenes cuenta?</b></font> <a href="index2.php"><font color="#FFFFFD">Crear cuenta</font></a>

			</form><br>
			<br>
		</div>
	</div>
    </center>


	</body>
</html>
