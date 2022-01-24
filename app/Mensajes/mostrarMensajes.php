<?php
/**
 * Description of 
 *
 * @author DAW2
 */
class mostrarMensajes{
    static public function anadirMensaje($mensaje) {
        
        $_SESSION['mensajes'][] = $mensaje;
        
    }

    static public function imprimirMensaje() {
        
        if(isset($_SESSION['mensajes'])) {
            
            foreach($_SESSION['mensajes'] as $mensaje){
                
                print '<div class="error" style="background-color: #FFF8AE; color: red;">' . $mensaje . '</div>';
                
            }
            
            unset($_SESSION['mensajes']);
            
        }
        
    }
    
}