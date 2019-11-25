<?php
require_once 'usuario.php';
require_once 'RepositorioUsuario.php';
session_start();

  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $emailAnterior = $_SESSION['email'];

  $error = false;
  $errorEmail = false;

  $e = new usuario($nombre,$email, null, null, null, null);
  $r = new RepositorioUsuario();

  if(empty($nombre) || empty($email) ) {
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
  else if(!preg_match('/^[a-zA-Z,]+$/', $nombre))
  {
    echo "<span> Tu nombre contiene caracteres no permitidos! </span>";
    $error = true;
  }
  else if($error == false && $errorEmail == false)
  {
    $c = $r->modificar($nombre, $email, $emailAnterior);
    $_SESSION['email'] = $email;
    $_SESSION['nombre'] = $nombre;
    echo "<script> alert('Modificado Exitosamente') </script>";
    echo "<script> window.location = 'indexTareas.php' </script> ";
  }
?>
