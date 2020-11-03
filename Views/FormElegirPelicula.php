<?php
//muestra las funciones disponibles, el cine en el que estan y la cantidad de asientos disponibles
//de esta manera: pelicula (unica, por mas uqe este en multiples cines), dentro de cada peli un boton que vaya a cada cine 
?>
<?php
require_once(VIEWS_PATH."message.php");$i=0;
if(!empty($listaPelis))
{
    
    echo "<div class=filtrogrande>";
    echo "<div class=filtro2>";
    echo '<form action='.FRONT_ROOT.'Client/filtrarPelisPorFecha  method="post">';
    echo '<button  type="submit" name="btnLogin">Filtrar Peliculas por Fecha</button>';
    echo '</form>';  
    echo "</div>";
    echo "<div class=filtro2>";
    echo '<form action='.FRONT_ROOT.'Client/filtrarPelisPorGenero  method="post">';
    echo '<button  type="submit" name="btnLogin">Filtrar Peliculas por Genero</button>';
    echo '</form>';  
    echo "</div>";
    echo "</div>";
    foreach ($listaPelis as $peli)
    {
        
        echo "<div class=cuerpo2>";
        echo "<br>Titulo: ".$peli["title"];
        echo "<br>ID de Pelicula: ".$peli["id"];
        echo "<br>Puntaje de Popularidad: ".$peli["popularity"];
        echo "<div class=resena>";
        echo "<br>Reseña: ".$peli["overview"];
        echo "</div>";
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
        echo "</div>";
        $i++;
    }
}
else
{
    echo "no hay funciones disponibles";
}
?>