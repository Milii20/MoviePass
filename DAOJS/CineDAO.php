<?php
//contiene alta, baja, modificacion y consulta de Cines, que contienen cinemas, que contienen funciones
//pero en JSON
    namespace DAOJS;
    use Models\Cine as Cine;
    use Models\Cinema as Cinema;
    use Models\Funcion as Funcion;

    class CineDAO 
    {
    private $cineList = array();
    private $cinemaList = array();
    private $funcionList = array();
    private function SaveDataCine() 
    {
        $arrayToEncode = array();

        foreach($this->cineList as $cine)
        {
            $arrayToEncode['id'] = $cine->getId();
            $arrayToEncode['nombre'] = $cine->getNombre();
            $arrayToEncode['descripcion'] = $cine->getDescripcion();
            $arrayToEncode['promos'] = $cine->getArrayPromosJson();
            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents(ROOT.'Data/cines.json', $jsonContent);
    }
    private function RetrieveDataCine()
    {
        $this->cineList = array();

        if(file_exists(ROOT.'Data/cines.json'))
        {
            $jsonContent = file_get_contents(ROOT.'Data/cines.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $cine=new Cine();
                $cine->setId($arrayAux['id']);
                $cine->setNombre($arrayAux['nombre']);
                $cine->setDescripcion($arrayAux['descripcion']);
                $cine->setArrayPromosJson($arrayAux['promos']);
                array_push($this->cineList,$cine);
               

            }
        }
    }
    private function SaveDataCinema() 
    {
        $arrayToEncode = array();

        foreach($this->cinemaList as $cinema)
        {
            $arrayToEncode['id'] = $cinema->getIdCinema();
            $arrayToEncode['idcine'] = $cinema->getIdCine();
            $arrayToEncode['capacidadtotal'] = $cinema->getCapacidadTotal();
            $arrayToEncode['nombre'] = $cinema->getNombre();
            $arrayToEncode['direccion'] = $cinema->getDireccion();
            $arrayToEncode['valordeentrada'] = $cinema->getValorDeEntrada();
            $arrayToEncode['tiposala'] = $cinema->getTipoSala();
            $arrayToEncode['cantgenteporfila'] = $cinema->getCantGentePorFila();
            $arrayToEncode['distribucionizq'] = $cinema->getDistribucionIzq();
            $arrayToEncode['distribucionder'] = $cinema->getDistribucionDer();
            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents(ROOT.'Data/cinemas.json', $jsonContent);
    }
    private function RetrieveDataCinema()
    {
        $this->cinemaList = array();

        if(file_exists(ROOT.'Data/cinemas.json'))
        {
            $jsonContent = file_get_contents(ROOT.'Data/cinemas.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $cinema = new Cinema();
                $cinema->setIdCinema($arrayAux['id']);
                $cinema->setIdCine($arrayAux['idcine']);
                $cinema->setCapacidadTotal($arrayAux['capacidadtotal']);
                $cinema->setNombre($arrayAux['nombre']);
                $cinema->setDireccion($arrayAux['direccion']);
                $cinema->setValorDeEntrada($arrayAux['valordeentrada']);
                $cinema->setTipoSala($arrayAux['tiposala']);
                $cinema->setCantGentePorFila($arrayAux['cantgenteporfila']);
                $cinema->setDistribucionIzq($arrayAux['distribucionizq']);
                $cinema->setDistribucionDer($arrayAux['distribucionder']);
                array_push($this->cinemaList,$cinema);
            }
        }
    }
    private function SaveDataFuncion() 
    {
        $arrayToEncode = array();

        foreach($this->funcionList as $funcion)
        {
            $arrayToEncode['id'] = $funcion->getIdFuncion();
            $arrayToEncode['idpelicula'] = $funcion->getIdPelicula();
            $arrayToEncode['idcinema'] = $funcion->getIdCinema();
            $arrayToEncode['fecha'] = $funcion->getFecha();
            $arrayToEncode['hora'] = $funcion->getHora();
            $arrayToEncode['asientos'] = $funcion->getArrayAsientos();
            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents(ROOT.'Data/funciones.json', $jsonContent);
    }
    private function RetrieveDataFuncion()
    {
        $this->cineList = array();

        if(file_exists(ROOT.'Data/funciones.json'))
        {
            $jsonContent = file_get_contents(ROOT.'Data/funciones.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $funcion = new Funcion();
                $funcion->setIdFuncion($arrayAux['id']);
                $funcion->setIdPelicula($arrayAux['idpelicula']);
                $funcion->setIdCinema($arrayAux['idcinema']);
                $funcion->setFecha($arrayAux['fecha']);
                $funcion->setHora($arrayAux['hora']);
                $funcion->setArrayAsientos($arrayAux['asientos']);
                array_push($this->funcionList,$funcion);
               

            }
        }
    }
    public function GiveIdCine()
    {
        $this->RetrieveData();
        $res=0;
        if(!empty($this->cineList)){
            $res=$this->cineList[count($this->cineList)-1]->getId()+1;//es un lio, pero esto llama a getId del ultimo valor en la lista de usuarios y le agrega 1
        };
        return $res;
    }
    public function GiveIdCinema()
    {
        $this->RetrieveData();
        $res=0;
        if(!empty($this->cinemaList)){
            $res=$this->cinemaList[count($this->cinemaList)-1]->getId()+1;//es un lio, pero esto llama a getId del ultimo valor en la lista de usuarios y le agrega 1
        };
        return $res;
    }
    public function GiveIdFuncion()
    {
        $this->RetrieveData();
        $res=0;
        if(!empty($this->funcionList)){
            $res=$this->funcionList[count($this->funcionList)-1]->getId()+1;//es un lio, pero esto llama a getId del ultimo valor en la lista de usuarios y le agrega 1
        };
        return $res;
    }
    public function addCine($cine)
    {
        $this->RetrieveDataCine();
        
        array_push($this->cineList, $cine);

        $this->SaveDataCine();
    }   
    public function addCinema($cinema)
    {
        $this->RetrieveDataCinema();
        
        array_push($this->cinemaList, $cinema);

        $this->SaveDataCinema();
    }     
    public function addFuncion($funcion)
    {
        $this->RetrieveDataFuncion();
        
        array_push($this->funcionList, $funcion);

        $this->SaveDataFuncion();
    }  
    public function getAllCine()
    {
        return $this->cineList;
    }   
    public function getCineById($id)
    {
        $this->RetrieveDataCine();
        $found = null;
        
        if(!empty($this->cineList)){
            foreach($this->cineList as $cine){
                
                if($cine->getId() == $id){
                    $found = $cine;
                }
            }
        }
        return $found;
    } 
    public function getCinemaById($id)
    {
        $this->RetrieveDataCinema();
        $found = null;
        
        if(!empty($this->cinemaList)){
            foreach($this->cinemaList as $cinema){
                
                if($cinema->getId() == $id){
                    $found = $cinema;
                }
            }
        }
        return $found;
    }      
    public function getCinemaByIdCine($id)
    {
        $this->RetrieveDataCinema();
        $found = null;
        
        if(!empty($this->cinemaList)){
            foreach($this->cinemaList as $cinema){
                
                if($cinema->getIdCine() == $id){
                    $found = $cinema;
                }
            }
        }
        return $found;
    }   
    public function getFuncionById($id)
    {
        $this->RetrieveDataFuncion();
        $found = null;
        
        if(!empty($this->funcionList)){
            foreach($this->funcionList as $funcion){
                
                if($funcion->getId() == $id){
                    $found = $funcion;
                }
            }
        }
        return $found;
    } 
    public function getFuncionByIdCinema($id)
    {
        $this->RetrieveDataFuncion();
        $found = null;
        
        if(!empty($this->funcionList)){
            foreach($this->funcionList as $funcion){
                
                if($funcion->getIdCinema() == $id){
                    $found = $funcion;
                }
            }
        }
        return $found;
    }           
    public function modifyCine($cine)
    { 
        
        $this->RetrieveDataCine();
        if(!empty($this->cineList)){
            foreach($this->cineList as $aux){
                
                if($aux->getId() == $cine->getId()){
                    $mod=array_Search($aux,$this->cineList);
                    $this->cineList[$mod]= $cine;
                }
            }
        }
        $this->SaveDataCine();
    }   
    public function modifyCinema($cinema)
    { 
        
        $this->RetrieveDataCinema();
        if(!empty($this->cinemaList)){
            foreach($this->cinemaList as $aux){
                
                if($aux->getId() == $cinema->getId()){
                    $mod=array_Search($aux,$this->cinemaList);
                    $this->cinemaList[$mod]= $cinema;
                }
            }
        }
        $this->SaveDataCinema();
    }   
    public function modifyFuncion($funcion)
    { 
        
        $this->RetrieveDataFuncion();
        if(!empty($this->funcionList)){
            foreach($this->funcionList as $aux){
                
                if($aux->getId() == $funcion->getId()){
                    $mod=array_Search($aux,$this->funcionList);
                    $this->funcionList[$mod]= $funcion;
                }
            }
        }
        $this->SaveDataFuncion();
    }      
    public function deleteCine($cine)
    { 
        
        $this->RetrieveDataCine();
        if(!empty($this->cineList)){
            foreach($this->cineList as $aux){
                
                if($aux->getId() == $cine->getId()){
                    $del=array_Search($aux,$this->cineList);
                    unset($this->cineList[$del]);
                    $aux2=array_values($this->cineList);   /// usado para arreglar los index del array
                    $this->cineList=$aux2;
                }
            }
        }
        $this->SaveDataCine();
    }    
    public function deleteCinema($cinema)
    { 
        
        $this->RetrieveDataCinema();
        if(!empty($this->cinemaList)){
            foreach($this->cinemaList as $aux){
                
                if($aux->getId() == $cinema->getId()){
                    $del=array_Search($aux,$this->cinemaList);
                    unset($this->cinemaList[$del]);
                    $aux2=array_values($this->cinemaList);   /// usado para arreglar los index del array
                    $this->cinemaList=$aux2;
                }
            }
        }
        $this->SaveDataCinema();
    }    
    public function deleteFuncion($funcion)
    { 
        
        $this->RetrieveDataFuncion();
        if(!empty($this->funcionList)){
            foreach($this->funcionList as $aux){
                
                if($aux->getId() == $funcion->getId()){
                    $del=array_Search($aux,$this->funcionList);
                    unset($this->funcionList[$del]);
                    $aux2=array_values($this->funcionList);   /// usado para arreglar los index del array
                    $this->funcionList=$aux2;
                }
            }
        }
        $this->SaveDataFuncion();
    }  
} 
?>