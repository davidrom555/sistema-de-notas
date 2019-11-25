<?php
require_once 'RepositorioTarea.php';
require_once 'RepositorioUsuario.php';
session_start();
if(isset($_POST['IDTarea']))
{
  $RT = new RepositorioTarea();
  $T = $RT->getOne($_POST['IDTarea']);
}
if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1)
{
  $ru = new RepositorioUsuario();
  $ua = $ru->getAll($_SESSION['id']);
  if (! is_array($ua)) die($ua);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div style="margin: 20px" id='Agregar'>
      <center>
        <img src="images/AgregarTarea.png" width="80" height="85">
        <div class="col-sm-4 col-md-4 col-lg-3">
        <h3 class="color">Agregar Tarea</h3>
        <form action ="agregarTarea.php" id="AgT" method="POST">
        <div class="form-group">
        <textarea required placeholder="Describe tu tarea" rows="2" cols="20" name="texto" class="form-control" id="AG-texto"></textarea>
        </div>
        <div class="form-group">
        <input type="text" name="etiquetas" class="form-control"  id="AG-etiquetas" placeholder="Etiquetas">
        </div>
        <div class="form-group">
          <select name="estado" class="form-control"  id="AG-estado">
            <option value="1">Pendiente</option>
            <option value="2">En Proceso</option>
            <option value="3">Finalizada</option>
            <option value="4">Cancelada</option>
          </select>
        </div>
        <div class="form-group">
        <p>Fecha de Alarma (opcional)</p>
        <input type="date" name="fecha" class="form-control"  id="AG-fecha">
        </div>
        <button type="submit" id="form-submit" value="Agregar" class="btn btn-success btn-block">Agregar Tarea</button>
        <br>
        <p id="test"></p>
        </form>
        <br>
        </div>
      </center>
    </div>
    <div style="margin: 20px" id='Ajustes'>
      <center>
        <img src="images/USettings.png" width="80" height="85">
        <div class="col-sm-4 col-md-4 col-lg-3">
        <h3 class="color">Ajustes</h3>
        <form action ="agregarTarea.php" id="UserSet" method="POST">
        <div class="form-group">
        <input type="text" name="nombre" class="form-control"  id="US-nombre" value="<?php echo $_SESSION['nombre']; ?>">
        </div>
        <div class="form-group">
        <input type="email" name="email" class="form-control"  id="US-email" value="<?php echo $_SESSION['email']; ?>">
        </div>
        <button type="submit" id="form-submit" value="Agregar" class="btn btn-success btn-block">Cambiar Datos Personales</button>
        <br>
        <p id="test"></p>
        </form>
        <br>
        </div>
      </center>
    </div>

    <div style="margin: 20px" id='Buscar'>
      <center>
        <img src="images/BuscarTarea.png" width="80" height="85">
        <div class="col-sm-4 col-md-4 col-lg-3">
        <h3 class="color">Buscar Tarea</h3>
        <form action ="agregarTarea.php" id="BuscarT" method="POST">
        <div class="form-group">
        <p> Buscar Por: <p>
        <select name="estado" class="form-control"  id="Buscar-tipo">
          <option value="1">Texto</option>
          <option value="2">Etiquetas</option>
        </select>
        </div>
        <div class="form-group">
        <textarea required placeholder="Describe tu tarea" rows="2" cols="20" name="texto" class="form-control" id="Buscar-texto"></textarea>
        </div>
        <button type="submit" id="form-submit" value="Buscar" class="btn btn-success btn-block">Buscar</button>
        <br>
        </div>
        <div>
        <p id="test"></p>
        </form>
        <br>
        </div>
      </center>
    </div>

    <div style="margin: 20px" id='AdminSettings'>
      <center>
        <img src="images/USettings.png" width="80" height="85">
        <div class="col-sm-4 col-md-4 col-lg-3">
        <h3 class="color">Ajustes de Administrador</h3>
        <form action ="agregarTarea.php" id="AdminStt" method="POST">
        <div class="form-group">
        <p>Email de la cuenta</p>
        <select name="lista" class="form-control"  id="Admin-lista">
          <?php
          foreach ( $ua as $unUsuario )
          {
            echo '<option value="'.$unUsuario->getemail().'">'.$unUsuario->getemail().'</option>';
          }
          ?>
        </select>
        </div>
        <div class="form-group">
        <p>Privilegios</p>
        <select name="estado" class="form-control"  id="Admin-admin">
          <option value="0">Usuario Normal</option>
          <option value="1">Administrador</option>
        </select>
        </div>
        <div class="form-group">
        <p>Estado de la Cuenta</p>
        <select name="estado" class="form-control"  id="Admin-estado">
          <option value="1">Activada</option>
          <option value="0">Desactivada</option>
        </select>
        </div>
        <button type="submit" id="form-submit" value="Agregar" class="btn btn-success btn-block">Cambiar Datos</button>
        <br>
        <p id="test"></p>
        </form>
        <br>
        </div>
      </center>
    </div>
    <div style="margin: 20px" id='Modificar'>
      <center>
        <h3 class="color">Modificar Tarea</h3>
        <img src="images/ModificarTarea.png" width="80" height="85">
        <div class="col-sm-4 col-md-4 col-lg-3">
        <br>
        <form action="ModificarTarea.php" method="POST" id="ModT">
        <div class="form-group">
        <input type="hidden" id="MD-IDT" value="<?php echo $_POST['IDTarea']?>"/>
        </div>
        <div class="form-group">
        <p class="font-weight-bold"> Texto </p>
        <?php
        echo '<textarea rows="2" cols="20""  name="texto" class="form-control" id="MD-texto">' . $T->getTexto(). '</textarea>';
         ?>
        </div>
        <div class="form-group">
        <p class="font-weight-bold">Etiquetas</p>
        <?php
        echo '<input type="text" name="etiquetas" class="form-control"  id="MD-etiquetas"  value="' . $T->getEtiquetas() . '">'
        ?>
        </div>
        <div class="form-group">
        <select name="estado" class="form-control"  id="MD-estado">
          <option value="1">Pendiente</option>
          <option value="2">En Proceso</option>
          <option value="3">Finalizada</option>
          <option value="4">Cancelada</option>
        </select>
        </div>
        <div class="form-group">
        <p>Fecha de Alarma (opcional)</p>
        <input type="date" name="fecha" class="form-control"  id="MD-fecha">
        </div>
        <button type="submit" value="Modificar" class="btn btn-success btn-block">Modificar</button>
        <br>
        <p id="test"></p>
        </form>
        <br>
        </div>
      </center>
    </div>
  </body>
</html>
