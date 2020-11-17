<?php
//contiene alta, baja, modificacion y consulta de Cines, que contienen cinemas, que contienen funciones
// SEPARAR EN MULTIPLES Y CREAR INTERFACE IDB O IDAODB
//pero en DB
namespace DAODB;
    use DAODB\DAODB as DAODB;
    use DAODB\DBGen as DBGen;
    use DAODB\CinemaDAO as CinemaDAO;   //requerido para poder cargar las salas de cine
    use DAODB\FuncionDAO as FuncionDAO;  
    use Models\Cine as Cine;
    use Utilities\calendar as Calendar;

    class CineDAO extends DAODB
    {
        protected function getDatabase()
        {
            return CINETABLE;
        }
        //private $connection; //DEBUG no es necesaria aca, ya que DBGEN se encarga de la connection
        protected function fromArray($arrayAux)
        {
            $cine=null;
            if (!empty($arrayAux))
            {
            $cine=new Cine();
            $cine->setId($arrayAux['id']);
            $cine->setNombre($arrayAux['nombre']);
            $cine->setDescripcion($arrayAux['descripcion']);
            $cine->setArrayPromosJson($arrayAux['promos']); //ARRAY CON LAS IDS DE LAS PROMOS
            }
            return $cine;
        }
        protected function getArrayType()
        {
            $arrayAux=array();
            $arrayAux['id'] = "INT NOT NULL AUTO_INCREMENT";
            $arrayAux['nombre'] = "VARCHAR (500)";
            $arrayAux['descripcion'] = "VARCHAR (500)";       
            $arrayAux['promos'] = "VARCHAR (500)";   //contiene las ids de las promos
            $arrayAux['CONSTRAINT pk_cinema'] = "PRIMARY KEY (id)";      //primary key
            return $arrayAux;
        }
        
        public function getAll() //Sobreescribe a getAll de DAODB, ya que tiene que traer TODOS los cines con sus cinemas y sus funciones
        {
            $res = DBGen::getAll($this->getDatabase());
            $arrayRes = array();
            $cinemadao = new CinemaDAO();
            foreach ($res as $array)
            {
                $cine = $this->fromArray($array);
                $cine->setArrayCinemas($cinemadao->getAllCinemasFromCineID($cine->getId()));
                array_push($arrayRes, $cine);
            }
            return $arrayRes;
        }
        public function getCineById($id) //trae solo 1
        {
            return $this->getOneById($id);
        }
        public function delete($id)  //sobreescribe al de DAODB
        {
            $cinemadao = new CinemaDAO();
            DBGen::deleteOne($this->getDatabase(), array('id'), $id); //lo busca por id, y lo elimina
            $cinemadao->deleteCinemasByIdCine($id);
        }
        
        public function getFuncionDisponible() //puede traer muchos
        {
            $funciondao = new FuncionDAO();
            $arrayFunciones=array();
            foreach(DBGen::getAll(FUNCIONTABLE) as $funcion)
            {
                
                //foreach($func as $funcion)
                {
                    $func = $funciondao->fromArray($funcion);
                   if (calendar::ComparaFechas($func->getFecha(),date('d.m.y')))
                    {
                        array_push($arrayFunciones,$func);
                    }
                }
                
            }
            return $arrayFunciones;
        
        }       
/* DEBUG VERIFICAR QUE ESTO NO SEA NECESARIO
        
        
        
        public function getFuncionPorIdClienteAsiento($idCliente) //puede traer muchos
        {
            $arrayAsientos=array();
            $arrayFunciones=array();
            foreach(DBGen::getAll(FUNCIONTABLE) as $funcion)
            {
                
                //foreach($func as $funcion)
                {
                    $func = $this->fromArrayFuncion($funcion);
                    foreach ($func->getArrayAsientos() as $clave => $valor)
                    {
                        if ($valor == $idCliente)
                        {
                            $arrayAux=explode(".",$clave);
                            $arrayAsientos['funcion']=$funcion;
                            $arrayAsientos['Fila']=$arrayAux[0];
                            $arrayAsientos['Asiento']=$arrayAux[1];
                            array_push($arrayFunciones,$arrayAsientos);
                        }
                    }
                }
                
            }
            return $arrayFunciones;
        
        }   */      
        /*public function deleteCine($idCine) //eliminar encadenado, elimina el cine,  elimina todos los cinemas y todas las funciones de cada cinema
        {
            DBGen::deleteOne(CINETABLE, array('id'), $idCine); //lo busca por id, y lo elimina
            $this->deleteCinemasByIdCine($idCine);
        }    
        public function deleteCinemasByIdCine($idCine)
        {
            $cinemaArray = array();
            $cinemaArray = $this->getCinemaByIdCine($idCine); //busca todos los cinemas que esten asociados a un cine
            if (!empty($cinemaArray)) 
            {
                foreach ($cinemaArray as $cinema)
                    $this->deleteCinema($cinema->getId());
            }
        }    
     
        public function deleteFuncionesByIdCinema($idCinema)
        {
            $funcionArray = array();
            $funcionArray = $this->getFuncionByIdCinema($idCinema); //busca todas las funciones que dependan de este cinema
            if (!empty($funcionArray))      
            {
                foreach ($funcionArray as $funcion)
                    $this->deleteFuncion($funcion->getId());
            } 
        }     
        public function deleteFuncion($funcionId)
        {
            DBGen::deleteOne(FUNCIONTABLE, array('id'), $funcionId); //lo busca por id, y lo elimina
        }*/

    }
?>