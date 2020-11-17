<?php
//muestra los cines existentes
    require_once(VIEWS_PATH."validate-session.php");
    require_once(VIEWS_PATH."message.php");
?>
<br>
<form action="<?php echo FRONT_ROOT."Admin/showAgregarNuevoCine" ?>" method="post">
            <button  type="submit" name="btnLogin">Agregar Nuevo Cine</button>
    </form><br>

<?php
    if (!empty($cines))
    {

        foreach($cines as $cine)
        {
            echo "<div class='cinecs'>";
            //echo "<br>/---------------------------------------------------------------------------------------\<br>";
            echo "<div class='infoCine'>";
            echo "<br>Nombre del Cine: ".$cine->getNombre();
            echo "<br>Descripcion del Cine: ".$cine->getDescripcion();
            echo "<br>";
            echo '<form action='.FRONT_ROOT.'Admin/showModificarCine  method="post">';
            echo '<button  type="submit" name="btnLogin" value='.$cine->getId().'>Modificar Cine</button>';
            echo '</form>';
            echo "<br>";
            echo '<form action='.FRONT_ROOT.'Admin/showAgregarCinema  method="post">';
            echo '<button  type="submit" name="btnLogin" value='.$cine->getId().'>Agregar Cinema</button>';
            echo '</form>';
            echo "<br>";
            echo '<form action='.FRONT_ROOT.'Admin/showEliminarCine  method="post">';
            echo '<button  type="submit" name="btnLogin" value='.$cine->getId().'>Eliminar Cine</button>';
            echo '</form>';
            echo '<br>Cantidad de Entradas Vendidas: '.$cine->getCantidadAsientosOcupados();
            echo '<br>Cantidad de Entradas Restantes: '.$cine->getCantidadAsientosDisponibles();
            echo '<br>Ganancia Total Obtenida: '.$cine->getTotalVendidoEnPesos();
            echo "</div>";
            if(!empty($cine->getArrayPromos()))
            {
                echo "<div class='promoCine'>";
                echo "soy una promo";
                echo "</div>";
                echo "<br>";
            }
            if(!empty($cine->getArrayCinemas()))
            {
                echo "<br> Cinemas: <br>";
                foreach($cine->getArrayCinemas() as $cinema)
                {
                    echo "<div class='cinemacs'>";
                    echo "<br> Nombre del Cinema: ".$cinema->getNombre();
                    echo "<br> Capacidad: ".$cinema->getCapacidadTotal();
                    echo "<br> Direccion: ".$cinema->getDireccion();
                    echo "<br> Tipo de Cinema: ".$cinema->getTipoSala();
                    echo "<br> Valor de Entrada: ".$cinema->getValorEntrada();
                    echo "<br> Cantidad de Gente por Fila: ".$cinema->getCantGentePorFila();
                    echo "<br>";
                    echo '<form action='.FRONT_ROOT.'Admin/showModificarCinema  method="post">';
                    echo '<button  type="submit" name="btnLogin" value='.$cinema->getId().'>Modificar Cinema</button>';
                    echo '</form>';
                    echo "<br>";
                    echo '<form action='.FRONT_ROOT.'Admin/showEliminarCinema  method="post">';
                    echo '<button  type="submit" name="btnLogin" value='.$cinema->getId().'>Eliminar Cinema</button>';
                    echo '</form>';
                    echo "<br>";
                    echo '<form action='.FRONT_ROOT.'Admin/showAgregarFuncionPopular  method="post">';
                    echo '<button  type="submit" name="btnLogin" value='.$cinema->getId().'>Agregar Funcion Popular (Mas rating a Menos Rating)</button>';
                    echo '</form>';
                    echo '<br>';
                    echo '<form action='.FRONT_ROOT.'Admin/showAgregarFuncionUltimas  method="post">';
                    echo '<button  type="submit" name="btnLogin" value='.$cinema->getId().'>Agregar Funcion De Peliculas Actuales (Mas nueva a Mas Vieja)</button>';
                    echo '</form>';
                    echo '<br>';
                    echo '<form action='.FRONT_ROOT.'Admin/showAgregarFuncionViejas  method="post">';
                    echo '<button  type="submit" name="btnLogin" value='.$cinema->getId().'>Agregar Funcion De Peliculas Viejas (Mas Vieja a Mas Nueva)</button>';
                    echo '</form>';
                    /*echo '<form action='.FRONT_ROOT.'Admin/showAgregarFuncionUltimas  method="post">';
                    echo '<button  type="submit" name="btnLogin" value='.$cinema->getId().'>Agregar Funcion Ultimas</button>';
                    echo '</form>';*/
                    if (!empty($cinema->getArrayFunciones()))
                    {
                        echo "<br> Funciones del Cinema:";
                        foreach($cinema->getArrayFunciones() as $funcion)
                        {
                            echo "<div class='funcioncs'>";
                            echo "<br> Nombre de la pelicula: ".($this->movieDB->getById($funcion->getPelicula()->getId()))['title'];
                            echo "<br> Fecha: ".$funcion->getFecha();
                            echo "<br> Hora: ".$funcion->getHora();
                            echo "<br> Cantidad de Asientos Vendidos: ".$funcion->getCantAsientosOcupados();
                            echo "<br> Dinero Obtenido Aproximadamente: ".($funcion->getCantAsientosOcupados()*$cinema->getValorEntrada());
                            echo "</div>";
                            //echo "<br>|---------------------------------------------|<br>";
                            echo '<form action='.FRONT_ROOT.'Admin/showEliminarFuncion  method="post">';
                            echo '<button  type="submit" name="btnLogin" value='.$funcion->getId().'>Eliminar Funcion</button>';
                            echo '</form>';
                            echo "<br>";
                        }
                    }
                    else{
                        echo "El Cinema no registra funciones";
                    }
                    //echo "<br>--------------------------------------------- <br>";
                    echo "</div>";
                }
                
            }
            else{         
            echo "<br> El cine no registra cinemas <br>";
            }
            //echo "<br>\---------------------------------------------------------------------------------------/<br>";
            echo "</div>";
        }
    }
    else
    {
        echo "<b>no hay cines cargados en el sistema</b>";
    }
    
?>
