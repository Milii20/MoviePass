<?php
//funcion de cine, incluye un cinema (o una referencia a cinema), un array con los asientos CON CODIGO DE ASIENTO como key y ID DE USUARIO como value, si es 00000000 esta vacio

namespace Models;
use Models\iGuardable as iGuardable;
Class Funcion implements iGuardable
{
    private $idFuncion; //id interna de la funcion, para ordenarlas mejor en DAO
    private $Pelicula; //objeto peli
    private $idCinema; //id referenciando al cine en concreto 
    private $fecha; //fecha de la peli
    private $hora; //hora de la peli
    //private $getDuracion;     //no implementado ya que varias viene sin duracion, usar 2 horas 
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
    public function getPelicula()
    {
        return $this->Pelicula;
    }
    public function setPelicula($Peli)
    {
        $this->Pelicula=$Peli;
    }
    public function getIdPelicula()
    {
        return $this->Pelicula->getId();
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
        $impar=false;
        if (0!=($capacidadTotal % $cantAsientosPorFila))
        {
            $impar=true;
        }
        for ($i=1;$i<=($capacidadTotal/$cantAsientosPorFila);$i++) //I es la fila, porque cantTotal/cantPorFila = cantFilas
        {
            for($j=1;$j<=$cantAsientosPorFila;$j++)
            {
                $arrayAux[$i.".".$j]=0; //de esta manera queda: 1.1, 1.2.... 1.12, 2.1, 2.2.... 12.12, tambien inicializa el asiento en 0 para mostrar que no esta ocupado
            }
        }
        if ($impar) //si es impar, agrego la ultima fila
        {   //como queda una sola fila, capacidad restante = resto de la division de la capacidad total dividido la cantidad de asientos por fila, por cantidad de asientos por fila
            $capRestante = ($capacidadTotal % $cantAsientosPorFila);
            //$i++;
            for($j=1;$j<=$capRestante;$j++) //agrego los asientos faltantes)
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
    public function toArray()
    {
        $arrayAux=array();
        $arrayAux['id'] = $this->getId();
        $arrayAux['idpelicula'] = $this->getPelicula()->getId();
        $arrayAux['idcinema'] = $this->getIdCinema();
        $arrayAux['fecha'] = $this->getFecha();
        $arrayAux['hora'] = $this->getHora();
        $arrayAux['asientos'] = $this->getArrayAsientosAsJson();
        //$arrayAux['generos'] = $funcion->getArrayGenerosAsJson(); //DEBUG
        return $arrayAux;
    }
    public function toArrayParam()
    {
        $arrayAux=array();
        array_push($arrayAux, "id");
        array_push($arrayAux, "idpelicula");
        array_push($arrayAux, "idcinema");
        array_push($arrayAux, "fecha");
        array_push($arrayAux, "hora");
        array_push($arrayAux, "asientos");
        //array_push($arrayAux, "generos");  //DEBUG
        return $arrayAux;
    }
    public function toArrayValue()
    {
        $arrayAux=array();
        array_push($arrayAux, $this->getId());
        array_push($arrayAux, $this->getPelicula()->getId());
        array_push($arrayAux, $this->getIdCinema());
        array_push($arrayAux, $this->getFecha());
        array_push($arrayAux, $this->getHora());
        array_push($arrayAux, $this->getArrayAsientosAsJson());
        return $arrayAux;
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