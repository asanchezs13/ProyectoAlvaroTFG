<?php
/**
 * Description of Publicacion
 *
 * @author Álvaro Sánchez
 */
class Publicacion {   

    private $idPublicacion;
    private $cabecera;
    private $cuerpo;
    private $estrellas;
    private $fecha;
    private $idContinente;
    private $idUsuario;

    private $usuario; 
    private $imagen;
    private $continente;
    
    function getIdPublicacion() {
        return $this->idPublicacion;
    }

    function getCabecera() {
        return $this->cabecera;
    }

    function getCuerpo() {
        return $this->cuerpo;
    }

    function getIdContinente() {
        return $this->idContinente;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getEstrellas() {
        return $this->estrellas;
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    
    function getUsuario(){
        if (!isset($this->usuario)) {
            $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
            $this->usuario = $usuarioDAO->find($this->getIdUsuario());
        }
        return $this->usuario;
    }
    function getImagenes() {
        if (!isset($this->imagen)) {
            $imagenDAO = new ImagenDAO(ConexionBD::conectar());
            $this->imagen = $imagenDAO->find($this->idPublicacion);
        }
        return $this->imagen;
    }
    function getContinente() {
        if (!isset($this->continente)) {
            $continenteDAO = new ContinenteDAO(ConexionBD::conectar());
            $this->continente = $continenteDAO->find($this->idContinente);
        }
        return $this->continente;
    }

    
    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }
    
    function setIdPublicacion($idPublicacion): void {
        $this->idPublicacion = $idPublicacion;
    }

    function setCabecera($cabecera): void {
        $this->cabecera = $cabecera;
    }

    function setCuerpo($cuerpo): void {
        $this->cuerpo = $cuerpo;
    }

    function setIdContinente($idContinente): void {
        $this->idContinente = $idContinente;
    }

    function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    function setEstrellas($estrellas): void {
        $this->estrellas = $estrellas;
    }
    

}