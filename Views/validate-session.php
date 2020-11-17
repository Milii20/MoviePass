<?php
//simple, si no existe loggedUser te fleta al index
  if(!isset($_SESSION["loggedUser"]))
  {
    header("location:../index.php");
  }
  elseif (strcasecmp($this->getType(), "home")!=0) //si no es home
  {
      if(strcasecmp($this->getType(), "admin")==0) //si es admin
      {
        if (strcasecmp($_SESSION["loggedUser"]->getType(),"admin")!=0) //si el usuario no es admin
        {
          header("location:../index.php"); 
        }
      }
      elseif(strcasecmp($this->getType(), "client")==0) //si es client
      {
        //no deberia hacer nada, no?, ya que el admin deberia ver la parte cliente tambien si quiere
        if (strcasecmp($_SESSION["loggedUser"]->getType(),"client")!=0)   //si el usuario no es client
        {
          header("location:../index.php"); 
        }
      }
  }
  else
  
?>