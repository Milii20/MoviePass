<?php
//formulario que permite crear cinemas
?>

<?php
    require_once(VIEWS_PATH."validate-session.php");
    require_once(VIEWS_PATH."message.php");
?>
<div class="cuerpochico">
    <br>
    <form action="<?php if ($tipo=="crear") {echo FRONT_ROOT."Admin/CrearCinema";} else {echo FRONT_ROOT."Admin/ModificarCinema";}?>" method="post">
    
            Nombre del Cinema<br>
            <input  type="text" name="nombre" placeholder="Nombre" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getNombre().'"'; ?> required> <br>
            Direccion del Cinema<br>
            <input  type="text" name="direccion" placeholder="Direccion" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getDireccion().'"'; ?> required > <br>
            Valor de la Entrada<br>
            <input  type="number" name="valordeentrada" min="0" placeholder="Valor de la Entrada" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getValorEntrada().'"'; ?> required> <br>
            Tipo de Sala<br>
            <input  type="text" name="tiposala" placeholder="Tipo de Sala" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getTipoSala().'"'; ?> required> <br>
            Capacidad total de la sala<br>
            <input  type="number" name="capacidadtotal" min="0" max="500" placeholder="Capacidad Total" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getCapacidadTotal().'"'; ?> required> <br>
            Cantidad de Gente por Fila<br>
            <input  type="number" name="cantgenteporfila" min="0" max="50" placeholder="Cant de Gente por Fila" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getcantGentePorFila().'"'; ?> required> <br>
            Distribucion Izquierda<br>
            <input  type="number" name="distribucionizq" min="0" max="500" placeholder="Gente en Lado Izquierdo" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getDistribucionIzq().'"'; ?> required> <br>
            Distribucion Derecha<br>
            <input  type="number" name="distribucionder" min="0" max="500" placeholder="Gente en Lado Derecho" <?php if ($tipo=="modificar") echo 'value="'.$cinemaMod->getDistribucionDer().'"'; ?> required> <br>
            <button  type="submit" name="btnLogin" value ="<?php  if ($tipo=="modificar") echo $cinemaMod->getId(); else echo $id; ?>"><?php if ($tipo=="crear") echo "Crear Cinema";else echo "Modificar Cinema"; ?></button>
    </form>
    <br>
</div>
