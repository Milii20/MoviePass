<?php
//Controller para las funciones del Admin
namespace Controllers;
use DAOMaster\CineDAO as CineDAO;
use DAOMaster\UserDAO as UserDAO; //cambiar luego a UserDAO de DAOMaster
use Models\Cine as Cine;
use Models\Cinema as Cinema;
use Models\Funcion as Funcion;
use Models\User as User;
use utilities\moviedb as moviedb;

Class AdminController
{
    //private $userDAO;
    private $cineDAO;
    private $message = "";
    private $movieDB;
    public function __construct()
    {
        $this->movieDB = new moviedb();
        //$this->userDAO = new UserDAO();
        $this->cineDAO = new CineDAO();
        $this->message="Bienvenido Administrador";
        require_once(VIEWS_PATH."FormMenuAdmin.php");
        require_once(VIEWS_PATH."validate-session.php");
          
    }
    public function CrearCine($nombre,$descripcion)
    {
        $cine = new Cine();
        $cine->setNombre($nombre);
        $cine->setDescripcion($descripcion);
        $this->message="Cine Creado con Exito!";
        $this->cineDAO->addCine($cine);
        $this->showAdministrarCines();
    }
    public function modificarCine($nombre,$descripcion,$id)
    {
        $cineMod=null; //inicializo en null... por las dudas
        $cineMod=$this->cineDAO->getCineById($id);
        $cineMod->setNombre($nombre);
        $cineMod->setDescripcion($descripcion);
        $this->cineDAO->modifyCine($cineMod);
        $this->message="Cine ".$cineMod->getNombre()." Modificado con Exito!";
        
        $this->showAdministrarCines();
    }
    public function eliminarCine($id)
    {
        $this->cineDAO->deleteCine($id);
        $this->message="El cine con la ID ".$id." fue Eliminado con Exito!";
        $this->showAdministrarCines();
    }
    public function CrearCinema( $nombre, $direccion, $valordeentrada, $tiposala, $capacidadtotal, $cantgenteporfila, $distribucionizq, $distribucionder, $id)
    {
        $cinema=new Cinema();
        $cinema->setIdCine($id);
        $cinema->setNombre($nombre);
        $cinema->setDireccion($direccion);
        $cinema->setValorEntrada($valordeentrada);
        $cinema->setTipoSala($tiposala);
        $cinema->setCapacidadTotal($capacidadtotal);
        $cinema->setCantGentePorFila($cantgenteporfila);
        $cinema->setDistribucionIzq($distribucionizq);
        $cinema->setDistribucionDer($distribucionder);
        $this->message="Cinema Creado con Exito!";
        
        $this->cineDAO->addCinema($cinema);
    }
    public function ModificarCinema( $nombre, $direccion, $valordeentrada, $tiposala, $capacidadtotal, $cantgenteporfila, $distribucionizq, $distribucionder, $id)
    {
        $cinema=new Cinema();
        $idarra = array();
        $idarra = explode(";",$id);
        $cinema->setId($idarra[1]);
        $cinema->setIdCine($idarra[0]);
        $cinema->setNombre($nombre);
        $cinema->setDireccion($direccion);
        $cinema->setValorEntrada($valordeentrada);
        $cinema->setTipoSala($tiposala);
        $cinema->setCapacidadTotal($capacidadtotal);
        $cinema->setCantGentePorFila($cantgenteporfila);
        $cinema->setDistribucionIzq($distribucionizq);
        $cinema->setDistribucionDer($distribucionder);
        $this->cineDAO->modifyCinema($cinema);
        $this->message="Cinema ".$cinema->getNombre()." Modificado con Exito!";
        $this->showAdministrarCines();
    }
    public function eliminarCinema($id)
    {
        $this->cineDAO->deleteCinema($id);
        $this->message="El cinema con la ID ".$id." fue Eliminado con Exito!";
        $this->showAdministrarCines();
    }
    public function crearFuncion($dia, $mes, $anio, $hora, $minuto, $ids) //falta verificacion para que la fecha sea posterior al dia de hoy
    {
        $funcion=new funcion();
        $array=explode(".",$ids);
        $funcion->setIdPelicula($array[0]);
        $funcion->setIdCinema($array[1]);
        $funcion->setHora($hora.":".$minuto);
        $funcion->setFecha($dia.".".$mes.".".$anio);
        $cinema=$this->cineDAO->getCinemaById($array[1]);
        $funcion->generarArrayAsientos($cinema->getCantGentePorFila(),$cinema->getCapacidadTotal());
        $this->cineDAO->addFuncion($funcion);
        $this->message="Funcion Creada con Exito!";
        $this->showAdministrarCines();
    }
    public function eliminarFuncion($id)
    {
        $this->cineDAO->deleteFuncion($id);
        $this->message="La Funcion con la ID ".$id." fue Eliminada con Exito!";
        $this->showAdministrarCines();
    }
    public function showAdministrarCines()
    {
        $cines=array();
        $cines=$this->cineDAO->getAllCine();
        if (!empty($cines))
        {
            foreach ($cines as $cine)
            {
                $cine->setArrayCinemas($this->cineDAO->getCinemaByIdCine($cine->getId()));
                if (!empty($cine->getArrayCinemas()))
                foreach($cine->getArrayCinemas() as $cinema)
                {
                    $cinema->setArrayFunciones($this->cineDAO->getFuncionByIdCinema($cinema->getId()));
                }
            }
        }
        require_once(VIEWS_PATH."FormAdministrarCines.php");
        require_once(VIEWS_PATH."validate-session.php");
    }
    public function showAgregarCinema($id)
    {
        $tipo="crear";
        require_once(VIEWS_PATH."FormCrearCinema.php");
        require_once(VIEWS_PATH."validate-session.php");
    }
    
    public function showAgregarFuncionPopular($idd)
    {
        $tipo="crear";
        $fun="Popular";
        $id=0;
        $pag=1;
        if (strpos($idd,";")===FALSE)
        { //si no tiene punto y coma en la cadena, es solo una id
            $id=$idd;
        }
        else
        { //si tiene punto y coma en la cadena, es id y pagina
            $arr=array();
            $arr=explode(";",$idd);
            echo $idd;
            echo $arr[0]." ".$arr[1];
            $id=$arr[0];
            $pag=$arr[1];
        }

        $movieDB = new moviedb();
        $listaPelis= $movieDB->buscarConMayorRating($pag);
        require_once(VIEWS_PATH."FormAgregarPeli.php");
        require_once(VIEWS_PATH."validate-session.php");
    }
    public function showAgregarFuncionUltimas($idd)
    {
        $tipo="crear";
        $fun="Ultimas";
        $id=0;
        $pag=1;
        if (strpos($idd,";")===FALSE)
        { //si no tiene punto y coma en la cadena, es solo una id
            $id=$idd;
        }
        else
        { //si tiene punto y coma en la cadena, es id y pagina
            $arr=array();
            $arr=explode(";",$idd);
            echo $idd;
            echo $arr[0]." ".$arr[1];
            $id=$arr[0];
            $pag=$arr[1];
        }
        $movieDB = new moviedb();
        $listaPelis= $movieDB->buscarActuales($pag);
        require_once(VIEWS_PATH."FormAgregarPeli.php");
        require_once(VIEWS_PATH."validate-session.php");
    }
    public function showAgregarFuncionViejas($idd)
    {
        $tipo="crear";
        $fun="Viejas";
        $id=0;
        $pag=1;
        if (strpos($idd,";")===FALSE)
        { //si no tiene punto y coma en la cadena, es solo una id
            $id=$idd;
        }
        else
        { //si tiene punto y coma en la cadena, es id y pagina
            $arr=array();
            $arr=explode(";",$idd);
            echo $idd;
            echo $arr[0]." ".$arr[1];
            $id=$arr[0];
            $pag=$arr[1];
        }
        $movieDB = new moviedb();
        $listaPelis= $movieDB->buscarViejas($pag);
        require_once(VIEWS_PATH."FormAgregarPeli.php");
        require_once(VIEWS_PATH."validate-session.php");
    }
    public function showAgregarNuevoCine()
    {
        $tipo="crear";
        require_once(VIEWS_PATH."FormCrearCine.php");
        require_once(VIEWS_PATH."validate-session.php");

    }
    public function showModificarCine($id)
    {
        $tipo="modificar";
        $cineMod=$this->cineDAO->getCineById($id);
        require_once(VIEWS_PATH."FormCrearCine.php");
        require_once(VIEWS_PATH."validate-session.php");

    }
    public function showModificarCinema($id)
    {
        $tipo="modificar";
        $cinemaMod=$this->cineDAO->getCinemaById($id);
        require_once(VIEWS_PATH."FormCrearCinema.php");
        require_once(VIEWS_PATH."validate-session.php");

    }
    public function showEliminarCine($id)
    {
        $tipo="eliminarcine";
        $this->message="Eliminar el Cine en su totalidad?";
        require_once(VIEWS_PATH."FormConfirmacion.php");
        require_once(VIEWS_PATH."validate-session.php");

    }
    public function showEliminarCinema($id)
    {
        $tipo="eliminarcinema";
        $this->message="Eliminar la sala de Cine (Cinema)?";
        require_once(VIEWS_PATH."FormConfirmacion.php");
        require_once(VIEWS_PATH."validate-session.php");

    }
    public function showEliminarfuncion($id)
    {
        $tipo="eliminarfuncion";
        $this->message="Eliminar la Funcion?";
        require_once(VIEWS_PATH."FormConfirmacion.php");
        require_once(VIEWS_PATH."validate-session.php");

    }
}
?>