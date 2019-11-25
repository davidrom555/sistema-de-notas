<?php
require_once 'RepositorioTarea.php';
require_once 'Tarea.php';
require_once 'RepositorioUsuario.php';
session_start();
if (!isset($_SESSION['email']))
{
    header("Location: index.php");
    die();
}
else
{
  $ru = new RepositorioUsuario();
  $li = $ru->ActualizarLog($_SESSION['email']);
  $t = new RepositorioTarea();
  $tl = $t->getAll($_SESSION['id']);
  if (! is_array($tl)) die($tl);
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css\bootstrap.css" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="css\estilo.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/MenuTareas.js"></script>

  <title>Menu  de Tareas</title>
  </head>

<nav class="navbar navbar-center navbar-expand-lg navbar-dark bg-dark">
  <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
    <div class="navbar-nav">
      <a class="nav-item nav-link" id="RevisarT" href="">Revisar Tareas<img src="images/logo2.png" width="50" height="50"></a>
      <a>&nbsp;&nbsp;&nbsp;&nbsp;</a>
      <a class="nav-item nav-link" id="BuscarT" href="">Buscar Tarea<img src="images/BuscarTarea.png" width="50" height="50"></a>
      <a>&nbsp;&nbsp;&nbsp;&nbsp;</a>
      <a class="nav-item nav-link" id="AgregarT" href="">Agregar Tarea<img src="images/AgregarTarea.png" width="50" height="50"></a>
      <a>&nbsp;&nbsp;&nbsp;&nbsp;</a>
      <?php
        if(isset($_SESSION['admin']))
        {
          if($_SESSION['admin'] == 1)
          {
            echo "<a class='nav-item nav-link' id='AdminOp' href=''>Modificar Usuarios<img src='images/AdminSettings.png' width='50' height='50'></a>";
            echo "<a>&nbsp;&nbsp;&nbsp;&nbsp;</a>";
          }
        }
      ?>
      <a class="nav-item nav-link" id="Usettings" href="">Ajustes de Usuario<img src="images/USettings.png" width="50" height="50"></a>
      <a>&nbsp;&nbsp;&nbsp;&nbsp;</a>
      <a class="nav-link" id="SesionE" href="CerrarSesion.php">Cerrar Sesion<img src="images/logout.png" width="50" height="50"></a>
    </div>
  </div>
</nav>

<body>
    <div class="container" id="contenido">
    <center>
    <h1>Tareas</h1>
    <div class="table-responsive">
    <table border="2" class ="table table-hover table-sm table-primary">
        <tr>
            <th>Texto</th><th>Etiquetas</th>
            <th>Fecha de Creacion</th><th>Fecha de Alarma</th>
            <th>Estado</th>
        </tr>
<?php
foreach ( $tl as $unaTarea ) {
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
?>
    </table>
    <p id="test"></p>
  </div>
</div>
</body>
</html>
