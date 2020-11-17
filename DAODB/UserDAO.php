<?php
//contiene alta baja modificacion y consulta de admins y clients
//pero en DB
namespace DAODB;
//use DAODB\DBGen as DBGen;
use DAODB\DAODB as DAODB;
use Models\User as User;
use Models\Admin as Admin;
use Models\Client as Client;
class UserDAO extends DAODB
{
    protected function getDatabase()
    {
        return USERTABLE;
    }
    /*          MOVIDOS A USER
    private function toArray(User $user)
    {
        $arrayAux = array();
        $arrayAux['id'] = $user->getId();
        $arrayAux['nombre'] = $user->getNombre();
        $arrayAux['email'] = $user->getEmail();
        $arrayAux['pass'] = $user->getPass();
        $arrayAux['fecha'] = $user->getfecha();
        $arrayAux['type'] = $user->getType();
        return $arrayAux;
    }
    private function toArrayParam()
    {
        $arrayAux = array();
        array_push($arrayAux, "id");
        array_push($arrayAux, "nombre");
        array_push($arrayAux, "email");
        array_push($arrayAux, "pass");
        array_push($arrayAux, "fecha");
        array_push($arrayAux, "type");
        return $arrayAux;
    }
    private function toArrayValue(User $user)
    {
        $arrayAux = array();
        array_push($arrayAux, $user->getId());
        array_push($arrayAux, $user->getNombre());
        array_push($arrayAux, $user->getEmail());
        array_push($arrayAux, $user->getPass());
        array_push($arrayAux, $user->getfecha());
        array_push($arrayAux, $user->getType());
        return $arrayAux;
    }*/
    protected function fromArray($array)
    {
        $type=$array['type'];
        if (strcasecmp($type,"admin")==0)
        {
            $user = new Admin();
        }
        else
        {
            $user = new Client();
        }
            $user->setId($array['id']);
            $user->setNombre($array['nombre']);
            $user->setEmail($array['email']);
            $user->setPass($array['pass']);
            $user->setFecha($array['fecha']);
            //$user->setType($array['type']);
        
        return $user;
    }
    protected function getArrayType()
    {
        $arrayAux=array();
        $arrayAux['id'] = "INT NOT NULL AUTO_INCREMENT";
        $arrayAux['nombre'] = "VARCHAR(500)";
        $arrayAux['email'] = "VARCHAR(500)";
        $arrayAux['pass'] = "VARCHAR (500)";
        $arrayAux['fecha'] = "VARCHAR (50)";       
        $arrayAux['type'] = "VARCHAR(50)";   
        $arrayAux['CONSTRAINT pk_funcion'] = "PRIMARY KEY (id)";                                                                      //primary keys
        //$arrayAux['CONSTRAINT fk_funcion_cinema'] = "FOREIGN KEY (idcinema) REFERENCES ".CINEMATABLE." (id) ON DELETE CASCADE ON UPDATE CASCADE";  //foreign key con cinemas
        //$arrayAux['CONSTRAINT fk_funcion_pelicula'] = "FOREIGN KEY (idpelicula) REFERENCES ".PELICULATABLE." (id) ON DELETE NO ACTION ON UPDATE NO ACTION";  
        //foreign key con peliculas, ya que no la voy a borrar nunca a la peli, y si borro la funcion la peli deberia seguir estando, no es necesaria
        return $arrayAux;
    }
    public function GetByEmail($email)  //get 1
    {   
        $userFound = null;
        $res=$this->getOneWithCheck(array('email'), array($email)); //ya que no deberia haber repetidos porque verifico que el email sea unico a la hora de crear un usuario, puedo tomar el resultado como 1 solo usuario
        if(!empty($res))
        {
            $userFound=$res;
        }
        return $userFound; //o returna null, o returna un usuario
        
    }
    /* EN DAODB
    public function GiveId()
    {
        return DBGen::getNewId(USERTABLE);
    }
    public function Add(User $newUser)  //      AHORA ES ADDWITHID EN DAODB
    {
        $newUser->setId($this->GiveId()); //ya que no tiene id hasta este punto el usuario, le asigno ahora
        DBGen::addOne(USERTABLE, $this->toArray($newUser));    
    }
    public function GetAll()            //getAll
    {
        return DBGen::getAll(USERTABLE);
    }*/

    /*  YA ESTA EN DAODB
    public function GetById($id)
    {   
        $userFound = null;
        $res=DBGen::getOne(USERTABLE, array('id'), array($id)); //la id si o si es unica, asi que solo habra 1
        if(!empty($res))
        {
            $userFound=$this->fromArray($res);
        }
        return $userFound; //o returna null, o returna un usuario
        
    }
    public function Modify(User $user) //busca un user, si existe lo guarda
    {
        $userFound = $this->GetById($user->getId());
        if ($userFound!=null)
        {
            if ($user->getPass()=="") //osea, si no modifico la pass, ya que se la vacio de la session
            $user->setPass($userFound->getPass());
            DBGen::updateOne(USERTABLE, array('id'),array($user->getId()), $this->toArrayParam(), $this->toArrayValue($user)); //lo busca por id, asi puedo modificar el email
        }
    }
    public function Delete(User $User) 
    {
        DBGen::deleteOne(USERTABLE, array('id'), $user->getId()); //lo busca por id, y lo elimina
    }*/








}

?>