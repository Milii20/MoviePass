<?php
//contiene alta baja modificacion y consulta de admins y clients
//pero en JSON
namespace DAOJS;
use Models\User as User;
use Models\Admin as Admin;
use Models\Client as Client;
Class UserDao
{
    
    private $userList = array();
    public function GiveId()
    {
        $this->RetrieveData();
        //return count($this->userList
        $res=0;
        if(!empty($this->userList)){
            $res=$this->userList[count($this->userList)-1]->getId()+1;//es un lio, pero esto llama a getId del ultimo valor en la lista de usuarios y le agrega 1
        };
        return $res;
    }
    public function GetAll(){
        $this->RetrieveData();

        return $this->userList;
    }

    public function GetByEmail($email){
        $this->RetrieveData();
        $userFound = null;
        
        if(!empty($this->userList)){
            foreach($this->userList as $user){
                
                if($user->getEmail() == $email){
                    $userFound = $user;
                }
            }
        }
        return $userFound;
    }
    public function GetById($id){
        $this->RetrieveData();
        $userFound = null;
        
        if(!empty($this->userList)){
            foreach($this->userList as $user){
                
                if($user->getId() == $id){
                    $userFound = $user;
                }
            }
        }
        return $userFound;
    }
    public function Modify(User $User){ //antes de llamar a esto, tengo que saber que existe el user
        
        $this->RetrieveData();
        if(!empty($this->userList)){
            foreach($this->userList as $Suser){
                
                if($Suser->getId() == $user->getId()){
                    $mod=array_Search($Suser,$this->userList);
                    if ($user->getPass()=="") //osea, si no modifico la pass, ya que se la vacio de la session
                         $user->setPass($Suser->getPass());
            
                    $this->userList[$mod]= $user;
                }
            }
        }
        $this->SaveData();
    }
    public function Delete(User $User){ 
        
        $this->RetrieveData();
        if(!empty($this->userList)){
            foreach($this->userList as $Suser){
                
                if($Suser->getId() == $user->getId()){
                    $del=array_Search($Suser,$this->userList);
                    unset($this->userList[$del]);
                    $aux=array_values($this->userList);   /// usado para arreglar los index del array
                    $this->userList=$aux;
                }
            }
        }
        
        $this->SaveData();
    }
    public function Add(User $newUser){
        
        $this->RetrieveData();
        
        array_push($this->userList, $newUser);

        $this->SaveData();
    }

    private function SaveData() 
    {
        $arrayToEncode = array();

        foreach($this->userList as $user)
        {
            if ($user->getType()=="admin")
                {
                    $valuesArray["id"]=$user->getId();
                    $valuesArray["nombre"]=$user->getNombre();
                    $valuesArray["email"]=$user->getEmail();
                    $valuesArray["pass"]=$user->getPass();
                    $valuesArray["fecha"]=$user->getFecha();
                    $valuesArray["type"]=$user->getType();
                }
                else
                {
                    $valuesArray["id"]=$user->getId();
                    $valuesArray["nombre"]=$user->getNombre();
                    $valuesArray["email"]=$user->getEmail();
                    $valuesArray["pass"]=$user->getPass();
                    $valuesArray["fecha"]=$user->getFecha();
                    $valuesArray["type"]=$user->getType();
                }
            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents(ROOT.'Data/users.json', $jsonContent);
    }
    private function RetrieveData()
    {
        $this->userList = array();

        if(file_exists(ROOT.'Data/users.json'))
        {
            $jsonContent = file_get_contents(ROOT.'Data/users.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                
                if ($valuesArray["type"]=="admin")
                {
                    
                    $admin= new Admin();
                    $admin->setId($valuesArray["id"]);
                    $admin->setNombre($valuesArray["nombre"]);
                    $admin->setEmail($valuesArray["email"]);
                    $admin->setPass($valuesArray["pass"]);
                    $admin->setFecha($valuesArray["fecha"]);
                    $admin->setType($valuesArray["type"]);
                    array_push($this->userList,$admin);
                }
                else
                {
                    $Client= new Client();  
                    $Client->setId($valuesArray["id"]);                 
                    $Client->setNombre($valuesArray["nombre"]);
                    $Client->setEmail($valuesArray["email"]);
                    $Client->setPass($valuesArray["pass"]);
                    $Client->setFecha($valuesArray["fecha"]);
                    $Client->setType($valuesArray["type"]);
                    array_push($this->userList,$Client);
                }

            }
        }
    }
}
?>