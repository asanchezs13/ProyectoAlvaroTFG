<?php
/**
 * Description of controladorUsuario
 *
 * @author Álvaro Sánchez
 */
class controladorUsuario {
    
    public function mostrarIniciarSesion(){
        require '../app/Vistas/iniciarSesion.php';
    }
    public function mostrarRegistrarSesion(){
        require '../app/Vistas/registro.php';
    }
    
    public function iniciar(){
        
        $conn = ConexionBD::conectar();
        
        $publicacionDAO = new PublicacionDAO($conn);
        
        $publicaciones = $publicacionDAO->findAllPublicaciones();
        
        $_SESSION['token'] = md5(time() + rand(0, 999));
        
        $token = $_SESSION['token'];
        
        require '../app/Vistas/inicio.php';     
        
    }
    
    public function registrar(){
        
        //Verificamos que los datos vengan a través del método POST.
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            //Comprobamos que el token que enviamos por post sea el mismo que el token de la sesión.
            if($_POST['token'] != $_SESSION['token']){
                
                mostrarMensajes::anadirMensaje("El token no coincide.");
                header("Location: index.php");
                die();
                
            }
            
            $usuario = new Usuario();
            $error = false;
            
            //Comprobamos que el nombre no esté vacío.
            if(empty($_POST['nombre'])){
                mostrarMensajes::anadirMensaje("Introduce un valor en el nombre.");
                $error = true;
            }
            //Comprobamos que el email no esté vacío.
            if(empty($_POST['email'])){
                mostrarMensajes::anadirMensaje("Introduce un email.");
                $error = true;
            }else{
                //Comprobamos que el email sea válido.
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                mostrarMensajes::anadirMensaje("El email no es válido.");
                $error = true;
            }
            }
            //Comprobamos que la contraseña no esté vacía.
            if(empty($_POST['contrasena'])){
                mostrarMensajes::anadirMensaje("Introduce una contraseña.");
                $error = true;
            }
            //Comprobamos que el archivo sea una imagen o que tenga esas extensiones.
            if($_FILES['imagen']['type'] != 'image/jpg' &&
                $_FILES['imagen']['type'] != 'image/gif' &&
                $_FILES['imagen']['type'] != 'image/jpeg' &&
                $_FILES['imagen']['type'] != 'image/png'){
                
                mostrarMensajes::anadirMensaje("El archivo seleccionado no es una imagen.");
                $error = true;
            }
            //Comprobamos que el archivo no sea mayor de 1000000 bytes.
            if($_FILES['imagen']['size'] > 1000000){
                
                mostrarMensajes::anadirMensaje("El archivo seleccionado es demasiado grande.");
                $error = true;
                
            }
            
            //Si todas las condiciones se cumplen el error será false.
            if(!$error){
                
                $nombreImg = md5(time() + rand(0, 999999));
                $extensionImg = substr($_FILES['imagen']['name'], strrpos($_FILES['imagen']['name'], '.'));
                $extensionImg = filter_var($extensionImg, FILTER_SANITIZE_SPECIAL_CHARS);
                
                while(file_exists("imgUsuarios/$nombreImg$extensionImg")){
                    
                    $nombreImg = md5(time() + rand(0, 999999));
                    
                }
                
                move_uploaded_file($_FILES['imagen']['tmp_name'], "imgUsuarios/$nombreImg$extensionImg");
                
                $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                
                $usuario->setNombre($nombre);
                $usuario->setCorreo($email);
                $usuario->setContrasena(password_hash($_POST['contrasena'], PASSWORD_DEFAULT));
                $usuario->setImagen($nombreImg.$extensionImg);
                
                $udao = new UsuarioDAO(ConexionBD::conectar());
                $udao->insertarUsuario($usuario);
                
                mostrarMensajes::anadirMensaje("Usuario creado.");
                header('Location: index.php');
                die();
                
            }
                
                //Generamos un token.
                $token = md5(time() + rand(0, 999));
                $_SESSION['token'] = $token;
            
            require '../app/Vistas/registro.php';
            
        }
        
    }
    
    public function cambiarImagen(){
        
        $error = false;
        //Comprobamos que el archivo sea una imagen o que tenga esas extensiones.
        if($_FILES['imagen']['type'] != 'image/jpg' &&
            $_FILES['imagen']['type'] != 'image/gif' &&
            $_FILES['imagen']['type'] != 'image/jpeg' &&
            $_FILES['imagen']['type'] != 'image/png'){

            mostrarMensajes::anadirMensaje("El archivo seleccionado no es una imagen.");
            $error = true;
        }
        //Comprobamos que el archivo no sea mayor de 1000000 bytes.
        if($_FILES['imagen']['size'] > 1000000){

            mostrarMensajes::anadirMensaje("El archivo seleccionado es demasiado grande.");
            $error = true;

        }
            //Si todas las condiciones se cumplen el error será false.
            if(!$error){
                
                $nombreImg = md5(time() + rand(0, 999999));
                $extensionImg = substr($_FILES['imagen']['name'], strrpos($_FILES['imagen']['name'], '.'));
                $extensionImg = filter_var($extensionImg, FILTER_SANITIZE_SPECIAL_CHARS);
                
                while(file_exists("imgUsuarios/$nombreImg$extensionImg")){
                    
                    $nombreImg = md5(time() + rand(0, 999999));
                    
                }
                
                move_uploaded_file($_FILES['imagen']['tmp_name'], "imgUsuarios/$nombreImg$extensionImg");
                
                $udao = new UsuarioDAO(ConexionBD::conectar());
                $usuario = $udao->find(Sesion::obtener()->getIdUsuario());
                unlink("imgUsuarios/".$usuario->getImagen());
                $usuario->setImagen($nombreImg.$extensionImg);
                
                $udao->updateUsuario($usuario);
                Sesion::iniciar($usuario);
                
                mostrarMensajes::anadirMensaje("Imagen actualizada.");
                header('Location: index.php');
                die();
            }
            mostrarMensajes::anadirMensaje("No se ha podido actualizar.");
            header('Location: index.php');
            die();
    }
    
    public function login(){
        
        $udao = new UsuarioDAO(ConexionBD::conectar());
        
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);  
        
        if(!$usuario = $udao->findByEmail($email)){
            
            mostrarMensajes::anadirMensaje("Usuario incorrecto.");
            require '../app/Vistas/iniciarSesion.php';
            die();
        }
        if(password_verify($_POST['contrasena'], $usuario->getContrasena())){
            
            Sesion::iniciar($usuario);
            
            $usuario->setIdCookie(sha1(time() + rand()));
            $udao->updateUsuario($usuario);
            setcookie('uid', $usuario->getIdCookie(), time() + 60 * 60 * 24 * 7);
            
            mostrarMensajes::anadirMensaje("Usuario logeado.");
            header("Location: index.php");
        }else{
            mostrarMensajes::anadirMensaje("Contraseña incorrecta.");
            require '../app/Vistas/iniciarSesion.php';
            die();
        }
        
    }
    
    public function logout(){
        
        Sesion::cerrar();
        
        setcookie('uid', '', time() - 5);
        
        mostrarMensajes::anadirMensaje("Sesión cerrada.");
        
        header("Location: index.php");
        
    }
    
}
