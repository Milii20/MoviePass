<?php
namespace DAODB;
use DAODB\DAODB as DAODB;
use DAODB\GeneroDAO as GeneroDAO;
use Models\Genero as Genero;
use Models\Pelicula as Pelicula;
use Models\iGuardable as iGuardable;
use Utilities\calendar as Calendar;
class PeliculaDAO extends DAODB 
{
    protected function getDatabase()
    {
        return PELICULATABLE;
    }
    protected function fromArray($arrayAux)
    {   
        $peli=null;
        if (!empty($arrayAux))
        {
            $peli = new Pelicula();
            $peli->setId($arrayAux["id"]);
            $peli->setPopularity($arrayAux['popularity']); 
            $peli->setTitle($arrayAux['title']);
            $peli->setOverview($arrayAux['overview']);
            $peli->setReleaseDate($arrayAux['releasedate']);
            $peli->setImage($arrayAux['image']);
            /*$peli->setGenreIds($arrayAux['genreids']);
            $generoDAO=new GeneroDAO();
            $arrayGeneros= $generoDAO->getAll();
            $generos=array();
            $generos=explode($peli->getGenreIds(),",");
            $arrayGen= array();
            foreach ($generos as $generoIncluido)   //este es un array id1,id2,id3,etc
            {
                foreach ($arrayGeneros as $genero)  //este es un array id 1 valor accion, id2 valor etc..
                {
                    if ($generoIncluido==$genero->getId())
                    {
                        array_push($arrayGen,$genero);
                    }
                }
            }
            $peli->setArrayGeneros($arrayGen);   */        
        }         
        return $peli;
    }
    public function desdeArray($arrayAux)   //usado para moviedb
    {   
        $peli=null;
        if (!empty($arrayAux))
        {
            $peli = new Pelicula();
            $peli->setId($arrayAux["id"]);
            $peli->setPopularity($arrayAux['popularity']); 
            $peli->setTitle($arrayAux['title']);
            $peli->setOverview($arrayAux['overview']);
            $peli->setReleaseDate($arrayAux['release_date']);
            $peli->setImage($arrayAux['image']);
            /*$auxgen=$arrayAux['genres'];
            $res = "";
            foreach ($auxgen as $gene)
            {
                foreach ($gene as $clave => $valor)
                {
                    if(strcasecmp($clave,"id"))
                    {
                        if(strcasecmp($res,""))
                        {
                            $res=$valor;
                        }
                        else
                        {
                            $res=$res.",".$valor;
                        }
                    }
                }
            }
            $peli->setGenreIds($res);
            $generoDAO=new GeneroDAO();
            $arrayGeneros= $generoDAO->getAll();
            $generos=array();
            $generos=explode($peli->getGenreIds(),",");
            $arrayGen= array();
            foreach ($generos as $generoIncluido)   //este es un array id1,id2,id3,etc
            {
                foreach ($arrayGeneros as $genero)  //este es un array id 1 valor accion, id2 valor etc..
                {
                    if ($generoIncluido==$genero->getId())
                    {
                        array_push($arrayGen,$genero);
                    }
                }
            }
            $peli->setArrayGeneros($arrayGen);     */      
        }         
        return $peli;
    }
    protected function getArrayType()
    {
        $arrayAux=array();
        $arrayAux['id'] = "INT NOT NULL";
        $arrayAux['popularity'] = "VARCHAR (500)";
        $arrayAux['title'] = "VARCHAR (500)";
        $arrayAux['overview'] = "VARCHAR (500)";
        $arrayAux['releasedate'] = "VARCHAR (500)";
        $arrayAux['image'] = "VARCHAR (500)";
        $arrayAux['CONSTRAINT pk_cinema'] = "PRIMARY KEY (id)";    
        return $arrayAux;
    }
    public function add(iGuardable $objeto)
    {
        DBGen::addOneWithId($this->getDatabase(), $objeto->toArray());
    }
}
?>