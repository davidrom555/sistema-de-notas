<?php
class Tarea
{
    public function __construct($texto, $fechaC, $fecha, $etiquetas, $estado, $id_usuario, $id)
    {
        $this->texto = $texto;
        $this->fechaC = $fechaC;
        $this->fecha = $fecha;
        $this->etiquetas = $etiquetas;
        $this->id_usuario = $id_usuario;
        $this->id = $id;
        $this->estado = $estado;
    }

    public function __toString()
    {
        $c = "La fecha de la alerta es $this->fecha";
        return $c;
    }

    // getters:
    public function getFecha() { return $this->fecha;}
    public function getTexto() { return $this->texto;}
  	public function getFechaCreacion () { return $this->fechaC;}
    public function getEtiquetas () { return $this->etiquetas;}
    public function getID () { return $this->id;}
    public function getIDUsuario () { return $this->id_usuario;}
    public function getEstado () { return $this->estado;}
    public function getEstadoString ()
    {
       switch($this->estado)
       {
         case 1:
           return 'Pendiente';
         break;
         case 2:
           return 'En Proceso';
         break;
         case 3:
           return 'Finalizada';
         break;
         case 4:
           return 'Cancelada';
         break;
       }
     }


}
