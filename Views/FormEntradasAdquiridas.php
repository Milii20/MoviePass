<?php

require_once(VIEWS_PATH."validate-session.php");
require_once(VIEWS_PATH."message.php");
echo "<br> Funciones Adquiridas: <br>";
if(!empty($listacines))
{
    foreach ($listacines as $cine)
    {
        foreach ($cine->getArrayCinemas() as $cinema)
        {
            foreach ($cinema->getArrayFunciones() as $funci)
            {
                $peli = $funci->getPelicula();
                echo "<br>---------------------------------------------------------------------------------------<br>";
                
                echo "<div class=cuerpo2>";
                echo "<div class=infoCine>";
                echo "<br>Titulo: ".$peli->getTitle();
                //echo "<br>ID de Pelicula: ".$peli->getId();
                echo "<br>Puntaje de Popularidad: ".$peli->getPopularity();
                echo "<br>Reseña: ".$peli->getOverview();
                echo "<br>Fecha de Lanzamiento: ".$peli->getReleaseDate();
                echo "<br>Fecha De la Funcion: ".$funci->getFecha();
                echo "<br>Horario De la Funcion: ".$funci->getHora();
                echo "<br>Sala De la Funcion: <br> Direccion: ".$cinema->getDireccion();
                echo "<br>Valor de la entrada $".$cinema->getValorEntrada();
                echo "<br>Tipo de Sala ".$cinema->getTipoSala();
                echo "</div>";
                if ($peli->getImage()!="")
                    {
                        echo '<br><img src="https://image.tmdb.org/t/p/w500'.$peli->getImage().'" height="400" width="300">';
                    }
                    else echo "<br><br><br> <b>No hay Imagen Disponible</b><br><br><br>";
                //echo '<br><img src="https://image.tmdb.org/t/p/w500'.$this->movieDB->getPortrait(array("id"=>$peli->getId())).'" height="400" width="300">';
                
                echo "<div class=qr>";
                echo '<br>Codigo de Entrada: (Presentar al entrar a la sala)';
                foreach ($funci->getArrayAsientos() as $asiento => $cli)
                {
                    
                    if ($cli==$_SESSION['loggedUser']->getId())
                    {
                        echo "<div class=miniqr>";
                        echo "Asiento: ".$asiento;
                        echo $this->generateQrEntrada($funci->getId().",".$asiento);
                        echo "<br>";
                        echo "</div>";
                    }
                    
                }
                echo "</div>";
                echo '</div>';            
                echo "<br>---------------------------------------------------------------------------------------<br>";
                
            }
        }
    }
}
else
{
    echo "Usted no ha adquirido entradas";
}


?>