<?php
	// muestra errores
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	// muestra errores
	
	//incluye valores base y autoload
	require "Config/Autoload.php";
	require "Config/Config.php";
	//

	//define los autoload router y request
	use Config\Autoload as Autoload;
	use Config\Router 	as Router;
	use Config\Request 	as Request;
	//
		
	//registra el autoload como autoload
	Autoload::start();
	//

	//inicia la sesion
	session_start();
	$_SESSION["message"] = "Welcome!";
	//Include el header
	require_once(VIEWS_PATH."header.php");

	//inicia el router en index
	Router::Route(new Request());

	//incluye el footer
	require_once(VIEWS_PATH."footer.php");
?>