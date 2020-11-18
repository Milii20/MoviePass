<?php
//Controller para las funciones del Cliente
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
use Models\Promo as Promo;
use utilities\moviedb as moviedb;
use utilities\QR as QR;
use utilities\Calendar as Calendar;
use utilities\Luhn as Luhn;
Class ClientController
{
    private $cineDAO;
    private $cinemaDAO;
    private $funcionDAO;
    private $message = "";
    private $movieDB;
    private $funcion; //para no ir y volver 3 veces a la DB, los guardo aca
    private $cinema;
    private $seleccionados;
    private $costoTotal;
    private $cantAsientos;
    //testing si anda el filtro de session
    public function getType()
    {
        return "client";
    }
    public function __construct()
    {
        $this->movieDB = new moviedb();
        //$this->userDAO = new UserDAO();
        $this->cineDAO = new CineDAO();
        $this->funcionDAO = new FuncionDAO();
        $this->cinemaDAO = new CinemaDAO();
        $this->message="Bienvenido Honorable Cliente!";
        require_once(VIEWS_PATH."FormMenuCliente.php");
         
    }
    /*
    public function showEntradasAdquiridas() //REVISAR
    {
        $arrayFunciones=$this->cineDAO->getFuncionPorIdClienteAsiento($_SESSION['loggedUser']->getId());
        $listaCinema=array();
        if(!empty($arrayFunciones))
        {
        foreach($arrayFunciones as $funcion)
        {
            $funci = $funcion['funcion'];
               
            //foreach($funcion as $func)
            {
                 $listaCinema=$this->cineDAO->getCinemaById($funci->getIdCinema());
                array_push($listaPelis,$this->movieDB->getById($funci->getIdPelicula()));
            
            }
}
        }
        require_once(VIEWS_PATH."FormEntradasAdquiridas.php");

    }*/
    public function showVerFuncionesDisponibles($listaFiltrada=null)
    {
        $listaPelis=array();
        $listaCinema=array();
        $generodao = new GeneroDAO();
        $generos = $generodao->getAll();
        if($listaFiltrada==null)
        {
            $listaFunciones=$this->cineDAO->getFuncionDisponible();
        }
        else
        {
            $listaFunciones=$listaFiltrada;
        }
        if(!empty($listaFunciones))
        {
        foreach($listaFunciones as $funcion)
        {
            $listaCinema=$this->cinemaDAO->getCinemaById($funcion->getIdCinema());
            if(Calendar::comparaFechasYHoras(date("d.m.Y"),(Calendar::transformaFechaYHora($funcion->getFecha(),$funcion->getHora()))))
            {
                //no la muestro, la ignoro porque ya paso la funcion
            }
            else
            {
                array_push($listaPelis,$this->movieDB->getById($funcion->getIdPelicula()));
            }
        }
        require_once(VIEWS_PATH."FormElegirPelicula.php");
        } 


         
    }
    public function comprarEntradas($id)
    {
        $funcion=$this->funcionDAO->getFuncionById($id);
        $idCliCli=$_SESSION['loggedUser']->getId();
        $cinema=$this->cinemaDAO->getCinemaById($funcion->getIdCinema());
        require_once(VIEWS_PATH."FormElegirAsientos.php");

            
    }
    public function asignarAsientos($idFuncion,$seleccionados)
    {
        $funcion=$this->funcionDAO->getFuncionById($idFuncion);
        $arrayAsientos = $funcion->getArrayAsientos();
        $selec = explode(",",$seleccionados);
        $arrayQr = array();
        foreach($arrayAsientos as $asiento => $value)
        {
            foreach ($selec as $sel)
            {
                if ($asiento === $sel)   //tiene que ser triple igual o sino asigna valores como 4 y 40 como si fueran la misma persona
                {
                    $arrayAsientos[$asiento]=$_SESSION['loggedUser']->getId();
                    array_push($arrayQr,QR::generate(100,$_SESSION['loggedUser']->getId().",".$idFuncion.",".$asiento));
                }
            }
            
        }
        $funcion->setArrayAsientosFromJson(json_encode($arrayAsientos, JSON_PRETTY_PRINT));
        $qrs=implode(",",$arrayQr);
        QR::enviarMail($_SESSION['loggedUser']->getMail(),"Entradas Adquiridas",$qrs,5);
        $this->funcionDAO->modify($funcion);
        
        //return $arrayAsientos;
    }
    public function SeleccionadosAsientos($id, $sel=null)
    {
        if ($sel!=null)
        {
            $cantAsientos=count($sel);
            $seleccionados=implode(",",$sel);
            $funcion=$this->funcionDAO->getFuncionById($id);
            
            $cinema=$this->cinemaDAO->getCinemaById($funcion->getIdCinema());
            $valor=$cantAsientos*$cinema->getValorEntrada();
            $valorDesc=0;
            if ($cantAsientos>=2)
            {
                $valorDesc=Promo::Aplicable($valor);
            }
            $idfuncion=$id;
            $costoTotal=$cantAsientos*$cinema->getValorEntrada();
            require_once(VIEWS_PATH."FormCheckOut.php");
        }
        else
        {
            $this->showVerFuncionesDisponibles();
        }
        //por ahora, para arreglar un bug, asigno los asientos NI BIEN los selecciona, 
        //antes de verificar tarjeta
        //REVISAR
        //$this->asignarAsientos();

        
    }
    public function showEntradasAdquiridas()
    {
        $funciondao = new FuncionDAO();
        $cinemadao = new CinemaDAO();
        $cinedao = new CineDAO();
        $arrayVacio=array();
        $listafunciones = array();
        $listafunciones = $funciondao->getFuncionesByIdClienteAsiento($_SESSION['loggedUser']->getId());
        $listacinemas = array();
        $listacines=array();
        foreach ($listafunciones as $funcion)
        {
            $cinema=$cinemadao->getOneById($funcion->getIdCinema());
            $cinema->setArrayFunciones($arrayVacio);
            if (!in_array($cinema,$listacinemas))
            {
                array_push($listacinemas,$cinema);
            }
        }
        foreach ($listacinemas as $cinema)
        {
            $cine = $cinedao->getOneById($cinema->getidCine());
            $cine->setArrayCinemas($arrayVacio);
            if (!in_array($cine,$listacines))
            {
                array_push($listacines,$cine);
            }
        }
        foreach ($listacines as $cine)
        {
            foreach ($listacinemas as $cinema)
            {
                foreach ($listafunciones as $funcion)
                {
                    if ($funcion->getIdCinema()==$cinema->getId())
                    {
                        $arrayAux=$cinema->getArrayFunciones();
                        array_push($arrayAux,$funcion);
                        $cinema->setArrayFunciones($arrayAux);
                    }
                }
                if ($cinema->getIdCine()==$cine->getId())
                {
                    $arrayAux=$cine->getArrayCinemas();
                    array_push($arrayAux,$cinema);
                    $cine->setArrayCinemas($arrayAux);
                }
            }
            
        }
        require_once(VIEWS_PATH."FormEntradasAdquiridas.php");

    }
    public function filtrarPelisPorFecha($diaInicial,$mesInicial,$anioInicial,$diaFinal,$mesFinal,$anioFinal)
    {
        $listaFiltrada=array();
        $fechaInicial=$diaInicial.".".$mesInicial.".".$anioInicial;
        $fechaFinal=$diaFinal.".".$mesFinal.".".$anioFinal;
        $listaFunciones=$this->cineDAO->getFuncionDisponible();
        foreach ($listaFunciones as $funcion)
        {
            if ((Calendar::comparaFechas($funcion->getFecha(),$fechaInicial))&&(Calendar::comparaFechas($fechaFinal,$funcion->getFecha())))
            {
                array_push($listaFiltrada,$funcion);
            }
        }
        $this->showVerFuncionesDisponibles($listaFiltrada);
    }
    public function filtrarPelisPorGenero($genero)
    {
        $listaFiltrada=array();
        $listaFunciones=$this->cineDAO->getFuncionDisponible();
        if ($genero ==0) //todas
        {
            $listaFiltrada==$listaFunciones;
        }
        else
        {

            foreach ($listaFunciones as $funcion)
            {
                foreach ($funcion->getPelicula()->getArrayGeneros() as $g)
                {
                    if ($g->getId()==$genero)
                    {
                        array_push($listaFiltrada,$funcion);
                    }
                }
            }
        }
        $this->showVerFuncionesDisponibles($listaFiltrada);
    }
    public function generateQrEntrada($mensaje)
    {
        return $this->generarCodigoQRChiquito($mensaje);
    }
    public function generarCodigoQRGrande($mensaje)
    {
        return QR::generate(500,$mensaje);
    }
    public function generarCodigoQRChiquito($mensaje)
    {
        return QR::generate(150,$mensaje);
    }
    public function VerificarTarjeta($code,$idFuncion,$seleccionados)
    {
        if(!Luhn::luhn_validate($code))
        {
            $this->message="El numero ingresado no corresponde a una tarjeta valida";
            require_once(VIEWS_PATH."FormCheckOut.php");
        }
        else{
            $this->message="Tarjeta Validada, disfrute su compra!. Un mail sera enviado a la brevedad con las entradas adquiridas!";
            // por ahora no es necesaria ya que los asigno cuando los selecciona
            //pero luego la usare
            $this->asignarAsientos($idFuncion,$seleccionados);
            require_once(VIEWS_PATH."FormTicket.php");

        
        }
    }
    
}
?>