<?php
//simple, si no existe loggedUser te fleta al index
  if(!isset($_SESSION["loggedUser"]))
  {
    header("location:../index.php");
  }

  // ARREGLAR, no anda cuando cambias de controller

  /*elseif (!($this->getType() == "home")) //si no es home
  {
      if($this->getType() == "admin") //si es admin
      {
        if (!($_SESSION["loggedUser"] instanceof Admin)) 
        {
          header("location:../index.php"); 
        }
      }
      elseif($this->getType() == "client") //si es client
      {
        //no deberia hacer nada, no?, ya que el admin deberia ver la parte cliente tambien si quiere
        if (!($_SESSION["loggedUser"] instanceof Client)) 
        {
          header("location:../index.php"); 
        }
      }
  }*/
  
?>