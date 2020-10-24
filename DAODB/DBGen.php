<?php
namespace DAODB;
   use DAODB\Connection as Connection;
    use DAODB\QueryType as QueryType;
    
    Class DBGen //clase HIPERSUPERMEGA GENERICA PARA DB USANDO CONNECTION
{
    private $connection;
        
    public static function getNewId($tableName) //obtiene la proxima id disponible, ya que cada cosa que se guarda TIENE una id
    {
        $query = "SELECT * FROM ".$tableName." ORDER BY 'id' DESC ";
        $connection = Connection::GetInstance();
        $result = $connection->Execute($query, array(), QueryType::Query); 
        $res=0;
        if (!empty($result))
        {
            
            $row=$result[count($result)-1];
            $res=$row['id']+1; //ya que esta en orden descendiente
        }
           
        return $res; 
    }
    public static function addOne($tableName, $arrayValores)
    {
        $query = "INSERT INTO ".$tableName;
        $queryAux = " VALUES (";
        foreach($arrayValores as $clave => $valor)
        {
            
            $queryAux = $queryAux."'".$valor."',";
            
        }
        $queryAux=substr($queryAux,0,(strlen($queryAux)-1)).")";
        $query=$query.$queryAux;
        
        $connection = Connection::GetInstance();

        $connection->ExecuteNonQuery($query, array(), QueryType::Query);
    }
   
    public static function addMany($tableName, $arrayCosas) //no creo que lo use, pero bueno, aca esta
    {
        $query = "INSERT INTO ".$tableName;
        $connection = Connection::GetInstance(); //para no generar 50 conecciones, pase el getInstance arriba del foreach
        
        foreach($arrayCosas as $arrayValores)
        {
            foreach($arrayValores as $clave => $valor)
            {
                $parameters[$clave]=$valor;
            }
            $connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
        }
    }
    
    public static function getOne($tableName, $Param, $Value) //PARAM Y VALUE SON ARRAYS!!!!!!!!!!
    {
        $queryAux=" WHERE ".$Param[0]." = '".$Value[0]."' "; //agrego el primero, ya que es getOne, por parametros
        for ($i=1;$i<sizeof($Param);$i++) //ya que hay tantos $Param como $Values puedo hacer esto para los demas, si no hay mas de 1 parametro, entonces ni entra al for
        {
            $queryAux=$queryAux." AND ".$Param[$i]." = '".$Value[$i]."' ";
        }
        $query = "SELECT * FROM ".$tableName.$queryAux;
        $connection = Connection::GetInstance();
        $result = $connection->Execute($query, array(), QueryType::Query);
        return $result; //directamente devuelvo un array con los results, ya que es un array de strings, que lo interprete quien sea que invoque esta funcion
                        //y tambien ya que solo creo que use getOne para algo muy concreto del que se que no hay repetidos, o si los hay, los quiero a todos
    }
    public static function getAll($tableName) //agarra todos los valores y los devuelve, no creo que lo use para usuarios pero si para funciones por ejemplo
    {
        $query = "SELECT * FROM ".$tableName;
        $connection = Connection::GetInstance();
        $result = $connection->Execute($query, array(), QueryType::Query);
        
        return $result; 
    }
    public static function updateOne($tableName, $Param, $Value, $newParam, $newValue) //PARAM Y VALUE SON ARRAYS! (probablemente solo use esto con un solo parametro para el WHERE, pero igual)
    {
        $queryAux=" WHERE ".$Param[0]." = '".$Value[0]."' "; //agrego el primero, ya que es getOne, por parametros
        for ($i=1;$i<sizeof($Param);$i++) //ya que hay tantos $Param como $Values puedo hacer esto para los demas, si no hay mas de 1 parametro, entonces ni entra al for
        {
            $queryAux=$queryAux." AND ".$Param[$i]." = '".$Value[$i]."' "; //asi queda WHERE nombre =$nombre AND email=$email por ejemplo
        }
        $queryAuxSet=" SET ".$newParam[0]." = '".$newValue[0]."' "; //agrego el primero
        for ($i=1;$i<sizeof($newParam);$i++) //ya que hay tantos $newParam como $newValue puedo hacer esto para los demas, si no hay mas de 1 parametro, entonces ni entra al for
        {
            $queryAuxSet=$queryAuxSet.", ".$newParam[$i]." = '".$newValue[$i]."' ";
        }
        $query = "UPDATE ".$tableName.$queryAuxSet.$queryAux; //de forma UPDATE nombretabla SET param=value WHERE param=value
        $connection = Connection::GetInstance();
        $result = $connection->ExecuteNonQuery($query, array(), QueryType::Query);
        return $result; //devuelve la cant de filas afectadas
    }
    public static function updateAll($tableName, $newParam, $newValue) //lo mismo que updateOne pero sin Where
    {
        $queryAuxSet=" SET ".$newParam[0]." = '".$newValue[0]."' "; //agrego el primero
        for ($i=1;$i<sizeof($newParam);$i++) //ya que hay tantos $newParam como $newValue puedo hacer esto para los demas, si no hay mas de 1 parametro, entonces ni entra al for
        {
            $queryAuxSet=$queryAuxSet.", ".$newParam[$i]." = '".$newValue[$i]."' ";
        }
        $query = "UPDATE ".$tableName.$queryAuxSet; //de forma UPDATE nombretabla SET param=value WHERE param=value
        $connection = Connection::GetInstance();
        $result = $connection->ExecuteNonQuery($query, array(), QueryType::Query);
        return $result; //devuelve la cant de filas afectadas
                        
    }
    public static function deleteOne($tableName, $Param, $Value)
    {
        $queryAux=" WHERE ".$Param[0]." = '".$Value[0]."' "; //agrego el primero, ya que es getOne, por parametros
        for ($i=1;$i<sizeof($Param);$i++) //ya que hay tantos $Param como $Values puedo hacer esto para los demas, si no hay mas de 1 parametro, entonces ni entra al for
        {
            $queryAux=$queryAux." AND ".$Param[$i]." = '".$Value[$i]."' ";
        }
        $query = "DELETE FROM ".$tableName.$queryAux; //queda DELETE FROM $nombreTabla WHERE $param = $value
        $connection = Connection::GetInstance();
        $result = $connection->ExecuteNonQuery($query, array(), QueryType::Query);
        return $result; //devuelve la cant de filas afectadas
    }
    public static function deleteAll($tableName) //Borra todo, simplemente NO USAR a no ser que haya que limpiar la DB por alguna razon, no destruye la tabla (no hace drop table)
    {
        $query = "DELETE FROM ".$tableName; //Borra todo
        $connection = Connection::GetInstance();
        $result = $connection->ExecuteNonQuery($query, array(), QueryType::Query);
        return $result; //devuelve la cant de filas afectadas
    }
    
}
?>