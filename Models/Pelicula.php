<?php
//pelicula

namespace Models;
use Models\iGuardable as iGuardable;
Class Pelicula implements iGuardable
{
    private $id;// referencia a la pelicula respecto de otras, usado por la funcion  "id","popularity","title","overview","release_date","genre_ids");
    //tambien usado para ubicar el portrait y demas, es la misma ID que moviedb le asigna
    private $popularity;
    private $title;
    private $overview;
    private $releaseDate;
    private $genreIds;
    private $image;
    private $arrayGeneros;  //no se guarda en DAO

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
    }
    public function getPopularity()
    {
        return $this->popularity;
    }
    public function setPopularity($pop)
    {
        $this->popularity=$pop;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title=$title;
    }
    public function getOverview()
    {
        return $this->overview;
    }
    public function setOverview($over)
    {
        $this->overview=$over;
    }
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }
    public function setReleaseDate($release)
    {
        $this->releaseDate=$release;
    }
    public function getGenreIds()
    {
        return $this->genreIds;
    }
    public function setGenreIds($genres)
    {
        $this->genreIds=$genres;
    }
    public function getArrayGeneros()
    {
       
        return $this->arrayGeneros;
    }
    public function setArrayGeneros($array)
    {
        $this->arrayGeneros=$array;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image=$image;
    }

    
    public function toArray()
    {
        $arrayAux=array();
        $arrayAux['id'] = $this->getId();
        $arrayAux['popularity'] = $this->getPopularity();
        $arrayAux['title'] = $this->getTitle();
        $arrayAux['overview'] = $this->getOverview();
        $arrayAux['releasedate'] = $this->getReleaseDate();
        $arrayAux['image']=$this->getImage();
        $arrayAux['genre_ids'] = $this->getGenreIds();
        return $arrayAux;
    }
    public function toArrayParam()
    {
        $arrayAux=array();
        array_push($arrayAux, "id");
        array_push($arrayAux, "popularity");
        array_push($arrayAux, "title");
        array_push($arrayAux, "overview");
        array_push($arrayAux, "releasedate");
        array_push($arrayAux, "image");
        array_push($arrayAux, "genre_ids");
        return $arrayAux;
    }
    public function toArrayValue()
    {
        $arrayAux=array();
        array_push($arrayAux, $this->getId());
        array_push($arrayAux, $this->getPopularity());
        array_push($arrayAux, $this->getTitle());
        array_push($arrayAux, $this->getOverview());
        array_push($arrayAux, $this->getReleaseDate());
        array_push($arrayAux, $this->getImage());
        array_push($arrayAux, $this->getgenreIds());
        return $arrayAux;        
    }

}
?>