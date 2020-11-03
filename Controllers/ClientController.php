<?php
//Controller para las funciones del Cliente
namespace Controllers;
use DAOMaster\CineDAO as CineDAO;
use DAOMaster\UserDAO as UserDAO; 
use Models\Cine as Cine;
use Models\Cinema as Cinema;
use Models\Funcion as Funcion;
use Models\User as User;
use utilities\moviedb as moviedb;
use utilities\Luhn as Luhn;
use utilities\Calendar as Calendar;
Class ClientController
{
    private $cineDAO;
    private $message = "";
    private $movieDB;
    private $funcion; //para no ir y volver 3 veces a la DB, los guardo aca
    private $cinema;
    private $seleccionados;
    private $costoTotal;
    private $cantAsientos;
    //testing si anda el filtro de session
    private $type = "client";
    public function getType()
    {
        return $this->type;
    }
    public function __construct()
    {
        $this->movieDB = new moviedb();
        //$this->userDAO = new UserDAO();
        $this->cineDAO = new CineDAO();
        $this->message="Bienvenido Honorable Cliente!";
        require_once(VIEWS_PATH."FormMenuCliente.php");
        require_once(VIEWS_PATH."validate-session.php");
         
    }
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
        require_once(VIEWS_PATH."validate-session.php");
    }
    public function showVerFuncionesDisponibles()
    {
        $listaFunciones=$this->cineDAO->getFuncionDisponible();
        $listaPelis=array();
        $listaCinema=array();
        if(!empty($listaFunciones))
        {
        foreach($listaFunciones as $funcion)
        {
            $listaCinema=$this->cineDAO->getCinemaById($funcion->getIdCinema());
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

        require_once(VIEWS_PATH."validate-session.php");
         
    }
    public function comprarEntradas($id)
    {
        $funcion=$this->cineDAO->getFuncionById($id);
        $cinema=$this->cineDAO->getCinemaById($funcion->getIdCinema());
        require_once(VIEWS_PATH."FormElegirAsientos.php");
        require_once(VIEWS_PATH."validate-session.php");
            
    }
    public function asignarAsientos()
    {
        
    }
    public function SeleccionadosAsientos($id, $sel)
    {
        $seleccionados=$sel;
        $funcion=$this->cineDAO->getFuncionById($id);
        
        $cinema=$this->cineDAO->getCinemaById($funcion->getIdCinema());
        $cantAsientos=count($seleccionados);
        $costoTotal=$cantAsientos*$cinema->getValorEntrada();
        //por ahora, para arreglar un bug, asigno los asientos NI BIEN los selecciona, 
        //antes de verificar tarjeta
        //REVISAR
        $arrayAsientos = $funcion->getArrayAsientos();
        foreach($arrayAsientos as $asiento => $value)
        {
            foreach ($seleccionados as $sel)
            {
                if ($asiento == $sel)
                {
                    $arrayAsientos[$asiento]=$_SESSION['loggedUser']->getId();
                }
            }
            
        }
        $funcion->setArrayAsientosFromJson(json_encode($arrayAsientos, JSON_PRETTY_PRINT));
        $this->cineDAO->modifyFuncion($funcion);

        require_once(VIEWS_PATH."FormCheckOut.php");
        require_once(VIEWS_PATH."validate-session.php");
        
    }
    public function VerificarTarjeta($code)
    {
        if(!Luhn::luhn_validate($code))
        {
            $this->message="El numero ingresado no corresponde a una tarjeta valida";
            require_once(VIEWS_PATH."FormCheckOut.php");
            require_once(VIEWS_PATH."validate-session.php");
        
        }
        else{
            $this->message="Tarjeta Validada, disfrute su compra!";
            // por ahora no es necesaria ya que los asigno cuando los selecciona
            //pero luego la usare
            //$this->asignarAsientos();
            require_once(VIEWS_PATH."FormTicket.php");
            require_once(VIEWS_PATH."validate-session.php");
        
        }
    }
    
}
?>