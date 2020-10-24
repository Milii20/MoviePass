<?php
/*cine 
Para fines practicos se llama Cinema a UNA SOLA sala de cine, permitiendo poner diferentes valores de entrada en diferentes salas de cine
porque, por ejemplo, el cine aldrey tiene sala 2D, sala 3D y Atmos, pero las 3 pasan diferentes peliculas en diferentes horarios a diferentes precios
por lo que llamar "Cinema" a todo el cine aldrey y todas sus salas no seria practico para el ejemplo, pero ponerle de nombre a un Cinema: AldreyAtmos si, al igual
que Aldrey3D y Aldrey2D, ya que son salas diferentes con atributos diferentes, distribuciones diferentes, todo diferente, lo unico que los une seria el "cine general"
*/
namespace Models;
Class Cinema //tambien conocido como Sala de cine
{
    private $idCinema; //id interna del cinema
    private $idCine; //id del cine al que la sala corresponde
    private $capacidadTotal;
    private $nombre;
    private $direccion;
    private $valorDeEntrada;
    private $tipoSala; //2D, 3D, Atmos, etc
    private $cantGentePorFila; //si no entra por las distribuciones, van atras
    //(ejemplo, de un total de 100 asientos, 12 personas por fila, las ultimas 4 personas quedan solas en la fila de atras central)
    //la sala esta dividida en 3 areas, izquierda, derecha y centro, las siguientes variables determinan los porcentajes de la capacidad total que hay en cada cine
    private $distribucionIzq; //en cantidad 
    private $distribucionDer; //en cantidad, 
    // movido a funcion
    //private $arrayAsientos = array(); //este es un array key value (key siendo el asiento (1A, 2C, 1F, etc) y value la persona que lo ocupa (ID de usuario)) generado en funcion de la cantidad de gente por fila, capacidad total y proporciones
    private $arrayFunciones = array(); //array de las funciones disponibles asociadas a un cine concreto
    
    // sin uso, simplemente usar arrayFunciones y mostrar las uqe aun no fueron (comparando fechas) private $arrayFuncionesPasadas = array(); //array de las funciones que ya pasaron, capaz que es util por alguna razon (estadisticas/historial/algo por el estilo)
    /*public function __construct ($capacidad,$nombre,$dir,$valor,$tipo,$cantFila,$distribucioni,$distribucionD)
    {
        $this->capacidadTotal=$capacidad;
        $this->nombre=$nombre;
        $this->direccion=$dir;
        $this->valorDeEntrada=$valor;
        $this->tipoSala=$tipo;
        $this->cantGentePorFila=$cantFila;
        $this->distribucionIzq=$distribucioni;
        $this->distribucionDer=$distribucionD;
    }*/
    public function getId()
    {
        return $this->idCinema;
    }
    public function setId($id)
    {
        $this->idCinema=$id;
    }
    public function getIdCine()
    {
        return $this->idCine;
    }
    public function setIdCine($id)
    {
        $this->idCine=$id;
    }
    public function getCapacidadTotal()
    {
        return $this->capacidadTotal;
    }
    public function setCapacidadTotal($capacidad)
    {
        $this->capacidadTotal=$capacidad;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre=$nombre;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function setDireccion($direccion)
    {
        $this->direccion=$direccion;
    }
    public function getValorEntrada()
    {
        return $this->valorDeEntrada;
    }
    public function setValorEntrada($valor)
    {
        $this->valorDeEntrada=$valor;
    }
    public function getTipoSala()
    {
        return $this->tipoSala;
    }
    public function setTipoSala($tipo)
    {
        $this->tipoSala=$tipo;
    }
    public function getCantGentePorFila()
    {
        return $this->cantGentePorFila;
    }
    public function setCantGentePorFila($gente)
    {
        $this->cantGentePorFila=$gente;
    }
    public function getDistribucionIzq()
    {
        return $this->distribucionIzq;
    }
    public function setDistribucionIzq($distIzq)
    {
        $this->distribucionIzq=$distIzq;
    }
    public function getDistribucionDer()
    {
        return $this->distribucionDer;
    }
    public function setDistribucionDer($distDer)
    {
        $this->distribucionDer=$distDer;
    }
    public function getArrayFunciones()
    {
        return $this->arrayFunciones;
    }
    public function setArrayFunciones($arrayfun)
    {
        $this->arrayFunciones=$arrayfun;
    }
}
?>