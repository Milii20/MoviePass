<?php
//formulario de registro de nuevos usuarios

    
?>
<?php
    require_once(VIEWS_PATH."message.php");
    
?>
<div class=login>
<form action="<?php echo FRONT_ROOT."Home/Register" ?> " method="post">
Nombre:<br>
<input type="text" name="nombre" placeholder="Nombre Usuario" required><br>
Email:<br>
<input type="text" name="email" placeholder="Correo Electronico" required><br>
Fecha de Nacimiento:<br>
<select name="dia">
<?php
    for ($i = 1; $i <= 31; $i++) {
        echo "<option value=".$i.">".$i."</option>";
    }
?>
</select>
<select name="mes">
  <option value="1">Enero</option> 
  <option value="2">Febrero</option>
  <option value="3">Marzo</option>
  <option value="4">Abril</option> 
  <option value="5">Mayo</option>
  <option value="6">Junio</option>
  <option value="7">Julio</option> 
  <option value="8">Agosto</option>
  <option value="9">Septiembre</option>
  <option value="10">Octubre</option> 
  <option value="11">Noviembre</option>
  <option value="12">Diciembre</option>
</select>
<select name="anio">
<?php
    for ($i = date('Y'); $i >= date('Y')-100; $i--) {
        echo "<option value=".$i.">".$i."</option>";
    }
?>
</select><br>

Contraseña:<br>
<input type="text" name="password" placeholder="Contra" required><br>
<br>
<button  type="submit" name="btnReg">Completar Registro</button>
</form>
</div>
