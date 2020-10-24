<?php
//muestra los cines existentes
    require_once(VIEWS_PATH."message.php");
?>
<div class=menuprincipal>
<br>
Lo hara?
<br>
<br>
<form action="<?php echo FRONT_ROOT."Admin/showAdministrarCines" ?>" method="post">
        <button  type="submit" name="btnLogin">No</button>
</form>
    <br>
    <form action="<?php echo FRONT_ROOT."Admin/"; if ($tipo=="eliminarcine") echo "EliminarCine "; elseif ($tipo=="eliminarcinema") echo "EliminarCinema "; elseif ($tipo=="eliminarfuncion") echo "EliminarFuncion "; ?>" method="post">
            <button  type="submit" name="btnLogin" <?php echo 'value='.$id?>>Si</button>
    </form><br>
</div>

    
    
