<?php
require_once 'usuario.php';
require_once 'RepositorioUsuario.php';

if(isset($_POST['submit'])) {
  $nombre = $_POST['nombre'];
  $email= $_POST['email'];
  $pass = $_POST['password'];
  $hashpass = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $passconfirm = $_POST['passconfirm'];
  $fecha = date("Y-m-d", time());

  $error = false;
  $errorEmail = false;
  $errorPass = false;

  $e = new usuario($nombre,$email, $hashpass, $fecha, null, null);
  $r = new RepositorioUsuario();

  if(empty($nombre) || empty($pass) || empty($email) ) {
    echo "<span>Llena todos los campos!</span>";
    $error = true;
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     echo "<span> La dirección de email no es válida!</span>";
     $errorEmail = true;
  }
  else if($r->ValidarEmail($email) == $email)
  {
    echo "<span> Ya existe un usuario con su email </span>";
    $errorEmail = true;

  }
  else if($pass != $passconfirm)
  {
    echo "<span>Las contraseñas no coinciden!</span>";
    $errorPass = true;
  }
  else if(strlen($pass) < 8 )
  {
    echo "<span> Tu contraseña debe tener al menos 8 caracteres! </span>";
    $error = true;
  }
  else if(!preg_match('/^[a-zA-Z,]+$/', $nombre))
  {
    echo "<span> Tu nombre contiene caracteres no permitidos! </span>";
    $error = true;
  }
  else if($error == false && $errorPass == false && $errorEmail == false)
  {
    echo $r->guardarUsuarioEnBD($e);
    $c = $r->Seleccionando($email);
    session_start();
    $_SESSION['email'] = $c['mail'];
    $_SESSION['id'] = $c['id'];
    $_SESSION['nombre'] = $c['nombre'];
    echo "<script> window.location = 'indexTareas.php' </script> ";
  }
}
?>
