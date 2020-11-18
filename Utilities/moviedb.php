<?php
//funciones para conectar con themobieDB
namespace Utilities;
Class moviedb
{
    private $requestToken="";
    private $guestSessionID="";
    
        
    //<a href="https://www.themoviedb.org/authenticate/{REQUEST_TOKEN}?redirect_to=http://localhost/cine">link</a>7c104751670f1f5a652bc3c58692a87b4834ab36
    public function getToken()
    {
        return $this->requestToken;
    }
    public function setToken($token)
    {
        $this->requestToken=$token;
    }
    public function getSessionId()
    {
        return $this->guestSessionID;
    }
    public function setSessionId($sesid)
    {
        $this->guestSessionID=$sesid;
    }
    public function buscarConMayorRating($pag)
    {
        $response = json_decode(file_get_contents('https://api.themoviedb.org/3/discover/movie?api_key='.KEY.'&language=es-ES&sort_by=popularity.desc&include_adult=false&include_video=false&page='.$pag),true);
        $res=array();
        foreach ($response["results"] as $peli)
        {
            array_push($res, $this->filterAttrib($peli));
        }
        return $res;
        /*
        foreach ($res["results"] as $peli)
        {
            $imgJson= json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$peli["id"].'/images?api_key='.KEY),true);
            //echo $imgJson['posters'][0]["file_path"];
            echo 'Imagen: <img src="https://image.tmdb.org/t/p/w500'.$imgJson["posters"][0]["file_path"].'" height="400" width="300">';
                   
            foreach ($intrestingKeys as $key)
            {
                echo $peli[$key].'<br>';
                //echo $key.'<br>';
            }

            
           //echo $peli["overview"].'<br>';
        }*/
    }
    public function buscarActuales($pag)
    {
        $response = json_decode(file_get_contents('https://api.themoviedb.org/3/discover/movie?api_key='.KEY.'&language=es-ES&sort_by=release_date.desc&include_adult=false&include_video=false&page='.$pag),true);
        //echo file_get_contents('https://api.themoviedb.org/3/discover/movie?api_key='.KEY.'&language=es-ES&sort_by=release_date.desc&include_adult=false&include_video=false&page=1');
        $res=array();
        foreach ($response["results"] as $peli)
        {
            array_push($res, $this->filterAttrib($peli));
        }
        return $res;
        /*

        foreach ($res["results"] as $peli)
        {
            $imgJson= json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$peli["id"].'/images?api_key='.KEY),true);
            //echo $imgJson['posters'][0]["file_path"];
            echo 'Imagen: <img src="https://image.tmdb.org/t/p/w500'.$imgJson["posters"][0]["file_path"].'" height="400" width="300">';
                   
            foreach ($intrestingKeys as $key)
            {
                echo $peli[$key].'<br>';
                //echo $key.'<br>';
            }

            
           //echo $peli["overview"].'<br>';
        }*/
    }
    public function buscarViejas($pag)
    {
        $response = json_decode(file_get_contents('https://api.themoviedb.org/3/discover/movie?api_key='.KEY.'&language=es-ES&sort_by=release_date.asc&include_adult=false&include_video=false&page='.$pag),true);
        //echo file_get_contents('https://api.themoviedb.org/3/discover/movie?api_key='.KEY.'&language=es-ES&sort_by=release_date.desc&include_adult=false&include_video=false&page=1');
        $res=array();
        //DEBUG
        //$this->getAllGenres();
        //DEBUG
        foreach ($response["results"] as $peli)
        {
            array_push($res, $this->filterAttrib($peli));
        }
        return $res;
        /*

        foreach ($res["results"] as $peli)
        {
            $imgJson= json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$peli["id"].'/images?api_key='.KEY),true);
            //echo $imgJson['posters'][0]["file_path"];
            echo 'Imagen: <img src="https://image.tmdb.org/t/p/w500'.$imgJson["posters"][0]["file_path"].'" height="400" width="300">';
                   
            foreach ($intrestingKeys as $key)
            {
                echo $peli[$key].'<br>';
                //echo $key.'<br>';
            }

            
           //echo $peli["overview"].'<br>';
        }*/
    }
    public function getAllGenres()  // DEBUG
    {
        $res2=file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key='.KEY.'&language=es-ES'); 
        //echo $res2;
        $res3=json_decode($res2,true);
        $arrayAux = array();
        $arrayAux2=array();
        foreach ($res3['genres'] as $val)
        foreach ($val as $clave => $valor)
        {
            //echo "Clave: ".$clave; echo " valor ".$valor."<br>";
            if (strcasecmp($clave,"id")==0)
                {
                    $arrayAux2["id"] =$valor;
                    
                }
                else
                {
                    $arrayAux2["nombre"]=$valor;
                    array_push($arrayAux,$arrayAux2);
                }
        }
        return $arrayAux;
    }
    
    public function getPortrait($peli)
    {
        $res="";
        $imgJson= json_decode(@file_get_contents('https://api.themoviedb.org/3/movie/'.$peli["id"].'/images?api_key='.KEY),true);
        
        
            if ($imgJson['posters']!=null)
            $res= $imgJson['posters'][0]["file_path"];
        return $res;
            //'Imagen: <img src="https://image.tmdb.org/t/p/w500'.$imgJson["posters"][0]["file_path"].'" height="400" width="300">';
    }
    public function getNewToken()
    {
        $response = json_decode(file_get_contents('https://api.themoviedb.org/3/authentication/token/new?api_key='.KEY),true);
        if ($response["success"]==true)
        {
            $this->setToken($response["request_token"]);
        }
    }
    public function getNewSessionId()
    {
        $response = json_decode(file_get_contents('https://api.themoviedb.org/3/authentication/guest_session/new?api_key='.KEY),true);
        if ($response["success"]==true)
        {
            $this->setSessionId($response["guest_session_id"]);
        }
    }
    public function getById($id)
    {
        $peli = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$id.'?api_key='.KEY.'&language=es-ES'),true);
        
        $newPeli= $this->filterAttrib($peli);
        $newPeli["genre_ids"] = array();
               
        foreach ($peli["genres"] as $arr)  
        foreach ($arr as $clave => $valor)          //trato los generos diferente....
            {
                //echo "<br>la clave es: ".$valor;
                if (strcmp($clave,"id")==0)
                {

                    array_push($newPeli["genre_ids"],$valor);
                }
                
            } 
        
        return $newPeli;    
    }
    public function filterAttrib($peli)
    {
        $intrestingKeys=array("id","popularity","title","overview","release_date");  //,"genre_ids","genres",,"genres"
        $newPeli=array();
        $genre="";
        foreach ($intrestingKeys as $key)
        /*{
            if ($key=="genre_ids")
            {
                foreach ($key as $valor)
                {
                    $genre=$genre.",".$valor; //01,02,05,etc
                }
                $newPeli[$key]= $genre;
            }
            else }*/{
                
                $newPeli[$key]= $peli[$key];
            }
            /*foreach ($peli as $clave => $valor)
            {
                ;echo "<br> clave de la peli: ".$clave;echo "<br> valor de la peli: ".$valor;

            }*/
            
        $portra=$this->getPortrait($newPeli);
        
        $newPeli["image"]=$portra;
        

        return $newPeli;
    }
    
    
}
?>