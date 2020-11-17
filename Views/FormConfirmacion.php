<?php
//muestra los cines existentes
    require_once(VIEWS_PATH."validate-session.php");
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
    <form action="<?php echo FRONT_ROOT."Admin/"; if (strcmp($tipo,"eliminarcine")==0) echo "EliminarCine "; elseif (strcmp($tipo,"eliminarcinema")==0) echo "EliminarCinema "; elseif (strcmp($tipo,"eliminarfuncion")==0) echo "EliminarFuncion "; ?>" method="post">
            <button  type="submit" name="btnLogin" <?php echo 'value='.$id?>>Si</button>
    </form><br>
</div>

    
    
