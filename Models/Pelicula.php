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

}
?>