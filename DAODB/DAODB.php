<?php
//SUPERCLASE de las daodb

//DEBUG SUPER IMPORTANTE, LA NUEVA VERSION VA A ROMPER TODO CHE, VERIFICAR GET MANY WITH CHECK Y GET ONE WITH CHECK
namespace DAODB;
    use DAODB\DBGen as DBGen;
    use Models\iGuardable as iGuardable;
    use Utilities\calendar as Calendar;

abstract class DAODB
{
    abstract protected function getDatabase();
    Abstract protected function fromArray($arrayAux);
    Abstract protected function getArrayType(); //nueva funcion, array clave valor que especifica el tipo (varchar, char, int, long, etc), junto con el nombre (id integer)
    public function __construct()
    {
        $this->createTable();   //de esta manera, cada vez que quiero usar la DAO me fijo si la tabla existe
    }
    public function createTable()
    {
        DBGen::createTable($this->getDatabase(),$this->getArrayType());
    }
    public function addWithId(iGuardable $objeto) //busca la id, y despues llama a agregar
    {
        //$objeto->setId($this->giveId());  Desactivado para que la DB se encargue   
        $this->add($objeto);
    }
    public function add(iGuardable $objeto)
    {
        DBGen::addOneWithId($this->getDatabase(), $objeto->toArray());
    }
    public function giveId() //sobreescribe la subclase
    {
        return DBGen::getNewId($this->getDatabase());
    }
    public function getAll() //trae todos los de un tipo
    {

        $res = DBGen::getAll($this->getDatabase());
        $arrayRes = array();
        foreach ($res as $array)
        {
            array_push($arrayRes, $this->fromArray($array));
        }
        return $arrayRes;
    }
    public function getManyWithCheck($check, $value) //trae todos los de un tipo que cumplan una condicion
    {                                                 //CHECK Y VALUE SON ARRAYS
        $arrayRes = array();
        foreach(DBGen::getWithCheck($this->getDatabase(),$check, $value) as $objeto)
        {
            array_push($arrayRes, $this->fromArray($objeto));
        }
        return $arrayRes;
    }
    public function getOneWithCheck($check, $value) //trae Uno los de un tipo que cumplan una condicion
    {           
        $result=null;                                      //CHECK Y VALUE SON ARRAYS
        foreach(DBGen::getWithCheck($this->getDatabase(),$check, $value) as $objeto)
        {
            $result = $this->fromArray($objeto);
        }
        return $result;
    }
    public function getOneById($id) //TODOS TIENEN ID ASI QUE TA TODO BIEN
    {   
        return $this->getOneWithCheck(array('id'),array($id));
    }
    //public function getOne($check, $value); //trae 1 que cumpla la condicion, lo mismo de la de arriba
    public function modify(iGuardable $objeto) //sabe que existe, por lo que lo busca y sobreescribe
    {
        $found = $this->getOneById($objeto->getId());
        if ($found!=null)
            {
                DBGen::updateOne($this->getDatabase(), array('id'),array($objeto->getId()), $objeto->toArrayParam(), $objeto->toArrayValue()); 
            }
    }
    public function delete($id)  //busca por ID, para eliminar encadenado se basa en parametros DB foreign key
    //eliminar encadenado, elimina el cine,  elimina todos los cinemas y todas las funciones de cada cinema
    {

            DBGen::deleteOne($this->getDatabase(), array('id'), array($id)); //lo busca por id, y lo elimina
    }
    public function deleteWithCheck($check, $value) //CHECK Y VALUE SON ARRAYS!
    {
        DBGen::deleteOne($this->getDatabase(), $check, $value); //lo busca por check = value, y lo elimina
    }
}
?>