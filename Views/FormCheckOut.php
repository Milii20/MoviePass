<?php
//formulario que muestra lo comprado para poder realizar checkout, a la vez aqui se ingresa el numero de tarjeta
?>
<?php
    require_once(VIEWS_PATH."message.php");
    echo "Usted esta por abonar ".$this->costoTotal." por ".$this->cantAsientos." Entradas";
?>

<form action="<?php echo FRONT_ROOT."Client/VerificarTarjeta" ?>" method="post">
            <input  type="text" name="NumTarjeta" placeholder="Numero De la Tarjeta" required> <br>
            <button  type="submit" name="btnLogin">Verificar</button>
    </form>

