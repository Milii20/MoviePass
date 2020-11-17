<?php
namespace DAODB;
    use DAODB\DAODB as DAODB;
    use DAODB\DBGen as DBGen;
    use Models\Cinema as Cinema;
    use DAODB\FuncionDAO as FuncionDAO; //requerido para poder cargar las funciones de cada sala de cine
    use Utilities\calendar as Calendar;
    class CinemaDAO extends DAODB 
    {
        protected function getDatabase()
        {
            return CINEMATABLE;
        }
        protected function fromArray($arrayAux)
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
        protected function getArrayType()
        {
            $arrayAux=array();
            $arrayAux['id'] = "INT NOT NULL AUTO_INCREMENT";
            $arrayAux['idcine'] = "INT NOT NULL";
            $arrayAux['capacidadtotal'] = "INT";
            $arrayAux['nombre'] = "VARCHAR (500)";
            $arrayAux['direccion'] = "VARCHAR (500)";       //lo hago varchar por si es alguna cosa especial, si bien seguramente va a ser numeros
            $arrayAux['valordeentrada'] = "VARCHAR (50)";   //lo hago varchar por si es alguna cosa especial, si bien seguramente va a ser numeros
            $arrayAux['tiposala'] = "VARCHAR (50)";         //lo hago varchar por si es alguna cosa especial, si bien seguramente va a ser numeros
            $arrayAux['cantgenteporfila'] = "VARCHAR (50)"; //lo hago varchar por si es alguna cosa especial, si bien seguramente va a ser numeros
            $arrayAux['distribucionizq'] = "VARCHAR (50)";  //lo hago varchar por si es alguna cosa especial, si bien seguramente va a ser numeros
            $arrayAux['distribucionder'] = "VARCHAR (50)";  //lo hago varchar por si es alguna cosa especial, si bien seguramente va a ser numeros
            $arrayAux['CONSTRAINT pk_cinema'] = "PRIMARY KEY (id,idcine)";                                                                      //primary key
            $arrayAux['CONSTRAINT fk_cinema_cine'] = "FOREIGN KEY (idcine) REFERENCES ".CINETABLE." (id) ON DELETE CASCADE ON UPDATE CASCADE";  //foreign key con cines
            return $arrayAux;
        }
        public function getAllCinemasFromCineID($cineID)
        {
            $arrayCinemas = array();
            $arrayCinemas = $this->getManyWithCheck(array("idcine"), array($cineID));
            $funciondao = new FuncionDAO();
            foreach ($arrayCinemas as $cinema)
            {
                $cinema->setArrayFunciones($funciondao->getAllFuncionesByCinemaID($cinema->getId()));
            }
            return $arrayCinemas;
        }
        public function delete($idCinema) //elimina el cinema y todas las funciones del mismo
        {
            $funciondao = new FuncionDAO();
            DBGen::deleteOne($this->getDatabase(), array('id'), array($idCinema)); //lo busca por id, y lo elimina
            $funciondao->deleteFuncionesByIdCinema($idCinema);
        }  
        public function deleteCinemasByIdCine($idCine)
        {
            $arrayCinemas = array();
            $arrayCinemas = $this->getManyWithCheck(array("idcine"), array($idCine));
            foreach ($arrayCinemas as $cinema)
            {
                $this->delete($cinema->getId());
            }
        }
        public function getCinemaById($id)
        {
            return $this->getOneById($id);
        }

    }

?>