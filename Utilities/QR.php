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
    
    public function enviarMail($destino,$titulo,$mensaje,$reintentos)
    {
        if (!mail( $destino , $titulo , $mensaje ))
        {
            for ($i=0;$i<=$reintentos;$i++) //retry 
            {
                mail( $destino , $titulo , $mensaje );
            }
        }
        
    }
}
?>