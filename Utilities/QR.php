<?php
//funciones para Generar QR
namespace Utilities;
class QR
{
    //usar solo esta:
    public static function generate($size,$mensaje)
    {
        $image = '<img src=https://chart.googleapis.com/chart?chs='.$size.'x'.$size.'&cht=qr&chl='.$mensaje.'&choe=UTF-8>';
        //return $image;
        return $image;
    }
}
?>