<?php
// home, loggeo y funciones comunes a los dos tipos de usuarios

    namespace Controllers;
    use utilities\moviedb as moviedb;
    use utilities\QR as QR;
    use DAODB\UserDAO as UserDAO; //cambiar luego a UserDAO de DAOMaster
    use Models\Client as Client;
    use Models\Admin as Admin;

    class HomeController
    {
        private $userDAO;
        private $message = "";
        //testing si anda el filtro de session
        public function getType()
        {
            return "home";
        }
        public function __construct()
        {
            $this->userDAO = new UserDAO();
            $this->message="Welcome to ". APPNAME;
           
        }

        public function Index()
        {
            require_once(VIEWS_PATH."login.php");
        }

        public function ShowCine()
        {   
            $this->message= "Bienvenido!";

            if (strcasecmp($_SESSION['loggedUser']->getType(),"admin")==0)
            {
                require_once(VIEWS_PATH."FormMenuAdmin.php");
            }
            else
            {
                require_once(VIEWS_PATH."FormMenuCliente.php");

            }
        }
        public function showRecuperar()
        {
            $this->message= "Recuperar Contraseña";
            require_once(VIEWS_PATH."FormContraOlvidada.php");
        }
        public function RecuperarPass($email, $password)  //para no complicarme, cambia la pass que sea SI encuentra un email que exista, se que esto es riesgoso, pero
        {                                                 //no cuento con ninguna herramienta de verificacion en 2 pasos
            $user=$this->userDAO->GetByEmail($email);
            if ($user==null) //en otras palabras, si no existe
            {
                $this->message= "El mail ingresado no se encuentra registrado";
                $this->Index();
            }
            else
            {
                $user->setPass($password);
                $this->userDAO->Modify($user);
                $this->message= "Contraseña cambiada, ya puedes loggearte con tu nueva contraseña";
                $this->Index();
            }
        }
        public function Login($email, $password) //segundo recorte por tiempo, no hay loggeo por FB
        {
            $user = $this->userDAO->GetByEmail($email);
            
            if(($user != null) && ($user->getPass() === $password))
            {
                $this->message= "Bienvenido!";
                $user->setPass(""); //medio simple, pero borra la pass del $User que va a estar en session
                $_SESSION["loggedUser"] = $user;
                $this->ShowCine();
            }
            else
            {
                $this->message= "Datos Incorrectos, por favor intente de nuevo";
                $this->Index();
            }
                
        }
        public function showRegistrar()
        {
            $this->message="Registrar Usuario";
            require_once(VIEWS_PATH."FormRegistrarUsuario.php");
        }
        public function Register($nombre, $email, $dia , $mes, $anio, $password)
        {
            $user = new Client();       //no hay metodo para registrar admins aun
            $user->setNombre($nombre);
            $user->setEmail($email);
            $fecha=$dia.".".$mes.".".$anio; //preparado en formato dia.mes.anio
            $user->setFecha($fecha);
            $user->setPass($password);
            //$user->setType("cliente");
            if ($this->userDAO->GetByEmail($email)==null) //en otras palabras, si no existe
            {
                $this->userDAO->addWithId($user);
                $this->message= "Usuario Creado con Exito! Loggeate con tu Email y Contraseña para continuar";
                $this->Index();
            }
            else
            {
                $this->message= "Ya existe un usuario asignado al email ingresado, Olvido su contraseña?";
                $this->Index();
            }
        }
        public function showModificar()
        {

            require_once(VIEWS_PATH."FormModificarUsuario.php");
        }
        public function Modificar($nombre, $email, $dia , $mes, $anio, $password)
        {
            $user = $_SESSION['loggedUser'];
            $user->setNombre($nombre);
            $user->setEmail($email);
            $fecha=$dia.".".$mes.".".$anio; //preparado en formato dia.mes.anio
            $user->setFecha($fecha);
            $user->setPass($password);
            $user->setType("cliente");
            $this->userDAO->Modify($user);
            $this->message= "Usuario Modificado con Exito! Loggeate nuevamente con tu Email y Contraseña para continuar";
            $this->Logout();
        }
        public function showDarDeBaja()
        {

            require_once(VIEWS_PATH."FormDarDeBajaUsuario.php");
        }

        /// COMPLETAR DESDE ACA
        public function DarDeBaja($nombre, $email, $dia , $mes, $anio, $password)
        {
            $user = $_SESSION['loggedUser'];
            $user->setNombre($nombre);
            $user->setEmail($email);
            $fecha=$dia.".".$mes.".".$anio; //preparado en formato dia.mes.anio
            $user->setFecha($fecha);
            $user->setPass($password);
            $user->setType("cliente");
            $this->userDAO->Modify($user);
            $this->message= "Usuario Modificado con Exito! Loggeate nuevamente con tu Email y Contraseña para continuar". $user->getFecha();
            $this->Logout();
        }
        public function Logout()
        {
            unset($_SESSION['loggedUser']);//mejor que simplemente Session destroy
            $message= "Sesion Cerrada con Exito!";
            $this->Index();
        }
    }

?>