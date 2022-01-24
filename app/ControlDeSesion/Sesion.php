<?php
/**
 * Description of Sesion
 *
 * @author Álvaro Sánchez
 */
class Sesion {
    
    static public function iniciar($usuario){
        
        $_SESSION['sesionUsuario'] = serialize($usuario);
        
    }
    
    static public function existe() {
        
        return isset($_SESSION['sesionUsuario']);
        
    }
    
    static public function cerrar(){
        
        unset($_SESSION['sesionUsuario']);
        
    }
    
    static public function obtener(){
        
        if(isset($_SESSION['sesionUsuario'])){
            
            return unserialize($_SESSION['sesionUsuario']);
            
        }else{
            
            return false;
            
        }
    }
}