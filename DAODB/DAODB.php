<?php
//SUPERCLASE de las daodb

//DEBUG SUPER IMPORTANTE, LA NUEVA VERSION VA A ROMPER TODO CHE, VERIFICAR GET MANY WITH CHECK Y GET ONE WITH CHECK
namespace DAODB;
    use DAODB\DBGen as DBGen;
    use Models\iGuardable as iGuardable;
    use Utilities\calendar as Calendar;

abstract class DAODB
{
    private abstract static function getDatabase();
    private Abstract static function fromArray($arrayAux);
    private Abstract static function getArrayType(); //nueva funcion, array clave valor que especifica el tipo (varchar, char, int, long, etc), junto con el nombre (id integer)
    public static function createTable()
    {
        DBGen::createTable(self::getDatabase(),self::getArrayType());
    }
    public static function addWithId(iGuardable $objeto) //busca la id, y despues llama a agregar
    {
        $objeto->setId(self::giveId());   
        self::add($objeto);
    }
    public static function add(iGuardable $objeto)
    {
        DBGen::addOne(self::getDatabase(), $objeto->toArray());
    }
    public static function giveId() //sobreescribe la subclase
    {
        return DBGen::getNewId(self::getDatabase());
    }
    public static function getAll() //trae todos los de un tipo
    {
        $res = DBGen::getAll(self::getDatabase());
        $arrayRes = array();
        foreach ($res as $array)
        {
            array_push($arrayRes, self::fromArray($array));
        }
        return $arrayObj;
    }
    public static function getManyWithCheck($check, $value) //trae todos los de un tipo que cumplan una condicion
    {                                                 //CHECK Y VALUE SON ARRAYS
        $arrayRes = array();
        foreach(DBGen::getWithCheck(self::getDatabase(),$check, $value) as $objeto)
        {
            array_push($arrayRes, self::fromArray($objeto));
        }
        return $arrayRes;
    }
    public static function getOneWithCheck($check, $value) //trae Uno los de un tipo que cumplan una condicion
    {                                                 //CHECK Y VALUE SON ARRAYS
        foreach(DBGen::getWithCheck(self::getDatabase(),$check, $value) as $objeto)
        {
            $result = self::fromArray($objeto);
        }
        return $result;
    }
    public static function getOneById($id) //TODOS TIENEN ID ASI QUE TA TODO BIEN
    {   
        return self::getOneWithCheck(array('id'),array($id));
    }
    //public function getOne($check, $value); //trae 1 que cumpla la condicion, lo mismo de la de arriba
    public static function modify(iGuardable $objeto) //sabe que existe, por lo que lo busca y sobreescribe
    {
        $found = self::getOneById($objeto->getId());
        if ($found!=null)
            {
                DBGen::updateOne(self::getDatabase(), array('id'),array($objeto->getId()), $objeto->toArrayParam(), $objeto->toArrayValue()); 
            }
    }
    public static function delete($id)  //busca por ID, para eliminar encadenado se basa en parametros DB foreign key
    //eliminar encadenado, elimina el cine,  elimina todos los cinemas y todas las funciones de cada cinema
    {
            
            DBGen::deleteOne(self::getDatabase(), array('id'), $id); //lo busca por id, y lo elimina
    }
    public static function deleteWithCheck($check, $value) //CHECK Y VALUE SON ARRAYS!
    {
        DBGen::deleteOne(self::getDatabase(), $check, $value); //lo busca por check = value, y lo elimina
    }
}
?>