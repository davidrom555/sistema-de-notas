<?php
require_once 'usuario.php';
require_once 'RepositorioUsuario.php';
session_start();

  $admin = $_POST['admin'];
  $email = $_POST['email'];
  $estado = $_POST['estado'];

  $error = false;
  $errorEmail = false;

  echo($admin);
  echo "<br>";
  echo($email);
  echo "<br>";
  echo($estado);

  $r = new RepositorioUsuario();

  if(is_null($admin) || is_null($email) || is_null($estado)) {
    echo "<span>Llena todos los campos!</span>";
    $error = true;
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     echo "<span> La dirección de email no es válida!</span>";
     $errorEmail = true;
  }
  else if($errorEmail == false)
  {
    $c = $r->modificarEstado($email, $estado, $admin);
    echo "<script> alert('Modificado Exitosamente') </script>";
    echo "<script> window.location = 'indexTareas.php' </script> ";
  }
?>
