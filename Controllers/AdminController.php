<?php
//Controller para las funciones del Admin
namespace Controllers;
use DAODB\CineDAO as CineDAO;
use DAODB\CinemaDAO as CinemaDAO;
use DAODB\GeneroDAO as GeneroDAO;
use DAODB\PeliculaDAO as PeliculaDAO;
use DAODB\FuncionDAO as FuncionDAO;         //TRANSFORMADO TODO EN DAODB PARA AHORRAR TIEMPO
use DAODB\UserDAO as UserDAO; //cambiar luego a UserDAO de DAOMaster
use Models\Cine as Cine;
use Models\Cinema as Cinema;
use Models\Genero as Genero;
use Models\Funcion as Funcion;
use Models\Pelicula as Pelicula;
use Models\User as User;
use utilities\moviedb as moviedb;
use utilities\QR as QR;
use utilities\Calendar as Calendar;

Class AdminController
{
    /*private $userDAO;
    private $cineDAO; 
    private $funcionDAO; 
    private $cinemaDAO;*/ 
    private $message = "";
    private $movieDB;
    //testing si anda el filtro de session
    public function getType()
    {
        return "admin";
    }
    public function __construct()
    {
        $this->movieDB = new moviedb();
        //$this->userDAO = new UserDAO();
        //$this->cineDAO = new CineDAO(); transformado en estatica
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
        $cineDAO = new CineDAO();
        $cineDAO->addWithId($cine);
        $this->showAdministrarCines();
    }
    public function modificarCine($nombre,$descripcion,$id)
    {
        $cineMod=null; //inicializo en null... por las dudas
        $cineDAO=new CineDAO();
        $cineMod=$cineDAO->getCineById($id);
        $cineMod->setNombre($nombre);
        $cineMod->setDescripcion($descripcion);
        $cineDAO = new CineDAO();
        $cineDAO->modify($cineMod);
        $this->message="Cine ".$cineMod->getNombre()." Modificado con Exito!";
        
        $this->showAdministrarCines();
    }
    public function eliminarCine($id)
    {
        $cineDAO = new CineDAO();
        $cineDAO->delete($id);
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
        $cinemaDAO = new CinemaDAO();
        $cinemaDAO->addWithId($cinema);
        $this->showAdministrarCines();
    }
    public function ModificarCinema( $nombre, $direccion, $valordeentrada, $tiposala, $capacidadtotal, $cantgenteporfila, $distribucionizq, $distribucionder, $id)
    {
        $cinemaDAO = new CinemaDAO();
        $cinema = $cinemaDAO->getOneById($id);
        //$cinema=new Cinema();
        /*$idarra = array();
        $idarra = explode(";",$id);
        $cinema->setId($idarra[1]);
        $cinema->setIdCine($idarra[0]);*/
        $cinema->setNombre($nombre);
        $cinema->setDireccion($direccion);
        $cinema->setValorEntrada($valordeentrada);
        $cinema->setTipoSala($tiposala);
        $cinema->setCapacidadTotal($capacidadtotal);
        $cinema->setCantGentePorFila($cantgenteporfila);
        $cinema->setDistribucionIzq($distribucionizq);
        $cinema->setDistribucionDer($distribucionder);
        
        $cinemaDAO->modify($cinema);
        $this->message="Cinema ".$cinema->getNombre()." Modificado con Exito!";
        $this->showAdministrarCines();
    }
    public function eliminarCinema($id)
    {
        $cinemaDAO = new CinemaDAO();
        $cinemaDAO->delete($id);
        $this->message="El cinema con la ID ".$id." fue Eliminado con Exito!";
        $this->showAdministrarCines();
    }
    public function crearFuncion($dia, $mes, $anio, $hora, $minuto, $ids) //falta verificacion para que la fecha sea posterior al dia de hoy
    {
        
        $funcion=new funcion();
        // DEBUG SI YA ESTA EN ALGUN CINE CON EXCEPCION DEL ACTUAL EN EL MISMO DIA, NO DEJAR AGREGAR LA PELI, COMENTAR QUE YA ESTA EN OTRO CINE
        // DEBUG SI LA FECHA ES ANTERIOR A LA FECHA ACTUAL, O POSTERIOR POR MENOS DE 15 MINUTOS, NO DEJAR AGREGAR LA PELI
        // DEBUG EN CUALQUIER CASO VOLVER A SHOWAGREGARPELI
        // DEBUG VERIFICAR QUE EL ORDEN DE LAS FUNCIONES NO SE CHOQUEN, SI HAY UNA FUNCION DE 1 A 2 PM, QUE LA PROXIMA EMPIECE 2:15 A 3:15, Y LA SIGUIENTE 3:30 A 4:30 Y ASI
        $array=explode(".",$ids);
        $funcion->setIdCinema($array[1]);
        $pelidao = new PeliculaDAO();
        $peli = $pelidao->getOneById($array[0]);
        if ($peli==null)
        {
            $peli=$pelidao->desdeArray($this->movieDB->getById($array[0]));
            $pelidao->add($peli);
            //echo "agregada la peli ".$peli->getId();
        }
        $funcion->setPelicula($peli);
        $funcion->setHora($hora.":".$minuto);
        $funcion->setFecha($dia.".".$mes.".".$anio);
        $cinemaDAO=new CinemaDAO();
        $cinema=$cinemaDAO->getCinemaById($array[1]);
        $funcion->generarArrayAsientos($cinema->getCantGentePorFila(),$cinema->getCapacidadTotal());
        $verificacion=$this->verificarFuncion($funcion,$cinema->getIdCine());
        if ($verificacion==0)  //DEBUG bastante hostil, pensar si hay alguna otra forma
        {
            $funcionDAO = new FuncionDAO();
            $funcionDAO->addWithId($funcion);
            $this->message="Funcion Creada con Exito!";
        }
        elseif ($verificacion==1)
        {
            $this->message="No pudo crearse la funcion, Ya existe una funcion igual en otro cine el mismo dia!";
        }
        elseif ($verificacion==2)
        {
            $this->message="No pudo crearse la funcion, Ya existe una funcion igual en otro sala del cine el mismo dia!";
        }
        elseif ($verificacion==3)
        {
            $this->message="No pudo crearse la funcion, Ya hay otra funcion en el mismo horario!";
        }
        $this->showAdministrarCines();
    }
    public function verificarFuncion($funcionAVerificar,$idcine)  //verifica la funcion si puede agregarse o no, devuelve los siguientes valores:
    {                                           //0 si esta todo bien, 1 si ya existe una funcion igual en otro cine el mismo dia, 2 si ya existe otra funcion igual en otro cinema del mismo cine el mismo dia, 3 si hay menos de 15 min con la funcion anterior o si se solapan
        $res = 0;           /// VER ARRAYMAP
        $cines=array();
        $cines=$this->cargaTodosLosCines();
        //$arrayHorarios = array();
        $arrayHorario = array();
        $arrayHorario['Inicio']=Calendar::restaMinutos(Calendar::transformaFechaYHora($funcionAVerificar->getFecha(), $funcionAVerificar->getHora()),15);
        $arrayHorario['Fin']=Calendar::agregaDuracionDePelicula(Calendar::transformaFechaYHora($funcionAVerificar->getFecha(), $funcionAVerificar->getHora()));
        if (!empty($cines))
        {
            foreach ($cines as $cine)    /// podria ser while, corta de tiempo
            {
                foreach ($cine->getArrayCinemas() as $cinema)
                {
                    foreach ($cinema->getArrayFunciones() as $funcion)
                    {
                        if  ($funcion->getPelicula()->getId()==$funcionAVerificar->getPelicula()->getId())    //si son la misma peli
                            if(Calendar::comparaDias($funcion->getFecha(),$funcionAVerificar->getFecha())) //misma fecha
                                if  ($cinema->getIdCine()!=$idcine)                                 //en distinto cine
                                {
                                    $res = 1;
                                }
                                elseif  ($cinema->getId()!=$funcionAVerificar->getIdCinema())             //mismo cine y en distinto cinema
                                    {
                                            $res = 2;    
                                    }
                        if ($res==0)    //si ya tengo otro error ni verifico esto
                        {        
                            if ($cinema->getId()==$funcionAVerificar->getIdCinema()) 
                            {
    
                                $verInicio =Calendar::restaMinutos(Calendar::transformaFechaYHora($funcion->getFecha(), $funcion->getHora()),15);
                                $verFinal =  Calendar::agregaDuracionDePelicula(Calendar::transformaFechaYHora($funcion->getFecha(), $funcion->getHora()));
                                if(Calendar::entreDosFechas($arrayHorario['Inicio'],$arrayHorario['Fin'],$verInicio))
                                {   //despues del inicio y antes del final, osea, se chocan
                                    $res=3;
                                }
                                elseif (Calendar::entreDosFechas($arrayHorario['Inicio'],$arrayHorario['Fin'],$verFinal))
                                {
                                    $res=3;
                                }
                            }  
                        }
                    }
                }
                                     
            }
        }

        return $res;
    
    }
   
    public function eliminarFuncion($id)
    {
        $funcionDAO = new FuncionDAO();
        $funcionDAO->delete($id);
        $this->message="La Funcion con la ID ".$id." fue Eliminada con Exito!";
        $this->showAdministrarCines();
    }
    public function cargaTodosLosCines()
    {
        $cines=array();
        $cineDAO = new CineDAO();
        $cinemaDAO = new CinemaDAO();
        $funcionDAO = new FuncionDAO();
        $cines=$cineDAO->getAll();
        if (!empty($cines))
        {
            foreach ($cines as $cine)
            {
                $cine->setArrayCinemas($cinemaDAO->getAllCinemasFromCineID($cine->getId()));
                if (!empty($cine->getArrayCinemas()))
                foreach($cine->getArrayCinemas() as $cinema)
                {
                    $cinema->setArrayFunciones($funcionDAO->getAllFuncionesByCinemaID($cinema->getId()));
                }
            }
        }
        return $cines;
    }
    public function showAdministrarCines()
    {
        $cines=array();
        $cines=$this->cargaTodosLosCines();
        //QR::generate(500,"holavo");
        require_once(VIEWS_PATH."FormAdministrarCines.php");

    }
    public function generarCodigoQRGrande($mensaje)
    {
        return QR::generate(500,$mensaje);
    }
    public function generarCodigoQRChiquito($mensaje)
    {
        return QR::generate(150,$mensaje);
    }
    public function actualizaGeneros()
    {
        $generoDAO = new GeneroDAO();
        $this->movieDB=new moviedb();
        $res=$this->movieDB->getAllGenres();
        foreach($res as $ar)
        //foreach($ar as $cla => $val)
        {
            $genero = new Genero();
            $genero=$generoDAO->desdeArray($ar);
            echo "id: ".$genero->getId()." nombre: ".$genero->getNombre()."<br>";
            $generoDAO->add($genero);
        }
    }
    public function showAgregarCinema($id)
    {
        $tipo="crear";
        require_once(VIEWS_PATH."FormCrearCinema.php");

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

    }
    public function showAgregarNuevoCine()
    {
        $tipo="crear";
        require_once(VIEWS_PATH."FormCrearCine.php");


    }
    public function showModificarCine($id)
    {
        $tipo="modificar";
        $cineDAO = new CineDAO();
        $cineMod=$cineDAO->getCineById($id);
        require_once(VIEWS_PATH."FormCrearCine.php");


    }
    public function showModificarCinema($id)
    {
        $tipo="modificar";
        $cinemaDAO = new CinemaDAO();
        $cinemaMod=$cinemaDAO->getOneById($id);
        require_once(VIEWS_PATH."FormCrearCinema.php");


    }
    public function showEliminarCine($id)
    {
        $tipo="eliminarcine";
        $this->message="Eliminar el Cine en su totalidad?";
        require_once(VIEWS_PATH."FormConfirmacion.php");


    }
    public function showEliminarCinema($id)
    {
        $tipo="eliminarcinema";
        $this->message="Eliminar la sala de Cine (Cinema)?";
        require_once(VIEWS_PATH."FormConfirmacion.php");


    }
    public function showEliminarfuncion($id)
    {
        $tipo="eliminarfuncion";
        $this->message="Eliminar la Funcion?";
        require_once(VIEWS_PATH."FormConfirmacion.php");


    }
}
?>