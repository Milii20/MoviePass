<?php
//muestra las funciones disponibles, el cine en el que estan y la cantidad de asientos disponibles
//de esta manera: pelicula (unica, por mas uqe este en multiples cines), dentro de cada peli un boton que vaya a cada cine 
?>
<?php
    require_once(VIEWS_PATH."validate-session.php");
require_once(VIEWS_PATH."message.php");$i=0;
echo "<div class=promoCine>";
    echo "Promociones Vigentes: <br>";
    echo "Con tu compra de 2 entradas o mas los dias Martes y Miercoles ";
    echo "obtendras un 25% de descuento!";
    echo "</div>";
    echo "<div class=filtrogrande>";
    echo "<div class=filtro2>";
    echo '<form action='.FRONT_ROOT.'Client/filtrarPelisPorFecha  method="post">';
    echo 'Dia Inicial:<select name="diaInicial">';
        
        for ($i = 1; $i <= 31; $i++) 
        {
        echo "<option value=".$i.">".$i."</option>";
        }

        echo '        </select>
        Mes Inicial:<select name="mesInicial">
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
        Año Inicial:<select name="anioInicial">';

        for ($i = date('Y'); $i <= date('Y')+10; $i++) {
        echo "<option value=".$i.">".$i."</option>";
        }
        echo "</select>";
        echo "<br>";
        echo 'Dia Final:<select name="diaFinal">';
            
            for ($i = 1; $i <= 31; $i++) 
            {
            echo "<option value=".$i.">".$i."</option>";
            }
    
            echo '        </select>
            Mes Final:<select name="mesFinal">
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
            Año Final:<select name="anioFinal">';
    
            for ($i = date('Y'); $i <= date('Y')+10; $i++) {
            echo "<option value=".$i.">".$i."</option>";
            }
            echo "</select>";
    echo '<button  type="submit" name="btnLogin">Filtrar Peliculas por Fecha</button>';
    echo '</form>';  
    echo "</div>";
    echo "<div class=filtro2>";
    echo '<form action='.FRONT_ROOT.'Client/filtrarPelisPorGenero  method="post">';
    echo 'Genero a Filtrar:<select name="genero">';
    foreach ($generos as $gen)
    {
        echo '<option value='.$gen->getId().'>'.$gen->getNombre().'</option>';
    }
    echo '<option selected value="0">Todas</option>';
    echo "</select>";
    echo '<button  type="submit" name="btnLogin">Filtrar Peliculas por Genero</button>';
    echo '</form>'; 
    echo "</div>"; 
    echo "</div>";
if(!empty($listaPelis))
{
    
    $i=0;
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
        echo "<br>Sala De la Funcion: <br> Direccion: ".$listaCinema[$i]->getDireccion();
        echo "<br>Valor de la entrada $".$listaCinema[$i]->getValorEntrada();
        echo "<br>Tipo de Sala ".$listaCinema[$i]->getTipoSala();
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