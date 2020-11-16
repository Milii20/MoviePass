<?php
//COPIA DE SEGURIDAD ANTES DE REHACER TODO DAODB
namespace DAODB;
    use DAODB\DBGen as DBGen;
    use Models\Cine as Cine;
    use Models\Cinema as Cinema;
    use Models\Funcion as Funcion;
    use Utilities\calendar as Calendar;

    class CineDAO 
    {
        //private $connection; //DEBUG no es necesaria aca, ya que DBGEN se encarga de la connection
        private function toArrayCine(Cine $cine)
        {
            $arrayAux=array();
            $arrayAux['id'] = $cine->getId();
            $arrayAux['nombre'] = $cine->getNombre();
            $arrayAux['descripcion'] = $cine->getDescripcion();
            $arrayAux['promos'] = $cine->getArrayPromosJson();
            return $arrayAux;
        }
        private function toArrayCinema(Cinema $cinema)
        {
            $arrayAux=array();
            $arrayAux['id'] = $cinema->getId();
            $arrayAux['idcine'] = $cinema->getIdCine();
            $arrayAux['capacidadtotal'] = $cinema->getCapacidadTotal();
            $arrayAux['nombre'] = $cinema->getNombre();
            $arrayAux['direccion'] = $cinema->getDireccion();
            $arrayAux['valordeentrada'] = $cinema->getValorEntrada();
            $arrayAux['tiposala'] = $cinema->getTipoSala();
            $arrayAux['cantgenteporfila'] = $cinema->getCantGentePorFila();
            $arrayAux['distribucionizq'] = $cinema->getDistribucionIzq();
            $arrayAux['distribucionder'] = $cinema->getDistribucionDer();
            return $arrayAux;
        }
        private function toArrayFuncion(Funcion $funcion)
        {
            $arrayAux=array();
            $arrayAux['id'] = $funcion->getId();
            $arrayAux['idpelicula'] = $funcion->getIdPelicula();
            $arrayAux['idcinema'] = $funcion->getIdCinema();
            $arrayAux['fecha'] = $funcion->getFecha();
            $arrayAux['hora'] = $funcion->getHora();
            $arrayAux['asientos'] = $funcion->getArrayAsientosAsJson();
            //$arrayAux['generos'] = $funcion->getArrayGenerosAsJson(); //DEBUG
            return $arrayAux;
        }
        private function toArrayParamCine()
        {
            $arrayAux=array();
            array_push($arrayAux, "id");
            array_push($arrayAux, "nombre");
            array_push($arrayAux, "descripcion");
            array_push($arrayAux, "promos");
            return $arrayAux;
        }
        private function toArrayParamCinema()
        {
            $arrayAux=array();
            array_push($arrayAux, "id");
            array_push($arrayAux, "idcine");
            array_push($arrayAux, "capacidadtotal");
            array_push($arrayAux, "nombre");
            array_push($arrayAux, "direccion");
            array_push($arrayAux, "valordeentrada");
            array_push($arrayAux, "tiposala");
            array_push($arrayAux, "cantgenteporfila");
            array_push($arrayAux, "distribucionizq");
            array_push($arrayAux, "distribucionder");
            return $arrayAux;
        }
        private function toArrayParamFuncion()
        {
            $arrayAux=array();
            array_push($arrayAux, "id");
            array_push($arrayAux, "idpelicula");
            array_push($arrayAux, "idcinema");
            array_push($arrayAux, "fecha");
            array_push($arrayAux, "hora");
            array_push($arrayAux, "asientos");
            //array_push($arrayAux, "generos");  //DEBUG
            return $arrayAux;
        }
        private function toArrayValueCine($cine)
        {
            $arrayAux=array();
            array_push($arrayAux, $cine->getId());
            array_push($arrayAux, $cine->getNombre());
            array_push($arrayAux, $cine->getDescripcion());
            array_push($arrayAux, $cine->getArrayPromosJson());
            return $arrayAux;
        }
        private function toArrayValueCinema($cinema)
        {
            $arrayAux=array();
            array_push($arrayAux,  $cinema->getId());
            array_push($arrayAux,  $cinema->getIdCine());
            array_push($arrayAux,  $cinema->getCapacidadTotal());
            array_push($arrayAux,  $cinema->getNombre());
            array_push($arrayAux,  $cinema->getDireccion());
            array_push($arrayAux,  $cinema->getValorEntrada());
            array_push($arrayAux,  $cinema->getTipoSala());
            array_push($arrayAux,  $cinema->getCantGentePorFila());
            array_push($arrayAux,  $cinema->getDistribucionIzq());
            array_push($arrayAux,  $cinema->getDistribucionDer());
            return $arrayAux;
        }
        private function toArrayValueFuncion($funcion)
        {
            $arrayAux=array();
            array_push($arrayAux, $funcion->getId());
            array_push($arrayAux, $funcion->getIdPelicula());
            array_push($arrayAux, $funcion->getIdCinema());
            array_push($arrayAux, $funcion->getFecha());
            array_push($arrayAux, $funcion->getHora());
            array_push($arrayAux, $funcion->getArrayAsientosAsJson());
            return $arrayAux;
        }
        private function fromArrayCine($arrayAux)
        {
            $cine=null;
            if (!empty($arrayAux))
            {
            $cine=new Cine();
            $cine->setId($arrayAux['id']);
            $cine->setNombre($arrayAux['nombre']);
            $cine->setDescripcion($arrayAux['descripcion']);
            $cine->setArrayPromosJson($arrayAux['promos']);
            }
            return $cine;
        }
        private function fromArrayCinema($arrayAux)
        {   
            $cinema=null;
            if (!empty($arrayAux))
            {
                $cinema = new Cinema();
                $cinema->setId($arrayAux["id"]);
                $cinema->setIdCine($arrayAux['idcine']);
                $cinema->setCapacidadTotal($arrayAux['capacidadtotal']);
                $cinema->setNombre($arrayAux['nombre']);
                $cinema->setDireccion($arrayAux['direccion']);
                $cinema->setValorEntrada($arrayAux['valordeentrada']);
                $cinema->setTipoSala($arrayAux['tiposala']);
                $cinema->setCantGentePorFila($arrayAux['cantgenteporfila']);
                $cinema->setDistribucionIzq($arrayAux['distribucionizq']);
                $cinema->setDistribucionDer($arrayAux['distribucionder']);
                
            }         
            return $cinema;
        }
        private function fromArrayFuncion($arrayAux)
        {
            $funcion = null;
            if (!empty($arrayAux))
            {
                $funcion = new Funcion();
                $funcion->setId($arrayAux['id']);
                $funcion->setIdPelicula($arrayAux['idpelicula']);
                $funcion->setIdCinema($arrayAux['idcinema']);
                $funcion->setFecha($arrayAux['fecha']);
                $funcion->setHora($arrayAux['hora']);
                $funcion->setArrayAsientosFromJson($arrayAux['asientos']);
                
            }
            return $funcion;
        }
        public function GiveIdCine()
        {
            return DBGen::getNewId(CINETABLE);
        }
        public function GiveIdCinema()
        {
            return DBGen::getNewId(CINEMATABLE);
        }
        public function GiveIdFuncion()
        {
            return DBGen::getNewId(FUNCIONTABLE);
        }
        public function addCine($cine)
        {
            $cine->setId($this->GiveIdCine());
            DBGen::addOne(CINETABLE, $this->toArrayCine($cine));
        }    
        public function addCinema($cinema)
        {
            $cinema->setId($this->GiveIdCinema());
            
            DBGen::addOne(CINEMATABLE, $this->toArrayCinema($cinema));
        }   
        public function addFuncion($funcion)
        {
            $funcion->setId($this->GiveIdFuncion());
            DBGen::addOne(FUNCIONTABLE, $this->toArrayFuncion($funcion));
        }
        public function getAllCine()
        {
            $res = DBGen::getAll(CINETABLE);
            $arrayCine = array();
            foreach ($res as $cine)
            {
                array_push($arrayCine,$this->fromArrayCine($cine));
            }
            return $arrayCine;
        }   
        public function getCineById($id) //trae solo 1
        {
            foreach(DBGen::getOne(CINETABLE,array("id"), array($id)) as $cine)
            {
                $cineObj = $this->fromArrayCine($cine);
            }
            return $cineObj;
        }    
        public function getCinemaById($id) //trae solo 1
        {
            $des = DBGen::getOne(CINEMATABLE,array("id"), array($id));
            $res = null;
            $res = $this->fromArrayCinema($des[0]);
            return $res;
            /*
            foreach ($res as $cinema)
            {
                array_push($arrayCinema,$this->fromArrayCinema($cinema));
            }
            return  $arrayCinema;*/
        }       
        public function getCinemaByIdCine($id) //puede traer muchos
        {
            $arrayCinemas=array();
            foreach(DBGen::getOne(CINEMATABLE,array("idcine"), array($id)) as $cinema)
            {
                array_push($arrayCinemas,$this->fromArrayCinema($cinema));
            }
            return $arrayCinemas;
        }   
        public function getFuncionById($id) //trae solo 1
        {
            $res = null;
            $des= DBGen::getOne(FUNCIONTABLE,array("id"), array($id));
            $res= $this->fromArrayFuncion($des[0]);
            return $res;
            /*foreach(DBGen::getOne(FUNCIONTABLE,array("id"), array($id)) as $funcion)
            {
                $res = $this->fromArrayFuncion($funcion);
            }*/
            
            //return $res;
        }      
        public function getFuncionByIdCinema($id) //puede traer muchos
        {
            $arrayFunciones=array();
            foreach(DBGen::getOne(FUNCIONTABLE,array("idcinema"), array($id)) as $funcion)
            {
                array_push($arrayFunciones,$this->fromArrayFuncion($funcion));
            }
            return $arrayFunciones;
        }      
        public function getFuncionDisponible() //puede traer muchos
        {
            $arrayFunciones=array();
            foreach(DBGen::getAll(FUNCIONTABLE) as $funcion)
            {
                
                //foreach($func as $funcion)
                {
                    $func = $this->fromArrayFuncion($funcion);
                   if (calendar::ComparaFechas($func->getFecha(),date('d.m.y')))
                    {
                        array_push($arrayFunciones,$func);
                    }
                }
                
            }
            return $arrayFunciones;
        
        }       
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
        
        }         
        public function modifyCine($cine)
        {
            $cineFound = $this->GetCineById($cine->getId());
            if ($cineFound!=null)
            {
                DBGen::updateOne(CINETABLE, array('id'),array($cine->getId()), $this->toArrayParamCine(), $this->toArrayValueCine($cine)); 
            }
        }    
        public function modifyCinema($cinema)
        {
            $cinemaFound = $this->GetCinemaById($cinema->getId());
            if ($cinemaFound!=null)
            {
                DBGen::updateOne(CINEMATABLE, array('id'),array($cinema->getId()), $this->toArrayParamCinema(), $this->toArrayValueCinema($cinema)); 
            }
        }   
        public function modifyFuncion($funcion)
        {
            $funcionFound = $this->GetFuncionById($funcion->getId());
            if ($funcionFound!=null)
            {
                DBGen::updateOne(FUNCIONTABLE, array('id'),array($funcion->getId()), $this->toArrayParamFuncion(), $this->toArrayValueFuncion($funcion)); 
            }
        }        
        public function deleteCine($idCine) //eliminar encadenado, elimina el cine,  elimina todos los cinemas y todas las funciones de cada cinema
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
        public function deleteCinema($idCinema) //elimina el cinema y todas las funciones del mismo
        {
            DBGen::deleteOne(CINEMATABLE, array('id'), $idCinema); //lo busca por id, y lo elimina
            $this->deleteFuncionesByIdCinema($idCinema);

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
        }

    }
?>