<?php
//muestra las opciones que tiene un admin en su panel de control 

//require_once(VIEWS_PATH."validate-session.php");
//require_once(VIEWS_PATH."message.php");
?>
<div class=menuprincipal>
<br>
Menu Principal
<br>
<br>
<form action="<?php echo FRONT_ROOT."Admin/showAdministrarCines" ?>" method="post">
        <button  type="submit" name="btnLogin">Administrar Cines</button>
</form>

    <!-- /*<form action="<?php //echo FRONT_ROOT."Admin/showAgregarPromo" ?>" method="post">
            <button  type="submit" name="btnLogin">Agregar Promo</button>
    </form>--> 
    <br>
    <form action="<?php echo FRONT_ROOT."Home/Logout" ?>" method="post">
            <button  type="submit" name="btnLogin">Cerrar Sesion</button>
    </form><br>
</div>
    <!--*----*----*----*----*----*----*----*----*----*----*----*----*----*-->
    
    
