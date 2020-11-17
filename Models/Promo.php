<?php
//Promos, a la hora de checkout verifica si es aplicable alguna promo

namespace Models;
use Models\iGuardable as iGuardable;
use Utilities\Calendar as Calendar;
Class Promo //implements iGuardable
{
    //no se pueden crear nuevas por el momento, arreglar despues
    /*private $id;
    private $dias;
    private $porcentaje; //porcentaje de descuento
    private $fechaInicio; //inicio de la promo
    private $fechaFin; //fin de la promo*/
    public static function Aplicable($valor)
    {
        if (strcmp(Calendar::day(),"Tuesday")==0)
        {
            $valor=$valor-0.25*$valor;
            return $valor;
        }
        elseif (strcmp(Calendar::day(),"Wednesday")==0)
        {
            $valor=$valor-0.25*$valor;
            return $valor;
        }
        else
        {
            return $valor;
        }
    }
    /*

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
    }
    public function getAsJson()
    {
        $arrayAux=array();
        $arrayAux['tipo'] = $this->getTipo();
        $arrayAux['respuesta'] = $this->getRespuesta();
        $arrayAux['porcentaje'] = $this->getPorcentaje();
        $arrayAux['tienefin'] = $this->getTieneFin();
        $arrayAux['fechainicio'] = $this->getFechaInicio();
        $arrayAux['fechafin'] = $this->getFechaFin();
        return json_encode($arrayAux, JSON_PRETTY_PRINT);
    }
    public function getFromJson($json)
    {
        $arrayAux=json_decode($json, true);
        $this->setTipo($arrayAux['tipo']);
        $this->setRespuesta($arrayAux['respuesta']);
        $this->setPorcentaje($arrayAux['porcentaje']);
        $this->setTieneFin($arrayAux['tienefin']);
        $this->setFechaInicio($arrayAux['fechainicio']);
        $this->setFechaFin($arrayAux['fechafin']);
    }
    
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo=$tipo;
    }
    public function getRespuesta()
    {
        return $this->respuesta;
    }
    public function setRespuesta($resp)
    {
        $this->respuesta=$resp;
    }
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }
    public function setPorcentaje($porcen)
    {
        $this->porcentaje=$porcen;
    }
    public function getTieneFin()
    {
        return $this->tieneFin;
    }
    public function setTieneFin($fin)
    {
        $this->tieneFin=$fin;
    }
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }
    public function setFechaInicio($fecha)
    {
        $this->fechaInicio=$fecha;
    }
    public function getFechaFin()
    {
        return $this->fechaFin;
    }
    public function setFechaFin($fecha)
    {
        $this->fechaFin=$fecha;
    }
    public function verificaFecha()
    {   
        $res=false;
        if (!$this->getTieneFin())
        {
            $res=true;
        }
        else
        {
            $hoy = date("d.m.y");                         // 10.03.01
            $arrayHoy=array();
            $arrayHoy=explode(".",$hoy);
            $arrayInicio=explode(".".getFechaInicio());
            $arrayFin=explode(".".getFechaFin());
            
            if ($arrayFin[2]>=$arrayHoy[2])
            {
                if($arrayInicio[2]<=$arrayHoy[2]) //si el año esta entre el inicio y el fin
                {
                    if ($arrayFin[1]>=$arrayHoy[1])
                    {
                        if($arrayInicio[1]<=$arrayHoy[1]) //si el mes esta entre el inicio y el fin
                        {
                            if ($arrayFin[1]-$arrayHoy[1]==0) //si la diferencia entre mes actual y final es 0, significa que estamos en el mes final, hay que confirmar dias
                            {
                                if ($arrayFin[0]>=$arrayHoy[0])
                                {
                                    if($arrayInicio[0]<=$arrayHoy[0]) //si el dia esta entre el inicio y el fin
                                    {
                                        $res=true;
                                    }
                                }
                            }
                            else
                            {
                                $res=true;
                            }
                        
                        }   
                    }
                }
            }
        }
        return $res; //retorna si es valida la promo o no segun si aun esta disponible o no por fechas
    }
    public function aplicarDescuento($subTotal,$comparar)
    {
        $total = $subtotal;
        if ($this->validar($comparar)==true) 
        {
            $total = $subtotal - ($subtotal * $this->getPorcentaje());
        }
        return $total;
    }    
    public function validar($comparar)
    {
        $res = false;
        if ($this->verificaFecha()==true)
        {
            if ($this->getTipo()==1) //fechaConcreta, las funciones de tal dia tienen descuento
            {
                if ($this->getRespuesta()==$comparar) //comparar en este caso es la fecha de la funcion
                {
                    $res =true;
                }
            }
            elseif ($this->getTipo()==2) //dias de la semana
            {
                if (in_array($comparar,$this->getRespuesta()==true) //ya que es un dia de la semana, respuesta es un array de dias en numero (1 domingo, 2 lunes....)
                {
                    $res=true;
                }
            }
            elseif ($this->getTipo()==3) //mes
            {
                if ($this->getRespuesta()==$comparar) //respuesta es en este caso un numero del 1 al 12
                {
                    $res=true;
                }
            }
            elseif ($this->getTipo()==4) //edad mayor
            {
                $rta = $comparar - date('Y');
                if ($rta>= $this->getRespuesta()) //en este caso se compara el año de nacimiento contra la respuesta, si es mayor el resultado es true 
                {
                    $res=true;
                }
            }
            elseif ($this->getTipo()==5) //edad menor
            {
                $rta =date('Y') - $comparar;
                if ($rta<= $this->getRespuesta()) //en este caso se compara el año de nacimiento contra la respuesta, si es menor el resultado es true
                {
                    $res=true;
                }
            }
            elseif ($this->getTipo()==6) //dias de la semana y edad mayor
            {
                $edadC = date('Y') - $comparar[0];
                $diaC = $comparar[1];
                $edad = $this->getRespuesta()[0];
                $dias = $this->getRespuesta()[1]; //es un grupo de dias, igual que en 2, un array con los dias de la semana correspondiente
                if (in_array($diaC,$dias)) //en este caso, ambos, tanto comparar como respuesta son arrays, donde el lugar 0 hay una edad concreta y 1 el dia de la semana
                {
                    if ($edadC>=$edad)
                    {
                        $res=true;
                    }
                }
            }
            elseif ($this->getTipo()==7) //dias de la semana y edad menor
            {
                $edadC = date('Y') - $comparar[0];
                $diaC = $comparar[1];
                $edad = $this->getRespuesta()[0];
                $dias = $this->getRespuesta()[1]; //es un grupo de dias, igual que en 2, un array con los dias de la semana correspondiente
                if (in_array($diaC,$dias)) //en este caso, ambos, tanto comparar como respuesta son arrays, donde el lugar 0 hay una edad concreta y 1 el dia de la semana
                {
                    if ($edadC<=$edad)
                    {
                        $res=true;
                    }
                }
            }
            
        }
        return $res;
    }
    //DEBUG ARREGLAR
    public function toArray()
    {
        $arrayAux=array();
        $arrayAux['id'] = $this->getId();
        $arrayAux['tipo'] = $this->getNombre();
        $arrayAux['respuesta'] = $this->getEmail();
        $arrayAux['pass'] = $this->getPass();
        $arrayAux['fecha'] = $this->getFecha();
        $arrayAux['type'] = $this->getType();
        return $arrayAux;
    }
    public function toArrayParam()
    {
        $arrayAux=array();
        array_push($arrayAux, "id");
        array_push($arrayAux, "nombre");
        array_push($arrayAux, "email");
        array_push($arrayAux, "pass");
        array_push($arrayAux, "fecha");
        array_push($arrayAux, "type");
        return $arrayAux;
    }
    public function toArrayValue()
    {
        $arrayAux=array();
        array_push($arrayAux, $this->getId());
        array_push($arrayAux, $this->getNombre());
        array_push($arrayAux, $this->getEmail());
        array_push($arrayAux, $this->getPass());
        array_push($arrayAux, $this->getFecha());
        array_push($arrayAux, $this->getType());
        return $arrayAux;        
    }*/
}
?>