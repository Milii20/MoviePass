<?php
//Clase user, solo utilizada como container/plantilla para las clases admin y client
namespace Models;
Class User
{
    private $id; //interno
    private $nombre;
    private $email;
    private $pass;
    private $fecha; //string en formato dia.mes.anio
    private $type; //admin o user
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
    public function getType()
    {
        return $this->type;
    }
    public function setType($typ)
    {
        $this->type=$typ;
    }
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
}
?>