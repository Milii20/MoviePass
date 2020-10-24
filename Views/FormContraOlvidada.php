<?php
//formulario Para Recuperar la contraseña
?>
<?php
    require_once(VIEWS_PATH."message.php");
?>
<div class=login>
<form action="<?php echo FRONT_ROOT."Home/RecuperarPass" ?>" method="post">
Email:<br>
<input type="text" name="email" placeholder="Correo Electronico" required><br>
Nueva Contraseña:<br>
<input type="text" name="password" placeholder="Contra" required><br>
<br>
<input type="submit" value="Cambiar La Contraseña">
</form>
</div>
