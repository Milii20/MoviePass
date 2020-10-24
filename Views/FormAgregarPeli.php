<?php
//formulario que permite agregar pelis a la cartelera, muestra las ultimas
?>

<?php
    require_once(VIEWS_PATH."message.php");
    $sig=@(int)($pag+1);
    $ant=@(int)($pag-1);
    echo "<br>";
    echo '<form action='.FRONT_ROOT.'Admin/showAgregarFuncion'.$fun.'  method="post">';
    echo '<button  type="submit" name="btnLogin" value='.$id.';'.$ant;
    if ($pag<2)
    echo " disabled";
    echo '>Pagina Anterior</button>';
    echo '</form>';
    echo "Pagina: ".$pag;
    echo '<form action='.FRONT_ROOT.'Admin/showAgregarFuncion'.$fun.'  method="post">';
    echo '<button  type="submit" name="btnLogin" value="'.$id.';'.$sig;
    echo ' ">Siguiente Pagina</button>';
    echo '</form>';
    echo "<br>";
    foreach ($listaPelis as $peli)
    {
        echo "<div class=cuerpo2>";
        //echo "<br>---------------------------------------------------------------------------------------<br>";
        
        echo "<br>Titulo: ".$peli["title"];
        echo "<br>ID de Pelicula: ".$peli["id"];
        echo "<br>Puntaje de Popularidad: ".$peli["popularity"];
        echo "<br><div class=resena>";
        echo "Reseña: ".$peli["overview"];
        echo "</div>";
        echo "<br>Fecha de Lanzamiento: ".$peli["release_date"];
        if ($peli["image"]!="")
        {
            echo '<br><img src="https://image.tmdb.org/t/p/w500'.$peli["image"].'" height="400" width="300">';
        }
        else echo "<br><br><br> <b>No hay Imagen Disponible</b><br><br><br>";
        echo '<form action='.FRONT_ROOT.'Admin/crearFuncion  method="post">';
        echo 'Dia:<select name="dia">';
        
        for ($i = 1; $i <= 31; $i++) 
        {
        echo "<option value=".$i.">".$i."</option>";
        }

        echo '        </select>
        Mes:<select name="mes">
        <option value="1">Enero</option> 
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option> 
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option> 
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option> 
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
        </select>
        Año:<select name="anio">';

        for ($i = date('Y'); $i <= date('Y')+10; $i++) {
        echo "<option value=".$i.">".$i."</option>";
        }
        echo "</select>";
        echo 'Hora: <select name="hora">';
        
        for ($i = 0; $i <= 23; $i++) 
        {
        echo "<option value=".$i.">".$i."</option>";
        }
        
        echo "</select>";
        echo 'Minuto: <select name="minuto">';
        
        for ($i = 0; $i <= 59; $i++) 
        {
        echo "<option value=".$i.">".$i."</option>";
        }
        
        echo "</select>";

        echo '<button  type="submit" name="btnLogin" value='.$peli["id"].".".$id.'>Agregar Funcion</button>';
        echo '</form>';            
        //echo "<br>---------------------------------------------------------------------------------------<br>";
        echo "</div>";
    }
?>

