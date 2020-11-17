<?php
//Clase user, solo utilizada como container/plantilla para las clases admin y client
namespace Models;
use Models\iGuardable as iGuardable;
Abstract Class User implements iGuardable
{
    private $id; //interno
    private $nombre;
    private $email;
    private $pass;
    private $fecha; //string en formato dia.mes.anio
    //private $type; //admin o user
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($fecha)
    {
        $this->fecha=$fecha;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nom)
    {
        $this->nombre=$nom;
    }
    public abstract function getType(); //lo devuelve la subclase
    /*
    public function setType($typ)
    {
        $this->type=$typ;
    }*/
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email=$email;
    }
    public function getPass()  
    {
        return $this->pass;
    }
    public function setPass($pass)
    {
        $this->pass=$pass;
    }
    public function verificaPass($comparar)
    {
        if ($this->pass===$comparar) 
            return true;
            else
            return false;
    }
    public function verificaEmail($comparar)
    {
        if ($this->email===$comparar) 
            return true;
            else
            return false;
    }
    public function verificaTodo($mail,$passw)
    {
        $res = false;
        if (verificaEmail($mail))
        {
            if (verificaPass($passw))
            {
                $res=true;
            }
        }
        return $res;
        
    }
    public function toArray()
    {
        $arrayAux=array();
        $arrayAux['id'] = $this->getId();
        $arrayAux['nombre'] = $this->getNombre();
        $arrayAux['email'] = $this->getEmail();
        $arrayAux['pass'] = $this->getPass();
        $arrayAux['fecha'] = $this->getFecha();
        $arrayAux['type'] = $this->getType();
        return $arrayAux;
    }
    public function toArrayParam()
    {
        $arrayAux=array();
        array_push($arrayAux, "id");
        array_push($arrayAux, "nombre");
        array_push($arrayAux, "email");
        array_push($arrayAux, "pass");
        array_push($arrayAux, "fecha");
        array_push($arrayAux, "type");
        return $arrayAux;
    }
    public function toArrayValue()
    {
        $arrayAux=array();
        array_push($arrayAux, $this->getId());
        array_push($arrayAux, $this->getNombre());
        array_push($arrayAux, $this->getEmail());
        array_push($arrayAux, $this->getPass());
        array_push($arrayAux, $this->getFecha());
        array_push($arrayAux, $this->getType());
        return $arrayAux;        
    }
}
?>