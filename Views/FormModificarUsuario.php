<?php
//formulario que permite Modificar la informacion de usuario, solo se puede ver si estas loggeado, o si sos admin, ademas, si sos admin hay un casillero extra que llama a cambiar el "type"
?>
<?php
    require_once(VIEWS_PATH."message.php");
    $arrayFecha=array();
    $arrayFecha=$_SESSION['loggedUser']->getFecha();

?>
<div class=login>
    <form action="<?php echo FRONT_ROOT."Home/Modificar" ?>" method="post">
    Nombre:<br>
    <input type="text" name="nombre" placeholder="<?php echo $_SESSION['loggedUser']->getNombre()  ?>" required><br>
    Email:<br>
    <input type="text" name="email" placeholder="<?php echo $_SESSION['loggedUser']->getEmail()  ?>" required><br>
    Fecha de Nacimiento:<br>
    <select name="dia">
    <?php
        for ($i = 1; $i <= 31; $i++) {
            echo "<option value=".$i;
            if ($arrayFecha[0]==$i)
            echo "selected";
            echo ">".$i."</option>";
        }
    ?>
    </select>
    <select name="mes">
    <option value="1" <?php  
    if ($arrayFecha[1]==1)  
    echo "selected";
    ?>>Enero</option> 
    <option value="2" <?php  
    if ($arrayFecha[1]==2)  
    echo "selected";
    ?>>Febrero</option>
    <option value="3"<?php  
    if ($arrayFecha[1]==3)  
    echo "selected";
    ?>>Marzo</option>
    <option value="4" <?php  
    if ($arrayFecha[1]==4)  
    echo "selected";
    ?>>Abril</option> 
    <option value="5" <?php  
    if ($arrayFecha[1]==5)  
    echo "selected";
    ?>>Mayo</option>
    <option value="6" <?php  
    if ($arrayFecha[1]==6)  
    echo "selected";
    ?>>Junio</option>
    <option value="7" <?php  
    if ($arrayFecha[1]==7)  
    echo "selected";
    ?>>Julio</option> 
    <option value="8" <?php  
    if ($arrayFecha[1]==8)  
    echo "selected";
    ?>>Agosto</option>
    <option value="9"<?php  
    if ($arrayFecha[1]==9)  
    echo "selected";
    ?>>Septiembre</option>
    <option value="10"<?php  
    if ($arrayFecha[1]==10)  
    echo "selected";
    ?>>Octubre</option> 
    <option value="11"<?php  
    if ($arrayFecha[1]==11)  
    echo "selected";
    ?>>Noviembre</option>
    <option value="12"<?php  
    if ($arrayFecha[1]==12)  
    echo "selected";
    ?>>Diciembre</option>
    </select>
    <select name="anio">
    <?php
        for ($i = date('Y'); $i >= date('Y')-100; $i--) {
            echo "<option value=".$i;
            if ($arrayFecha[2]==$i)  
            echo "selected";
            echo ">".$i."</option>";
        }
    ?>
    </select><br>

    Contraseña:<br>
    <input type="text" name="password" placeholder="Contra" required><br>
    <br>
    <button  type="submit" name="btnReg">Completar Registro</button>
    </form>
</div>

