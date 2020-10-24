<?php
//DAOMaster de User, permite alternar entre DAODB y DAOJS obfuscando el procedimiendo de los demas, asi cuando se requiere, se invoca a UserDAO de DAOMASTER en vez de UserDAO de JS o DB
namespace DAOMaster;
use DAODB\UserDAO as DAODB;
use DAOJS\UserDAO as DAOJS;
use Models\User as User;
use Models\Admin as Admin;
use Models\Client as Client;

Class UserDAO
{
    public $UserDAO; //la pequeña hiperpolimorfica DAO
    public function __construct()
    {
        $DAO = "DAO".USEDDAO;
        if ($DAO=="DAODB")
        {
            $this->UserDAO=new DAODB();
        }
        else
        {
            $this->UserDAO=new DAOJS();
        }
    }
    public function GiveId()
    {
        return $this->UserDAO->GiveID();
    }
    public function Add(User $newUser)  //add 1
    {
        $this->UserDAO->Add($newUser);
    }
    public function GetAll()            //getAll
    {
        return $this->UserDAO->GetAll();
    }
    public function GetByEmail($email)  //get 1
    {   
        return $this->UserDAO->GetByEmail($email); 
    }
    public function GetById($id)
    {   
        return $this->UserDAO->GetById($id);       
    }
    public function Modify(User $User) //busca un user, si existe lo guarda
    {
        $this->UserDAO->Modify($User);
    }
    public function Delete(User $User) 
    {
        $this->UserDAO->Delete($User);
    }
}
?>