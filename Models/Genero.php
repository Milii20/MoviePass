<?php
namespace Models;
use Models\iGuardable as iGuardable;
Class Genero implements iGuardable
{
    private $id;
    private $nombre;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre=$nombre;
    }
    public function toArray()
    {
        $arrayAux=array();
        $arrayAux['id'] = $this->getId();
        $arrayAux['nombre'] = $this->getNombre();
        return $arrayAux;
    }
    public function toArrayParam()
    {
        $arrayAux=array();
        array_push($arrayAux, "id");
        array_push($arrayAux, "nombre");
        return $arrayAux;
    }
    public function toArrayValue()
    {
        $arrayAux=array();
        array_push($arrayAux, $this->getId());
        array_push($arrayAux, $this->getNombre());
        return $arrayAux;        
    }
}
?>