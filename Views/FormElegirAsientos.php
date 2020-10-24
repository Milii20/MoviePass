<?php
//hacerla facil, generar una table con asientos, donde los asientos ocupados se muestran con la celda de color de fondo rojo y sin checkbox, los asientos disponibles se muestran blancos y con checkbox
// pasillos = amarillo o otro color?
//los asientos son checkbox
        require_once(VIEWS_PATH."message.php");
?>

<br>
<br>
Por favor, elija los asientos que desee
<br>
Y luego presione el boton
<br>
<br>
<?php
if (!empty($funcion->getArrayAsientos()))
{
    $abierto=true;
    echo '<form action='.FRONT_ROOT.'Client/SeleccionadosAsientos  method="post">';
   
    echo '<table border="1">';
    foreach($funcion->getArrayAsientos() as $clave => $value)
    {
            //echo "<tr>";
            $arrayIdAsiento=explode(".",$clave);
            if (!$abierto)
            {
                $abierto=true;
                echo "<tr>";
            }
            
            if ($value==0)
            {
                echo '<td bgcolor="#008f39">';
                echo 'Fila: '.$arrayIdAsiento[0].', Asiento: '.$arrayIdAsiento[1]." Disponible";
                echo '<input type="checkbox" name="Asientos[]" value="'.$clave.'">';
            }
            else
            {
                echo '<td bgcolor="#FF0000">';
                echo 'Fila: '.$arrayIdAsiento[0].', Asiento: '.$arrayIdAsiento[1].' Ocupado';
                 
            }
            echo "</td>";
            /*if ($arrayIdAsiento[1]==1)
            {
                $abierto=true;
                echo "<tr>";
            }else*/
            if ($arrayIdAsiento[1]==$cinema->getCantGentePorFila())
            {
                $abierto=false;
                echo "</tr>";
            }
    
    }
    if ($abierto==true)
    {
        echo "<tr>";
    }
    echo '<button  type="submit" name="btnLogin" value='.$funcion->getId().'>Termine de Seleccionar Asientos</button>';
    echo "</table>";        
    echo "</form>";
}

?>
