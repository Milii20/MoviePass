<?php
//formulario que muestra lo comprado para poder realizar checkout, a la vez aqui se ingresa el numero de tarjeta
?>
<?php
    require_once(VIEWS_PATH."validate-session.php");
    require_once(VIEWS_PATH."message.php");
    echo "<div class=promoCine>";
    echo "SubTotal a abonar $".$valor." por ".$cantAsientos." Entradas";
    if ($valorDesc!=0)
    {
        if ($valorDesc<$valor)
        {
            echo "<br>Ha sido beneficiado con el descuento del 25% los martes y miercoles!";
            echo "<br>Total a Abonar $".$valorDesc."!";
        }

    }
    else
    {
        echo "<br>Total a Abonar $".$valor."";
    }
    echo "</div>";


?>
<br>
<form action="<?php echo FRONT_ROOT."Client/VerificarTarjeta" ?>" method="post">
            <input  type="text" name="NumTarjeta" placeholder="Numero De la Tarjeta" required> <br>
            <input type="hidden" name="idfuncion" id="hiddenField" value="<?php echo $idfuncion;  ?>" /> 
            <input type="hidden" name="seleccionados" id="hiddenField" value="<?php echo $seleccionados;  ?>" /> 
            <button  type="submit" name="btnLogin">Verificar</button>
    </form>

