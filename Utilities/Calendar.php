<?php
namespace Utilities;

class calendar
{
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
        elseif ($array1[3]<$array2[3]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y la hora de fecha 2 es mayor a fecha 1, entonces fecha 2 > fecha 1
        {
            $res=false; // no paso
            //echo "3 fecha 2 > fecha 1";
        }
        elseif ($array1[3]>$array2[3]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y la hora de fecha 2 es menor a fecha 1, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
            //echo "3 fecha 2 < fecha 1";
        }
        elseif ($array1[4]<$array2[4]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y es la misma hora, y el minuto 2 es mayor a minuto 1, entonces fecha 2 > fecha 1
        {
            $res=false; // no paso
            //echo "4 fecha 2 > fecha 1";
        }
        elseif ($array1[4]>$array2[4]) //si el anio es correcto, el mes es correcto, y el dia es correcto, y es la misma hora, y el minuto 2 es menor al minuto 1, entonces fecha 2 < fecha 1
        {
            $res=true; //ya paso
            //echo "4 fecha 2 < fecha 1";
        }
        else //si este es precisamente el minuto correcto, true, ya que pronto fecha 2 sera menor a fecha 1
            $res=true;
        return $res;
    }
    
    public static function transformaFechaYHora($fecha, $hora) //true = ya paso (fecha 1 > fecha 2) false = no paso (fecha 1 < fecha 2)
    {
        $res=$fecha; //como esta d.m.y.h.m por lo que d = 0, m = 1, y = 2, hora = 3, min = 4
        $array2=explode(":",$hora);
        foreach ($array2 as $val)
        {
            $res=$res.".".$val;
        }
        return $res;
        
    }
}
?>