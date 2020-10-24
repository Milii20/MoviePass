<?php
//DAOMaster de Cine, permite alternar entre DAODB y DAOJS obfuscando el procedimiendo de los demas, asi cuando se requiere, se invoca a CineDAO de DAOMASTER en vez de CineDAO de JS o DB
namespace DAOMaster;
use DAODB\CineDAO as DAODB;
use DAOJS\CineDAO as DAOJS;
use Models\Cine as Cine;
use Models\Cinema as Cinema;
use Models\Funcion as Funcion;
Class CineDAO
{
    public $CineDAO; //la gran y super util nada repetida hiperpolimorfica DAO
    public function __construct()
    {
        $DAO = "DAO".USEDDAO;
        if ($DAO=="DAODB")
        {
            $this->CineDAO=new DAODB();
        }
        else
        {
            $this->CineDAO=new DAOJS();
        }
    }
    public function addCine($cine)
    {
        $this->CineDAO->addCine($cine);
    }    
    public function addCinema($cinema)
    {
        $this->CineDAO->addCinema($cinema);
    }   
    public function addFuncion($funcion)
    {
        $this->CineDAO->addFuncion($funcion);
    }
    public function getAllCine()
    {
        return $this->CineDAO->getAllCine();
    }   
    public function getCineById($id)
    {
        return $this->CineDAO->getCineById($id);
    }    
    public function getCinemaById($id)
    {
        return $this->CineDAO->getCinemaById($id);
    }       
    public function getCinemaByIdCine($id)
    {
        return $this->CineDAO->getCinemaByIdCine($id);
    }   
    public function getFuncionById($id)
    {
        return $this->CineDAO->getFuncionById($id);
    }      
    public function getFuncionDisponible() 
    {
        return $this->CineDAO->getFuncionDisponible();
    }
    public function getFuncionByIdCinema($id)
    {
        return $this->CineDAO->getFuncionByIdCinema($id);
    }          
    public function getFuncionPorIdClienteAsiento($idCliente) //puede traer muchos
    {
        return  $this->CineDAO->getFuncionPorIdClienteAsiento($idCliente);
    }
    public function modifyCine($cine)
    {
        $this->CineDAO->modifyCine($cine);
    }    
    public function modifyCinema($cinema)
    {
        $this->CineDAO->modifyCinema($cinema);
    }   
    public function modifyFuncion($funcion)
    {
        $this->CineDAO->modifyFuncion($funcion);
    }      
    public function deleteCine($idCine)
    {
        $this->CineDAO->deleteCine($idCine);
    }    
    public function deleteCinema($idCinema)
    {
        $this->CineDAO->deleteCinema($idCinema);
    }   
    public function deleteFuncion($idFuncion)
    {
        $this->CineDAO->deleteFuncion($idFuncion);
    }  
}
    
?>