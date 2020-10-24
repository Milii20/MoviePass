<?php
//formulario que permite crear cinemas
?>

<?php
    require_once(VIEWS_PATH."message.php");
?>
<div class="cuerpochico">
    <br>
    <form action="<?php if ($tipo=="crear") {echo FRONT_ROOT."Admin/CrearCinema";} else {echo FRONT_ROOT."Admin/ModificarCinema";}?>" method="post">
    
            <input  type="text" name="nombre" placeholder="Nombre" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getNombre().'"'; ?> required> <br>
            <input  type="text" name="direccion" placeholder="Direccion" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getDireccion().'"'; ?> required > <br>
            <input  type="number" name="valordeentrada" placeholder="Valor de la Entrada" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getValorEntrada().'"'; ?> required> <br>
            <input  type="text" name="tiposala" placeholder="Tipo de Sala" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getTipoSala().'"'; ?> required> <br>
            <input  type="number" name="capacidadtotal" placeholder="Capacidad Total" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getCapacidadTotal().'"'; ?> required> <br>
            <input  type="number" name="cantgenteporfila" placeholder="Cant de Gente por Fila" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getcantGentePorFila().'"'; ?> required> <br>
            <input  type="number" name="distribucionizq" placeholder="Gente en Lado Izquierdo" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getDistribucionIzq().'"'; ?> required> <br>
            <input  type="number" name="distribucionder" placeholder="Gente en Lado Derecho" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getDistribucionDer().'"'; ?> required> <br>
            <button  type="submit" name="btnLogin" value ="<?php echo $id; if ($tipo=="modificar") echo ';'.$cinemaMod->getId(); ?>"><?php if ($tipo=="crear") echo "Crear Cinema";else echo "Modificar Cinema"; ?></button>
    </form>
    <br>
</div>
