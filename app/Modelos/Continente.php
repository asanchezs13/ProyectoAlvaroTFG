<?php
/**
 * Description of Continente
 *
 * @author Álvaro Sánchez
 */

class Continente {
    
    private $idContinente;
    private $nombre;
    
    private $publicaciones;
    
    function getIdContinente() {
        return $this->idContinente;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPublicaciones() {
        return $this->publicaciones;
    }

    function setPublicaciones($publicaciones): void {
        $this->publicaciones = $publicaciones;
    }

    function setIdContinente($idContinente): void {
        $this->idContinente = $idContinente;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

}