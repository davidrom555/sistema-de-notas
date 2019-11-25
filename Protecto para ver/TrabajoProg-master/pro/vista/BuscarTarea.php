<?php
require_once 'Tarea.php';
require_once 'RepositorioTarea.php';
session_start();

$texto = $_POST['texto'];
$estado = $_POST['estado'];
$id = $_SESSION['id'];
$error = false;
if($estado != 1 && $estado != 2)
{
  echo "<span> Hubo un error al buscar la tarea </span>";
  $error = true;
}
if($estado == 2 && !preg_match('/^[a-zA-Z]+(, [a-zA-Z]+)*$/', $texto))
{
  echo "<span> Etiquetas invalidas </span>";
  $error = true;
}
if($estado == 1 && !preg_match('/^[a-zA-Z]+( [a-zA-Z]+)*$/', $texto))
{
  echo "<span> La descripcion de la tarea contiene caracteres no permitidos </span>";
  $error = true;
}
else if($error === false)
{
  $r = new RepositorioTarea();
  if($estado == 1){
    $x = $r->buscartxt($texto, $id);
    if(empty($x))
    {
      echo "No existe una tarea con esa descripcion";
    }
    else{
      echo '<table border="2" class ="table table-hover table-primary">';
      echo '<tr>';
      echo '<th>Texto</th><th>Etiquetas</th>';
      echo '<th>Fecha de Creacion</th><th>Fecha de Alarma</th>';
      echo '<th>Estado</th>';
      echo '</tr>';
      foreach ( $x as $unaTarea ) {
        echo '<tr>';
        echo '<td >' . $unaTarea->getTexto() . '</td>';
        echo '<td >' . $unaTarea->getEtiquetas() . '</td>';
        echo '<td align="center">' . $unaTarea->GetFechaCreacion() . '</td>';
        echo '<td align="center">' . $unaTarea->getFecha() . '</td>';
        echo '<td align="center">' . $unaTarea->getEstadoString() . '</td>';


        //Agregamos dos enlaces, uno para modificar...
        $id =  $unaTarea->getID();
        echo "<td><a class='Tarea' id ='ModificarenDB' value='$id' href=''>Modificar <img src='images/ModificarTarea.png' width='50' height='50'></a> </td>";

        // ... y el otro para eliminar:
        $id =  $unaTarea->getID();
        echo "<td><a class='Tarea' id ='EliminardeDB' value ='$id' href=''>Eliminar <img src='images/EliminarTarea.png' width='50' height='50'> </td>";
        echo '</tr>';
      }
      echo '</table>';
    }
  }
  else if($estado == 2){
    $x = $r->buscartag($texto, $id);
    if(empty($x))
    {
      echo "No existe una tarea con esas etiquetas";
    }
    else{
      echo '<table border="2" class ="table table-hover table-primary">';
      echo '<tr>';
      echo '<th>Texto</th><th>Etiquetas</th>';
      echo '<th>Fecha de Creacion</th><th>Fecha de Alarma</th>';
      echo '<th>Estado</th>';
      echo '</tr>';
      foreach ( $x as $unaTarea ) {
        echo '<tr>';
        echo '<td >' . $unaTarea->getTexto() . '</td>';
        echo '<td >' . $unaTarea->getEtiquetas() . '</td>';
        echo '<td align="center">' . $unaTarea->GetFechaCreacion() . '</td>';
        echo '<td align="center">' . $unaTarea->getFecha() . '</td>';
        echo '<td align="center">' . $unaTarea->getEstadoString() . '</td>';


        //Agregamos dos enlaces, uno para modificar...
        $id =  $unaTarea->getID();
        echo "<td><a class='Tarea' id ='ModificarenDB' value='$id' href=''>Modificar <img src='images/ModificarTarea.png' width='50' height='50'></a> </td>";

        // ... y el otro para eliminar:
        $id =  $unaTarea->getID();
        echo "<td><a class='Tarea' id ='EliminardeDB' value ='$id' href=''>Eliminar <img src='images/EliminarTarea.png' width='50' height='50'> </td>";
        echo '</tr>';
      }
      echo '</table>';
    }
  }

}
?>
