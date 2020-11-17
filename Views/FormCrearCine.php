<?php
//formulario que permite crear cines Y MODIFICARLOS (update 9 10 2020)
?>

<?php
    require_once(VIEWS_PATH."validate-session.php");
    require_once(VIEWS_PATH."message.php");
?>
    
    <div class='cuerpo1'>
    <br>
    <form action="<?php if ($tipo=="crear") {echo FRONT_ROOT."Admin/CrearCine";} else {echo FRONT_ROOT."Admin/ModificarCine";} ?>" method="post">
            <input  type="text" name="nombre" placeholder="Nombre" <?php if ($tipo=="modificar"){echo "value=".$cineMod->getNombre();}?> required> <br>
            <input  type="text" name="descripcion" placeholder="descripcion" <?php if ($tipo=="modificar"){echo "value=".$cineMod->getDescripcion();}?> required > <br><br>
             <?php echo "<button  type='submit'"; if ($tipo=="crear"){echo " > Crear Cine";} else {echo "name=id value=".$cineMod->getId()." > Modificar Cine";} echo "</button>"?>
    </form>
    <br>
</div>