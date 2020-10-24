<?php

require_once(VIEWS_PATH."message.php");
echo "<br> Funciones Adquiridas: <br>"
if(!empty($arrayFunciones))
{
    foreach ($listaPelis as $peli)
    {
        
        echo "<br>---------------------------------------------------------------------------------------<br>";
        echo "<br>Titulo: ".$peli["title"];
        echo "<br>ID de Pelicula: ".$peli["id"];
        echo "<br>Puntaje de Popularidad: ".$peli["popularity"];
        echo "<br>Reseña: ".$peli["overview"];
        echo "<br>Fecha de Lanzamiento: ".$peli["release_date"];
        echo "<br>Fecha De la Funcion: ".$listaFunciones[$i]->getFecha();
        echo "<br>Horario De la Funcion: ".$listaFunciones[$i]->getHora();
        echo "<br>Sala De la Funcion: <br> Direccion: ".$listaCinema->getDireccion();
        echo "<br>Valor de la entrada $".$listaCinema->getValorEntrada();
        echo "<br>Tipo de Sala ".$listaCinema->getTipoSala();
        echo '<br><img src="https://image.tmdb.org/t/p/w500'.$peli["image"].'" height="400" width="300">';
        echo '<form action='.FRONT_ROOT.'Client/comprarEntradas  method="post">';
        echo '<button  type="submit" name="btnLogin" value='.$listaFunciones[$i]->getId().'>Comprar Entradas</button>';
        echo '</form>';            
        echo "<br>---------------------------------------------------------------------------------------<br>";
        $i++;
    }
}
else
{
    echo "Usted no ha adquirido entradas";
}


?>