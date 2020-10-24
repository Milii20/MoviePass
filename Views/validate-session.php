<?php
//simple, si no existe loggedUser te fleta al index
  if(!isset($_SESSION["loggedUser"]))
    header("location:../index.php");  
?>