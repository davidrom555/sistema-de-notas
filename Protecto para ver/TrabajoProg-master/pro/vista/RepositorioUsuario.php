<?php
require_once '../datos/conexion.php';
require_once 'usuario.php';

class RepositorioUsuario extends conexion
{
    public function ValidarEmail($e)
    {
      $email = $e;
      self::$conexion->beginTransaction();
      $validar = self::$conexion->prepare(
          "SELECT mail FROM usuarios WHERE mail=?"
      );
      $validar->execute([$email]);
      self::$conexion->commit();
      $v = $validar->fetch();
      return $v["mail"];
    }

    public function guardarUsuarioEnBD(Usuario$e)
    {
        if(is_null(self::$conexion)) {
            return "Error al agregar el usuario. Mensaje: " . self::$error_conexion;
        }

        try {
            //Iniciamos una transacción, que luego deberemos confirmar (commit)
            //o deshacer (rollback):
            self::$conexion->beginTransaction();

            //Preparamos la sentencia INSERT, con dos parámetros, a los que
            //llamamos :e y :d
            $insercion = self::$conexion->prepare(
                "INSERT INTO usuarios (nombre,mail, clave, activo, ultimo_ingreso) VALUES (:n,:e, :d, 1, :ui);"
            );
            //La clase PDO (de la que self::$conexion es una instancia), tiene un
            // método llamado prepare, que invocamos en este momento.

            //Le asignamos valor a los parámetros :e, :n y :d
            $insercion -> bindValue(':n',$e->getnombre());
            $insercion -> bindValue(':e',$e->getemail());
            $insercion -> bindValue(':d',$e->getpass());
            $insercion -> bindValue(':ui',$e->getUltimoLog());

            //Ejecutamos la sentencia preparada antes, y así insertamos el
            // nuevo equipo:
            $insercion->execute();

            //Si llegado este punto no se ha lanzado la excepción, confirmamos:
            self::$conexion->commit();
            return "El usuario fue agregado";
        }
        catch (PDOException $e) {
            // Si estamos aquí es porque lanzó la excepción. Cancelamos:
            self::$conexion->rollback();
            // y retornamos el error:
            return "Error al agregar el usuario." . self::$error_conexion . " " . $e->getMessage();
        }
    }

    public function Seleccionando($email)
    {
      if(is_null(self::$conexion))
      {
        return self::SERVIDOR . self::$error_conexion;
      }
      try
      {
        self::$conexion->beginTransaction();
        $seleccionar = self::$conexion->prepare(
        "SELECT id, nombre, mail, activo, es_administrador, clave, ultimo_ingreso FROM usuarios WHERE mail = :e");
        $seleccionar -> bindValue(':e',$email);
        $seleccionar->execute();
        $seleccionar->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $seleccionar->fetch();
        return $resultados;
      }
      catch (PDOException $e)
      {
        // Si estamos aquí es porque lanzó la excepción. Cancelamos:
        self::$conexion->rollback();
        // y retornamos el error:
        return "Error al iniciar sesion." . self::$error_conexion . " " . $e->getMessage();
      }
    }

    public function ActualizarLog($email)
    {
      $fecha = date("Y-m-d", time());
      if(is_null(self::$conexion))
      {
        return self::SERVIDOR . self::$error_conexion;
      }
      try
      {
        $s = self::$conexion->prepare(
        "UPDATE usuarios SET ultimo_ingreso = '$fecha' WHERE mail = :e;");
        $s-> bindValue(':e', $email);
        $s->execute();
        return $email;
      }
      catch (PDOException $e)
      {
        // Si estamos aquí es porque lanzó la excepción. Cancelamos:
        self::$conexion->rollback();
        // y retornamos el error:
        return "Error al iniciar sesion." . self::$error_conexion . " " . $e->getMessage();
      }
    }

    public function modificar($nombre, $email, $emailAnterior)
    {
      if(is_null(self::$conexion))
      {
        return self::SERVIDOR . self::$error_conexion;
      }
      try
      {
        $s = self::$conexion->prepare(
        "UPDATE usuarios SET nombre = :n, mail= :m  WHERE mail = :e;");
        $s-> bindValue(':e', $emailAnterior);
        $s-> bindValue(':n', $nombre);
        $s-> bindValue(':m', $email);
        $s->execute();
        return $email;
      }
      catch (PDOException $e)
      {
        // Si estamos aquí es porque lanzó la excepción. Cancelamos:
        self::$conexion->rollback();
        // y retornamos el error:
        return "Error al iniciar sesion." . self::$error_conexion . " " . $e->getMessage();
      }
    }
    public function getAll($Uid)
    {

       if(is_null(self::$conexion)) {
           return "Error al seleccionar usuarios. Mensaje: " . self::$error_conexion;
       }
       try {
           $t = [];

           $sql = "SELECT id, nombre, mail, clave, ultimo_ingreso, es_administrador, activo FROM usuarios where id <> '$Uid' ";
           $r = self::$conexion->query($sql, PDO::FETCH_ASSOC);

           while ( $fila = $r->fetch() ) {
               $t[] = new usuario($fila['nombre'],
                                 $fila['mail'],
                                 $fila['clave'],
                                 $fila['ultimo_ingreso'],
                                 $fila['activo'],
                                 $fila['es_administrador']
                               );
           }
           return $t;
       }
       catch (PDOException $e) {
           $error =  "Error al consultar" . self::$error_conexion;
           $error.= $e->getMessage();
           return $error;
       }
   }
   public function modificarEstado($email, $estado, $admin)
   {
     if(is_null(self::$conexion))
     {
       return self::SERVIDOR . self::$error_conexion;
     }
     try
     {
       $s = self::$conexion->prepare(
       "UPDATE usuarios SET activo= :e, es_administrador= :a  WHERE mail = :m;");
       $s-> bindValue(':e', $estado);
       $s-> bindValue(':a', $admin);
       $s-> bindValue(':m', $email);
       $s->execute();
       return true;
     }
     catch (PDOException $e)
     {
       // Si estamos aquí es porque lanzó la excepción. Cancelamos:
       self::$conexion->rollback();
       // y retornamos el error:
       return "Error al iniciar sesion." . self::$error_conexion . " " . $e->getMessage();
     }
   }

}
