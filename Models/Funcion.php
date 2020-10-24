<?php
//funcion de cine, incluye un cinema (o una referencia a cinema), un array con los asientos CON CODIGO DE ASIENTO como key y ID DE USUARIO como value, si es 00000000 esta vacio
namespace Models;
Class Funcion
{
    private $idFuncion; //id interna de la funcion, para ordenarlas mejor en DAO
    private $idPelicula; //id referenciando a la pelicula asociada a esta funcion
    private $idCinema; //id referenciando al cine en concreto 
    private $fecha; //fecha de la peli
    private $hora; //hora de la peli
    private $arrayAsientos = array(); //generado en funcion del cine, es un array key como codigo de asiento (A1,A3,B1, etc) y value como id de usuario (si es 00000000 esta vacio)
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($fec)
    {
        $this->fecha=$fec;
    }
    public function getHora()
    {
        return $this->hora;
    }
    public function setHora($hor)
    {
        $this->hora=$hor;
    }
    public function getId()
    {
        return $this->idFuncion;
    }
    public function setId($idfun)
    {
        $this->idFuncion=$idfun;
    }
    public function getIdPelicula()
    {
        return $this->idPelicula;
    }
    public function setIdPelicula($idPeli)
    {
        $this->idPelicula=$idPeli;
    }
    public function getIdCinema()
    {
        return $this->idCinema;
    }
    public function setIdCinema($idCin)
    {
        $this->idCinema=$idCin;
    }
    public function getArrayAsientos()
    {
        return $this->arrayAsientos;
    }
    public function setArrayAsientos($arrayAsi)
    {
        $this->arrayAsientos=$arrayAsi;
    }
    public function getArrayAsientosAsJson()
    {
        return json_encode($this->getArrayAsientos(), JSON_PRETTY_PRINT);
    }
    public function setArrayAsientosFromJson($json)
    {
        $this->arrayAsientos=json_decode($json, true);
    }
    public function generarArrayAsientos($cantAsientosPorFila,$capacidadTotal) //primer compromiso por tiempo: tanto fila como columna de asiento seran numeros, y empezaran de adelante a la izq, en vez de empezar desde el centro
    {
        $arrayAux=array();
        for ($i=1;$i<=($capacidadTotal/$cantAsientosPorFila);$i++) //I es la fila, porque cantTotal/cantPorFila = cantFilas
        {
            for($j=1;$j<=$cantAsientosPorFila;$j++)
            {
                $arrayAux[$i.".".$j]=0; //de esta manera queda: 1.1, 1.2.... 1.12, 2.1, 2.2.... 12.12, tambien inicializa el asiento en 0 para mostrar que no esta ocupado
            }
        }
        $this->setArrayAsientos($arrayAux);
    }
    public function getCantAsientosOcupados()
    {
        $count =0;
        foreach(array_values($this->getArrayAsientos()) as $valor)
        {
           
            if ($valor!=0)
            {
                $count=$count+1;
            }
        }
        return $count;
    }
    public function getCantAsientosDisponibles()
    {
        $count =0;
        foreach(array_values($this->getArrayAsientos()) as $valor)
        {
           
            if ($valor==0)
            {
                $count=$count+1;
            }
        }
        return $count;
    }
    /*
    public function getAsLetra($numero)
    {
        for($i=0;$i<($numero/26);$i++)
        {
            switch ($numero) {
                case 1:
                    $res="A";
                    break;
                case 2:
                    $res="B";
                    break;
                case 3:
                    $res="C";
                    break;
                case 4:
                    $res="D";
                    break;
                case 5:
                    $res="E";
                    break;
                case 6:
                    $res="F";
                    break;
                case 7:
                    $res="G";
                    break;
                case 8:
                    $res="H";
                    break;
                case 9:
                    $res="I";
                    break;
                case 10:
                    $res="J";
                    break;
                case 11:
                    $res="K";
                    break;
                case 12:
                    $res="L";
                    break;
                case 13:
                    $res="M";
                    break;
                case 14:
                    $res="N";
                    break;
                case 15:
                    $res="O";
                    break;
                case 16:
                    $res="P";
                    break;
                case 17:
                    $res="Q";
                    break;
                case 18:
                    $res="R";
                    break;
                case 19:
                    $res="S";
                    break;
                case 20:
                    $res="T";
                    break;
                case 21:
                    $res="U";
                    break;
                case 22:
                    $res="V";
                    break;
                case 23:
                    $res="W";
                    break;
                case 24:
                    $res="X";
                    break;
                case 25:
                    $res="Y";
                    break;
                case 26:
                    $res="Z";
                    break;
        }
                
        }
    }*/
}
?>