<?php
//muestra las opciones que tiene un admin en su panel de control 
/*<form action="<?php echo FRONT_ROOT."Client/showEntradasAdquiridas" ?>" method="post">
            <button  type="submit" name="btnLogin">Consultar Entradas Adquiridas</button>
    </form>*/
//require_once(VIEWS_PATH."validate-session.php");
//require_once(VIEWS_PATH."message.php");
?>
<div class=menuprincipal>
<br>
Menu Principal
<br>
<br>
<form action="<?php echo FRONT_ROOT."Client/showVerFuncionesDisponibles" ?>" method="post">
            <button  type="submit" name="btnLogin">Ver Funciones Disponibles</button>
    </form><br>
    
<form action="<?php echo FRONT_ROOT."Client/showEntradasAdquiridas" ?>" method="post">
            <button  type="submit" name="btnLogin">Ver Entradas Adquiridas</button>
    </form><br>
    
    <form action="<?php echo FRONT_ROOT."Home/Logout" ?>" method="post">
            <button  type="submit" name="btnLogin">Cerrar Sesion</button>
    </form><br>
    
</div>
    <!--*----*----*----*----*----*----*----*----*----*----*----*----*----*-->
    