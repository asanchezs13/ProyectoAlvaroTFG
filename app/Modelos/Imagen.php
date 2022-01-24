<?php
/**
 * Description of Imagen
 *
 * @author Álvaro Sánchez
 */
class Imagen {
    
    private $idImagen;
    private $nombreImagen;
    private $idPublicacion;
    
    private $publicacion;
    
    function getIdImagen() {
        return $this->idImagen;
    }

    function getNombreImagen() {
        return $this->nombreImagen;
    }

    function getIdPublicacion() {
        return $this->idPublicacion;
    }
    
    function getPublicacion() {
        return $this->publicacion;
    }

    function setIdImagen($idImagen): void {
        $this->idImagen = $idImagen;
    }

    function setNombreImagen($nombreImagen): void {
        $this->nombreImagen = $nombreImagen;
    }

    function setIdPublicacion($idPublicacion): void {
        $this->idPublicacion = $idPublicacion;
    }

    function setPublicacion($publicacion): void {
        $this->publicacion = $publicacion;
    }

}