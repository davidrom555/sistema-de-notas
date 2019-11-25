<?php
require_once '../datos/conexion.php';
require_once 'Tarea.php';

class RepositorioTarea extends conexion
{

    public function guardarTareaEnBD(Tarea$e)
    {

        /**
         * Guarda el equipo recibido en la BD
         *
         * Recibe como parámetro un equipo y lo guarda en la BD
         * Retorna un string con un mensaje de éxito o fracaso.
         */
        if(is_null(self::$conexion)) {
            return "Error al agregar la tarea. Mensaje: " . self::$error_conexion;
        }
        try {
            //Iniciamos una transacción, que luego deberemos confirmar (commit)
            //o deshacer (rollback):
            self::$conexion->beginTransaction();

            //Preparamos la sentencia INSERT, con dos parámetros, a los que
            //llamamos :e y :d
            $insercion = self::$conexion->prepare(
                "INSERT INTO tareas (texto, fecha_creacion, etiquetas, fecha_alarma, id_usuario, estados_id) VALUES (:t,:fc,:et,:fa,:idu, :ei);"
            );
            //La clase PDO (de la que self::$conexion es una instancia), tiene un
            // método llamado prepare, que invocamos en este momento.

            //Le asignamos valor a los parámetros :e y :d
            $insercion -> bindValue(':t',$e->getTexto());
            $insercion -> bindValue(':fc',$e->getFechaCreacion());
            $insercion -> bindValue(':et',$e->getEtiquetas());
            $insercion -> bindValue(':fa',$e->getFecha());
            $insercion -> bindValue(':idu',$e->getIDUsuario());
            $insercion -> bindValue(':ei',$e->getEstado());

            //Ejecutamos la sentencia preparada antes, y así insertamos el
            // nuevo equipo:
            $insercion->execute();

            //Si llegado este punto no se ha lanzado la excepción, confirmamos:
            self::$conexion->commit();
            return "La Tarea fue agregada";
        }
        catch (PDOException $e) {
            // Si estamos aquí es porque lanzó la excepción. Cancelamos:
            self::$conexion->rollback();
            // y retornamos el error:
            return "Error al agregar la tarea." . self::$error_conexion . " " . $e->getMessage();
        }
    }

    public function getOne($tarea)
    {
        if(is_null(self::$conexion)) {
            return "Error al agregar el equipo. Mensaje: " . self::$error_conexion;
        }
        try {
            // Preparamos la consulta:
            $s = self::$conexion->prepare(
                "SELECT id, texto, etiquetas, fecha_creacion, fecha_alarma, estados_id, id_usuario FROM tareas
                WHERE id = ?"
            );
            $s->execute([ $tarea]);

            //Si el equipo fue encontrado en la BD, creamos con estos datos un
            //objeto equipo y lo retornamos.
            if ( $fila = $s->fetch()) {
                return new Tarea($fila['texto'],
                                  $fila['fecha_creacion'],
                                  $fila['fecha_alarma'],
                                  $fila['etiquetas'],
                                  $fila['estados_id'],
                                  $fila['id_usuario'],
                                  $fila['id']
                                );
            }
            else {
                //Si no fue encontrado, retornamos un mensaje:
                return "No existe la tarea $tarea";
            }

        }
        catch (PDOException $e) {
            $error =  "Error al consultar" . self::$error_conexion;
            $error.= $e->getMessage();
            return $error;
        }

    }


    public function getAll($Uid)
    {

       if(is_null(self::$conexion)) {
           return "Error al agregar el equipo. Mensaje: " . self::$error_conexion;
       }
       try {
           $t = [];

           $sql = "SELECT id, texto, etiquetas, fecha_creacion, fecha_alarma, estados_id, id_usuario FROM tareas where id_usuario = '$Uid' ";
           $r = self::$conexion->query($sql, PDO::FETCH_ASSOC);

           while ( $fila = $r->fetch() ) {
               $t[] = new Tarea($fila['texto'],
                                 $fila['fecha_creacion'],
                                 $fila['fecha_alarma'],
                                 $fila['etiquetas'],
                                 $fila['estados_id'],
                                 $fila['id_usuario'],
                                 $fila['id']
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

    public function eliminar(Tarea $T)
    {
        if(is_null(self::$conexion)) {
            return "Error al eliminar tarea. Mensaje: " . self::$error_conexion;
        }
        try {
            $s = self::$conexion->prepare(
                "DELETE FROM tareas WHERE ID = ?"
            );
            $s->execute([ $T->getID() ]);
            return true;
        }
        catch (PDOException $e) {
            $error =  "Error al consultar" . self::$error_conexion;
            $error.= $e->getMessage();
            return $error;
        }
    }

    public function modificar(Tarea $T)
    {
        if(is_null(self::$conexion))
        {
            return "Error al modificar tarea. Mensaje: " . self::$error_conexion;
        }
        try
        {
            $s = self::$conexion->prepare(
                "UPDATE tareas
                set texto=:t, etiquetas=:et, fecha_alarma=:fa, estados_id=:ei WHERE id=:id"
            );
            $s-> bindValue(':t',$T->getTexto());
            $s-> bindValue(':et',$T->getEtiquetas());
            $s-> bindValue(':fa',$T->getFecha());
            $s-> bindValue(':ei',$T->getEstado());
            $s-> bindValue(':id',$T->getID());
            $s->execute();
            return "Tarea modificada";
        }
        catch (PDOException $e) {
            $error =  "Error al consultar" . self::$error_conexion;
            $error.= $e->getMessage();
            return $error;
        }
    }

    public function buscartxt($texto, $id)
    {
        if(is_null(self::$conexion)) {
            return "Error al buscar tarea. Mensaje: " . self::$error_conexion;
        }
        try {
            // Preparamos la consulta:
            $r = self::$conexion->prepare(
                "SELECT id, texto, etiquetas, fecha_creacion, fecha_alarma, estados_id, id_usuario FROM tareas
                WHERE id_usuario=$id && texto LIKE '%$texto%'"
            );
            $r->execute();

            //Si el equipo fue encontrado en la BD, creamos con estos datos un
            //objeto equipo y lo retornamos.
            while ( $fila = $r->fetch() ) {
                $t[] = new Tarea($fila['texto'],
                                  $fila['fecha_creacion'],
                                  $fila['fecha_alarma'],
                                  $fila['etiquetas'],
                                  $fila['estados_id'],
                                  $fila['id_usuario'],
                                  $fila['id']
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

    public function buscartag($texto, $id)
    {
        if(is_null(self::$conexion)) {
            return "Error al buscar tarea. Mensaje: " . self::$error_conexion;
        }
        try {
            // Preparamos la consulta:
            $s = self::$conexion->prepare(
              "SELECT id, texto, etiquetas, fecha_creacion, fecha_alarma, estados_id, id_usuario FROM tareas
              WHERE id_usuario=$id && etiquetas LIKE '%$texto%'"
            );
            $s->execute();

            //Si el equipo fue encontrado en la BD, creamos con estos datos un
            //objeto equipo y lo retornamos.
            while ( $fila = $s->fetch() ) {
                $t[] = new Tarea($fila['texto'],
                                  $fila['fecha_creacion'],
                                  $fila['fecha_alarma'],
                                  $fila['etiquetas'],
                                  $fila['estados_id'],
                                  $fila['id_usuario'],
                                  $fila['id']
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

}
