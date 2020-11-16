<?php
// identifica a una clase como guardable, es decir, que tiene un DAO asociado
interface iGuardable   
{
    public function getId();
    public function setId($id);
    public function toArray();
    public function toArrayValue();
    public function toArrayParam();
    
}



?>