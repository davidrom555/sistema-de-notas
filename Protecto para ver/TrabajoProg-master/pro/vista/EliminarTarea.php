<?php
require_once 'RepositorioTarea.php';
$r = new RepositorioTarea();
$IDtarea = $_POST['IDTarea'];
$tarea = $r->getOne($IDtarea);

if (!is_a($tarea, "Tarea")) die($tarea);

//Eliminamos la tarea:
$x =  $r->eliminar($tarea);
if ( $x === true) {
    echo '<script>alert("Eliminado correctamente");</script>';
    echo "<meta http-equiv='refresh' content='0'>";
}
else {
    echo '<script>alert($x);</script>';
}
