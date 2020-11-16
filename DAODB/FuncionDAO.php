<?php
namespace DAODB;
    use DAODB\DAODB as DAODB;
    use Models\Funcion as Funcion;
    use Utilities\calendar as Calendar;
    class CinemaDAO extends DAODB 
    {
        private static function getDatabase()
        {
            return FUNCIONTABLE;
        }
        public static function fromArray($arrayAux)
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
        private static function getArrayType()
        {
            $arrayAux=array();
            $arrayAux['id'] = "INT NOT NULL";
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
        public static function getAllFuncionesFromCinemaID($cinemaID)
        {
            $arrayFunciones = array();
            $arrayFunciones = self::getManyWithCheck(array("idcinema"), $cinemaID);
            return $arrayFunciones;
        }
        public static function getFuncionById($id)
        {
            return self::getOneById($id);
        }
    }

?>