<?php
/**
 * Description of Usuarios
 *
 * @author Álvaro Sánchez
 */
class Usuario {

    private $idUsuario;
    private $nombre;
    private $contrasena;
    private $correo;
    private $imagen;
    private $idCookie;
    
    private $publicaciones;
    
    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getContrasena() {
        return $this->contrasena;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getIdCookie() {
        return $this->idCookie;
    }

    function getPublicaciones() {
        return $this->publicaciones;
    }

    function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setContrasena($contrasena): void {
        $this->contrasena = $contrasena;
    }

    function setCorreo($correo): void {
        $this->correo = $correo;
    }

    function setImagen($imagen): void {
        $this->imagen = $imagen;
    }

    function setIdCookie($idCookie): void {
        $this->idCookie = $idCookie;
    }
    
    function setPublicaciones($publicaciones): void {
        $this->publicaciones = $publicaciones;
    }

}