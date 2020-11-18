<?php
namespace DAODB;
    use DAODB\DAODB as DAODB;
    use DAODB\PeliculaDAO as PeliculaDAO;
    use Models\Funcion as Funcion;
    use Models\Pelicula as Pelicula;
    use Utilities\calendar as Calendar;
    class FuncionDAO extends DAODB 
    {
        protected function getDatabase()
        {
            return FUNCIONTABLE;
        }
        protected function fromArray($arrayAux)
        {
            $funcion = null;
            if (!empty($arrayAux))
            {
                $funcion = new Funcion();
                $funcion->setId($arrayAux['id']);
                $pelidao = new PeliculaDAO();
                $peli = $pelidao->getOneById($arrayAux['idpelicula']);
                $funcion->setPelicula($peli);
                $funcion->setIdCinema($arrayAux['idcinema']);
                $funcion->setFecha($arrayAux['fecha']);
                $funcion->setHora($arrayAux['hora']);
                $funcion->setArrayAsientosFromJson($arrayAux['asientos']);   
            }
            return $funcion;
        }
        protected function getArrayType()
        {
            $arrayAux=array();
            $arrayAux['id'] = "INT NOT NULL AUTO_INCREMENT";
            $arrayAux['idpelicula'] = "INT NOT NULL";
            $arrayAux['idcinema'] = "INT NOT NULL";
            $arrayAux['fecha'] = "VARCHAR (50)";
            $arrayAux['hora'] = "VARCHAR (50)";       
            $arrayAux['asientos'] = "VARCHAR (50000)";   //varchar gigante para que entre el array en modo json ahi, ya que se requieren 5 caracteres por asiento, esto deberia tener 10000 asientos mas o menos
            $arrayAux['CONSTRAINT pk_funcion'] = "PRIMARY KEY (id,idcinema,idpelicula)";                                                                      //primary keys
            $arrayAux['CONSTRAINT fk_funcion_cinema'] = "FOREIGN KEY (idcinema) REFERENCES ".CINEMATABLE." (id) ON DELETE CASCADE ON UPDATE CASCADE";  //foreign key con cinemas
            //$arrayAux['CONSTRAINT fk_funcion_pelicula'] = "FOREIGN KEY (idpelicula) REFERENCES ".PELICULATABLE." (id) ON DELETE NO ACTION ON UPDATE NO ACTION";  
            //foreign key con peliculas, ya que no la voy a borrar nunca a la peli, y si borro la funcion la peli deberia seguir estando, no es necesaria
            return $arrayAux;
        }
        public function getAllFuncionesByCinemaID($cinemaID)
        {
            $arrayFunciones = array();
            $arrayFunciones = $this->getManyWithCheck(array("idcinema"), array($cinemaID));
            return $arrayFunciones;
        }
        public function getFuncionById($id)
        {
            return $this->getOneById($id);
        }
        public function getFuncionesByIdClienteAsiento($idCliente)
        {
            $res = array();
            $funciones = array();
            $funciones= $this->getAll();
            {
                foreach ($funciones as $funcion)
                {
                    $agregar = false;
                    foreach ($funcion->getArrayAsientos() as $Asiento => $idCli)
                    {
                        if ($idCli==$idCliente)
                        {
                            $agregar = true;
                        }
                    }
                    if ($agregar == true)
                    {
                        array_push($res,$funcion);
                    }
                    
                }
            }
            return $res;
        }
        public function deleteFuncionesByIdCinema($idCinema)
        {
            $arrayFunciones = array();
            $arrayFunciones = $this->getManyWithCheck(array("idcinema"), array($idCinema));
            foreach ($arrayFunciones as $funciones)
            {
                $this->delete($funciones->getId());
            }
        }
        public function getFuncionesDisponibles() //puede traer muchos
        {
            $arrayFunciones=array();
            foreach($this->getAll() as $func)
            {
                    if (calendar::ComparaFechas($func->getFecha(),date('d.m.Y')))
                    {
                        array_push($arrayFunciones,$func);
                    }
            }
            return $arrayFunciones;
        
        } 
    }

?>