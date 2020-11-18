<?php
namespace Utilities;

class calendar
{
    public static function entreDosFechas($fecha1,$fecha2, $fechaVerificar) //true = fechaVerificar>fecha 1 y < fecha 2
    {
        $res = false;
        if (self::comparaFechasYHoras($fechaVerificar, $fecha1))    //posterior a fecha 1
            if(self::comparaFechasYHoras($fecha2, $fechaVerificar)) //anterior a fecha2
                $res = true;
        return $res;
        
    }
    public static function comparaFechasYHoras($fecha1, $fecha2) //true = ya paso (fecha 1 > fecha 2) false = no paso (fecha 1 < fecha 2)
    {
        $array1=explode(".",$fecha1); //como esta d.m.y.h.m por lo que d = 0, m = 1, y = 2, hora = 3, min = 4
        $array2=explode(".",$fecha2);
        $res = false;
        if ($array1[2]<$array2[2]) //el anio es anterior, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[2]>$array2[2]) //el anio es posterior, por ende, fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[1]<$array2[1]) //si estan en el mismo anio y el mes es anterior, ya paso, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[1]>$array2[1]) //si el mes aun no llego, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[0]<$array2[0]) //si el mes y anio es correcto, pero el dia es anterior, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[0]>$array2[0]) //si el anio es correcto, el mes es correcto, y el dia es mayor, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[3]<$array2[3]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y la hora de fecha 2 es mayor a fecha 1, entonces fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[3]>$array2[3]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y la hora de fecha 2 es menor a fecha 1, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[4]<$array2[4]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y es la misma hora, y el minuto 2 es mayor a minuto 1, entonces fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[4]>$array2[4]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y es la misma hora, y el minuto 2 es menor al minuto 1, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        else //si este es precisamente el minuto correcto, true, ya que pronto fecha 2 sera menor a fecha 1
            $res=true;
        return $res;
    }
        public static function comparaFechasYHorasConMargen($fecha1, $fecha2,$margen) //true = ya paso (fecha 1 > fecha 2) false = no paso (fecha 1 < fecha 2)
        {
        $array1=explode(".",$fecha1); //como esta d.m.y.h.m por lo que d = 0, m = 1, y = 2, hora = 3, min = 4
        $array2=explode(".",$fecha2);
        $res = false;
        if ($array1[2]<$array2[2]) //el anio es anterior, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[2]>$array2[2]) //el anio es posterior, por ende, fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[1]<$array2[1]) //si estan en el mismo anio y el mes es anterior, ya paso, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[1]>$array2[1]) //si el mes aun no llego, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[0]<$array2[0]) //si el mes y anio es correcto, pero el dia es anterior, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[0]>$array2[0]) //si el anio es correcto, el mes es correcto, y el dia es mayor, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[3]<$array2[3]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y la hora de fecha 2 es mayor a fecha 1, entonces fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[3]>$array2[3]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y la hora de fecha 2 es menor a fecha 1, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        elseif ($array1[4]<$array2[4]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y es la misma hora, y el minuto 2 es mayor a minuto 1, entonces fecha 2 > fecha 1
        {
            $res=false; // no paso
        }
        elseif ($array1[4]>$array2[4]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y es la misma hora, y el minuto 2 es menor al minuto 1, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
        }
        else //si este es precisamente el minuto correcto, true, ya que pronto fecha 2 sera menor a fecha 1
            $res=true;
        return $res;
    }
    public static function restaMinutos($fecha,$restar) //funcion vaga, solo maximo de 120 cuanto mucho
    {
        $array1=explode(".",$fecha);
        if ($array1[4]>=$restar)    //si le puedo restar a los minutos le resto a los minutos
        {
            $array1[4]=$array1[4]-$restar;
        }
        else
        {
            $restar=$restar-$array1[4];
            $array1[4]=60-$restar;
            if ($array1[3]>=1)  //si no le puedo restar a los minutos le resto a las horas
            {
                $array1[3]=$array1[3]-1;
            }
            elseif ($array1[0]>1)  //si no le puedo restar a las horas le resto a los dias
            {
                $array1[0]=$array1[0]-1;
                $array1[3]=23;
            }
            elseif ($array1[1]>1)  //si no le puedo restar a los dias le resto a los meses
            {
                $array1[0]=31;
                $array1[3]=23;
                $array1[1]=$array1[1]-1;
            }
            else      //si no le puedo restar a los meses le resto a los años
            {
                $array1[0]=31;
                $array1[3]=23;
                $array1[1]=12;
                $array1[2]=$array1[2]-1;
            }

            $res=implode(".",$array1);
            return $res;
        }
    }
    public static function sumaMinutos($fecha,$sumar) //funcion vaga, solo maximo de 120 cuanto mucho
    {
        $array1=explode(".",$fecha);
        if ($array1[4]+$sumar>=60)    //si le puedo sumar a los minutos le sumo a los minutos
        {
            $array1[4]=$array1[4]+$sumar;
        }
        else
        {
            $array1[4]=$array1[4]+$sumar-60;
            if ($array1[3]<=22)  //si no le puedo sumar a los minutos le sumo a las horas
            {
                $array1[3]=$array1[3]+1;
            }
            elseif ($array1[0]<31)  //si no le puedo sumar a las horas le sumo a los dias
            {
                $array1[0]=$array1[0]+1;
                $array1[3]=0;
            }
            elseif ($array1[1]<12)  //si no le puedo sumar a los dias le sumo a los meses
            {
                $array1[0]=1;
                $array1[3]=0;
                $array1[1]=$array1[1]+1;
            }
            else      //si no le puedo sumar a los meses le sumo a los años
            {
                $array1[0]=1;
                $array1[3]=0;
                $array1[1]=1;
                $array1[2]=$array1[2]+1;
            }
            
            $res=implode(".",$array1);
            return $res;

        }
    }
    public static function agregaDuracionDePelicula($fecha) //funcion vaga, agrega 2 horas
    {
        $array1=explode(".",$fecha);
        if ($array1[3]<=21)  //si no le puedo sumar a los minutos le sumo a las horas
            {
                $array1[3]=$array1[3]+2;
            }
            elseif ($array1[0]<31)  //si no le puedo sumar a las horas le sumo a los dias
            {
                $array1[3]=1;
                $array1[0]=$array1[0]+1;
            }
            elseif ($array1[1]<12)  //si no le puedo sumar a los dias le sumo a los meses
            {
                $array1[0]=1;
                $array1[3]=1;
                $array1[1]=$array1[1]+1;
            }
            else      //si no le puedo sumar a los meses le sumo a los años
            {
                $array1[0]=1;
                $array1[3]=1;
                $array1[1]=1;
                $array1[2]=$array1[2]+1;
            }

            $res=implode(".",$array1);
            return $res;
    }
    public static function comparaFechas($fecha1, $fecha2) //true = ya paso (fecha 1 > fecha 2) false = no paso (fecha 1 < fecha 2)
    {

        $array1=explode(".",$fecha1); //como esta d.m.y.h.m por lo que d = 0, m = 1, y = 2, hora = 3, min = 4
        $array2=explode(".",$fecha2);
        $res = false;
        if ($array1[2]<$array2[2]) //el anio es anterior, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
            //echo "0 fecha 2 > fecha 1";
        }
        elseif ($array1[2]>$array2[2]) //el anio es posterior, por ende, fecha 2 < fecha 1
        {
            $res=true; //ya paso
            //echo "0 fecha 2 < fecha 1";
        }
        elseif ($array1[1]<$array2[1]) //si estan en el mismo anio y el mes es anterior, ya paso, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
            //echo "1 fecha 2 > fecha 1";
        }
        elseif ($array1[1]>$array2[1]) //si el mes aun no llego, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
            //echo "1 fecha 2 < fecha 1";
        }
        elseif ($array1[0]<$array2[0]) //si el mes y anio es correcto, pero el dia es anterior, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
            //echo "2 fecha 2 > fecha 1";
        }
        elseif ($array1[0]>$array2[0]) //si el anio es correcto, el mes es correcto, y el dia es mayor, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
            //echo "2 fecha 2 < fecha 1";
        }
        else //si este es precisamente el dia, mes y año ya paso
            $res=true;
        return $res;
    }
    
    public static function transformaFechaYHora($fecha, $hora) //une una fecha y una hora en una sola variable
    {
        $res=$fecha; //como esta d.m.y.h.m por lo que d = 0, m = 1, y = 2, hora = 3, min = 4
        $array2=explode(":",$hora);
        foreach ($array2 as $val)
        {
            $res=$res.".".$val;
        }
        return $res;
        
    }
    public static function comparaDias($fecha1,$fecha2) //true = son el mismo dia, false = no son iguales
    {
        $array1=explode(".",$fecha1); //como esta d.m.y.h.m por lo que d = 0, m = 1, y = 2, hora = 3, min = 4
        $array2=explode(".",$fecha2);
        $res = false;
        if ($array1[2]!=$array2[2]) //el anio es anterior, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
            //echo "0 fecha 2 > fecha 1";
        }
        elseif ($array1[1]!=$array2[1]) //el anio es posterior, por ende, fecha 2 < fecha 1
        {
            $res=false; //ya paso
            //echo "0 fecha 2 < fecha 1";
        }
        elseif ($array1[0]!=$array2[0]) //si estan en el mismo anio y el mes es anterior, ya paso, por ende fecha 2 > fecha 1
        {
            $res=false; // no paso
            //echo "1 fecha 2 > fecha 1";
        }
        else
        {
            $res=true;
        }
    }
    
    public static function day()
    {
        
        return date("l");
    }
}
?>