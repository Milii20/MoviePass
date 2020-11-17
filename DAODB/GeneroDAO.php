<?php
namespace DAODB;
use DAODB\DAODB as DAODB;
use Models\Genero as Genero;
use Utilities\calendar as Calendar;
use Models\iGuardable as iGuardable;
class GeneroDAO extends DAODB 
{
    protected function getDatabase()
    {
        return GENEROTABLE;
    }
    protected function fromArray($arrayAux)
    {   
        $genero=null;
        if (!empty($arrayAux))
        {
            $genero = new Genero();
            $genero->setId($arrayAux["id"]);
            $genero->setNombre($arrayAux['nombre']);            
        }         
        return $genero;
    }
    public function desdeArray($arrayAux)
    {   
        $genero=null;
        if (!empty($arrayAux))
        {
            $genero = new Genero();
            $genero->setId($arrayAux["id"]);
            $genero->setNombre($arrayAux['nombre']);            
        }         
        return $genero;
    }
    public function add(iGuardable $objeto)
    {
        DBGen::addOneWithId($this->getDatabase(), $objeto->toArray());
    }
    protected function getArrayType()
    {
        $arrayAux=array();
        $arrayAux['id'] = "INT NOT NULL";
        $arrayAux['nombre'] = "VARCHAR (500)";
        $arrayAux['CONSTRAINT pk_cinema'] = "PRIMARY KEY (id)";    
        return $arrayAux;
    }
    public function update($array)
    {
        DBGen::addMany($this->getDatabase(),$array);
    }
}
?>