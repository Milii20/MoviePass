<?php
    require_once(VIEWS_PATH."message.php");
        ?>
<div class=login>
        <br>
        <form action="<?php echo FRONT_ROOT."Home/Login" ?>" method="post">
                <input  type="text" name="email" placeholder="Email" required> <br>
                <input  type="password" name="password" placeholder="Contraseña" required > <br><br>
                <button  type="submit" name="btnLogin">Ingresar</button>
        </form>
        <br>
        <form action="<?php echo FRONT_ROOT."Home/showRegistrar" ?>" method="post">
                <button  type="submit" name="btnLogin">Registrar</button>
        </form><br>
        <form action="<?php echo FRONT_ROOT."Home/showRecuperar" ?>" method="post">
                <button  type="submit" name="btnLogin">Recuperar Contraseña</button>
        </form>
        <br>
</div>
