<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
define("FRONT_ROOT", "/"); //cambiar despues por una ruta util //// POR AHORA queda /, despues mover a otra carpeta
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "layout/styles/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
define("IMG_PATH", VIEWS_PATH . "img/");
define("USEDDAO", "DB"); //para alternar entre DB y JS sin problemas, SOLO ESCRIBIR DB o JS AHI!
define("UTIL",FRONT_ROOT."Utilities/"); //utilidades, entre ellas el generador QR
define("APPNAME","CINE MAX MAX MAX!");
//el siguiente es el request token de themoviedb y la APIKEY 31baafc12a65ec990049016e05ad8589
define("KEY","31baafc12a65ec990049016e05ad8589");
//define("TOKEN","7c104751670f1f5a652bc3c58692a87b4834ab36");
/// estas 4 siguientes definen lo necesario para una DB 
define("DB_HOST", "localhost");
define("DB_NAME", "cines");
define("DB_USER", "root");
define("DB_PASS", "");
/// estas 4 siguientes definen los nombres de las tablas de DB
define("USERTABLE","user");
define("CINETABLE","cines");
define("CINEMATABLE","cinemas");
define("FUNCIONTABLE","funciones");

?>




