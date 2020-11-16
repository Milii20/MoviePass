<?php
namespace DAODB;
    use DAODB\DAODB as DAODB;
    use Models\Cinema as Cinema;
    use DAODB\FuncionDAO as FuncionDAO; //requerido para poder cargar las funciones de cada sala de cine
    use Utilities\calendar as Calendar;
    class CinemaDAO extends DAODB 
    {
        private static function getDatabase()
        {
            return CINEMATABLE;
        }
        public static function fromArray($arrayAux)
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
        private static function getArrayType()
        {
            $arrayAux=array();
            $arrayAux['id'] = "INT NOT NULL";
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
        public static function getAllCinemasFromCineID($cineID)
        {
            $arrayCinemas = array();
            $arrayCinemas = self::getManyWithCheck(array("idcine"), $cineID);
            foreach ($arrayCinemas as $cinema)
            {
                $cinema->setArrayFunciones(FuncionDAO::getAllFuncionesFromCinemaID($cinema->getId()));
            }
            return $arrayCinemas;
        }
        public static function getCinemaById($id)
        {
            return self::getOneById($id);
        }

    }

?>