<?php
//Miniclase Cine, contiene uno o mas cinemas (salas), y un nombre

namespace Models;
use Models\iGuardable as iGuardable;
use Models\cinema as cinema;
use Models\funcion as funcion;
Class Cine implements iGuardable 
{
    private $id;//id que identifica al cine 
    private $arrayCinemas = array(); //array con las salas de cine
    private $nombre;
    private $descripcion;
    private $arrayPromos = array(); //array con las promos
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
    }
    public function getArrayCinemas()
    {
        return $this->arrayCinemas;
    } 
    public function setArrayCinemas($arrayCin)
    {
        $this->arrayCinemas=$arrayCin;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nomb)
    {
        $this->nombre=$nomb;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($desc)
    {
        $this->descripcion=$desc;
    }
    public function getArrayPromos()
    {
        return $this->arrayPromos;
    }
    public function setArrayPromos($promos)
    {
        $this->arrayPromos=$promos;
    }
    public function getArrayPromosJson()
    {
        $arrayAux=array();
        foreach ($this->getArrayPromos() as $promo)
        {
            array_push($arrayAux,$promo->getAsJson());
        }
        return json_encode($arrayAux, JSON_PRETTY_PRINT);
    }
    public function setArrayPromosJson($json)
    {
        $arrayAux=json_decode($json,true);
        $arrayPro=array();
        foreach ($arrayAux as $promo)
        {
            array_push($arrayPro,$promo->getFromJson());
        }
        $this->setArrayPromos($arrayPro);
    }
    public function toArray()
    {
        $arrayAux=array();
        $arrayAux['id'] = $this->getId();
        $arrayAux['nombre'] = $this->getNombre();
        $arrayAux['descripcion'] = $this->getDescripcion();
        $arrayAux['promos'] = $this->getArrayPromosJson();
        return $arrayAux;
    }
    public function toArrayParam()
    {
        $arrayAux=array();
        array_push($arrayAux, "id");
        array_push($arrayAux, "nombre");
        array_push($arrayAux, "descripcion");
        array_push($arrayAux, "promos");
        return $arrayAux;
    }
    public function toArrayValue()
    {
        $arrayAux=array();
        array_push($arrayAux, $this->getId());
        array_push($arrayAux, $this->getNombre());
        array_push($arrayAux, $this->getDescripcion());
        array_push($arrayAux, $this->getArrayPromosJson());
        return $arrayAux;        
    }
    public function getCantidadAsientosOcupados()
    {
        $res=0;
        foreach ($this->getArrayCinemas() as $cinema)
        {
            foreach ($cinema->getArrayFunciones() as $funcion)
            {
                $res=$res+$funcion->getCantAsientosOcupados();
            }
        }
        return $res;
    }
    public function getCantidadAsientosDisponibles()
    {
        $res=0;
        foreach ($this->getArrayCinemas() as $cinema)
        {
            foreach ($cinema->getArrayFunciones() as $funcion)
            {
                $res=$res+$funcion->getCantAsientosDisponibles();
            }
        }
        return $res;
    }
    public function getTotalVendidoEnPesos()
    {
        $res=0;
        foreach ($this->getArrayCinemas() as $cinema)
        {
            foreach ($cinema->getArrayFunciones() as $funcion)
            {
                $res=$res+$funcion->getCantAsientosOcupados()*$cinema->getValorEntrada();
            }
        }
        return $res;
    }


}
?>