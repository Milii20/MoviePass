<?php
namespace Utilities;

class calendar
{
    public static function ComparaFechas($fecha1, $fecha2) //fecha 1 > fecha 2, osea, fecha 1 es anterior 
    {
        $array1=explode(".",$fecha1); //como esta d.m.y d = 0, m = 1, y = 2
        $array2=explode(".",$fecha2);
        $res = false;
        if ($array1[2]<$array2[2]) //el anio es anterior, por ende fecha 2 > fecha 1
        {
            $res=false;
        }
        elseif ($array1[2]>$array2[2]) //el anio es posterior, por ende, fecha 2 < fecha 1
        {
            $res=true;
        }
        elseif ($array1[1]<$array2[1]) //si estan en el mismo anio y el mes es anterior, ya paso
        {
            $res=false;
        }
        elseif ($array1[1]>$array2[1]) //si el mes aun no llego, entonces fecha 2 < fecha 1
        {
            $res=true;
        }
        elseif ($array1[0]<$array2[0]) //si el mes y anio es correcto, pero el dia es anterior
        {
            $res=false;
        }
        else //si el anio es correcto, el mes es correcto, y el dia es igual o mayor
        {
            $res=true;
        }
        return $res;
    }
}
?>