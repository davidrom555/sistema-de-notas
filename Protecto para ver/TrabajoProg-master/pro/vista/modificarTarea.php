<?php
require_once 'Tarea.php';
require_once 'RepositorioTarea.php';
session_start();
if(empty($_POST['fecha']))
{
  $fecha = NULL;
}
else {
  $fecha = $_POST['fecha'];
}
if(empty($_POST['etiquetas']))
{
  $etiquetas = NULL;
}
else {
  $etiquetas = $_POST['etiquetas'];
}
$texto = $_POST['texto'];
$fechaC = date("Y-m-d", time());
$id = $_POST['IDTarea'];
$estado = $_POST['estado'];
$id_usuario = $_SESSION['id'];
$error = false;

if(empty($texto) || empty($estado))
{
  echo "<span> Llena todos los campos requeridos </span> ";
  $error = true;
}
else if(!empty($fecha) && $fechaC > $fecha )
{
  echo "<span> La fecha elegida para la alarma es invalida";
  $error = true;
}
else if(!empty($etiquetas) && !preg_match('/^[a-zA-Z]+(, [a-zA-Z]+)*$/', $etiquetas))
{
  echo "<span> Etiquetas invalidas </span>";
  $error = true;
}
else if(!preg_match('/^[a-zA-Z]+( [a-zA-Z]+)*$/', $texto))
{
  echo "<span> La descripcion de la tarea contiene caracteres no permitidos </span>";
  $error = true;
}
else if($error === false)
{
  $c = new Tarea($texto, $fechaC, $fecha, $etiquetas, $estado, $id_usuario, $id);
  $r = new RepositorioTarea();
  $r->modificar($c);
  echo "<script> alert('Modificado Exitosamente') </script>";
  echo "<script> window.location = 'indexTareas.php' </script> ";
}
?>
