<?php
session_start();

require '../app/Conexion/ConexionBD.php';
require '../app/ControlDeSesion/Sesion.php';
require '../app/Mensajes/mostrarMensajes.php';
require '../app/Controladores/controladorUsuario.php';
require '../app/Controladores/controladorPublicacion.php';
require '../app/Modelos/PublicacionDAO.php';
require '../app/Modelos/UsuarioDAO.php';
require '../app/Modelos/ImagenDAO.php';
require '../app/Modelos/ContinenteDAO.php';
require '../app/Modelos/Publicacion.php';
require '../app/Modelos/Usuario.php';
require '../app/Modelos/Imagen.php';
require '../app/Modelos/Continente.php';

$rutas = array(
    'inicio' => array('controlador' => 'controladorUsuario', 'metodo' => 'iniciar', 'publica' => true),
    'login' => array('controlador' => 'controladorUsuario', 'metodo' => 'login', 'publica' => true),
    'registro' => array('controlador' => 'controladorUsuario', 'metodo' => 'registrar', 'publica' => true),
    'mostrarIniciarSesion' => array('controlador' => 'controladorUsuario', 'metodo' => 'mostrarIniciarSesion', 'publica' => true),
    'mostrarRegistrarSesion' => array('controlador' => 'controladorUsuario', 'metodo' => 'mostrarRegistrarSesion', 'publica' => true),
    'cerrarSesion' => array('controlador' => 'controladorUsuario', 'metodo' => 'logout', 'publica' => false),
    'verPublicacion' => array('controlador' => 'controladorPublicacion', 'metodo' => 'verPublicacion', 'publica' => true),
    'publicacionesUsuario' => array('controlador' => 'controladorPublicacion', 'metodo' => 'publicacionesUsuario', 'publica' => false), 
    'mejoresPublicaciones' => array('controlador' => 'controladorPublicacion', 'metodo' => 'listarMejoresPublicaciones', 'publica' => true),
    'mostrarNuevaPublicacion' => array('controlador' => 'controladorPublicacion', 'metodo' => 'mostrarNuevaPublicacion', 'publica' => false),
    'subirPublicacion' => array('controlador' => 'controladorPublicacion', 'metodo' => 'subirPublicacion', 'publica' => false),
    'mostrarBuscarPublicacion' => array('controlador' => 'controladorPublicacion', 'metodo' => 'mostrarBuscarPublicacion', 'publica' => true),
    'busquedaPublicaciones' => array('controlador' => 'controladorPublicacion', 'metodo' => 'busquedaPublicaciones', 'publica' => true),
    'borrarPublicacion' => array('controlador' => 'controladorPublicacion', 'metodo' => 'borrarPublicacion', 'publica' => false),
    'cambiarFoto' => array('controlador' => 'controladorUsuario', 'metodo' => 'cambiarImagen', 'publica' => false),
);

//Evaluamos que haya alguna acción a realizar pasada por parámetro.
if(isset($_GET['accion'])){
    //Evaluamos que la ruta a la acción exista.
    if(isset($rutas[$_GET['accion']])){
        //Asignamos el valor de la acción para luego acceder a ella.
        $accion = $_GET['accion'];
    //Si no existe la ruta lo enviamos al index.php y mostramos un mensaje.
    }else{
        
        header("Location: index.php");
        die();
        
    }
//Si no hubiese ninguna acción pasada por parámetro, envíamos al inicio.
}else{
    
    $accion = 'inicio';
    
}

if ($rutas[$accion]['publica'] == false) {
    
    if (!Sesion::existe()) {
        
        mostrarMensajes::anadirMensaje("Debes iniciar sesión para acceder a esta página.");
        header('Location: index.php');
        die();
        
    }
    
}

//Si tiene cookie y no ha iniciado sesión, iniciamos sesión automáticamente
if(isset($_COOKIE['uid']) && Sesion::existe() == false) { //Si existe la cookie lo identificamos
    
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS);
    
    $udao = new UsuarioDAO(ConexionBD::conectar());
    
    $usuario = $udao->findByCookie($uid);
    
    if ($usuario != false) {   //Si existe un usuario con la cookie iniciamos sesión
        
        Sesion::iniciar($usuario);
        
    }
    
}

$controlador = $rutas[$accion]['controlador'];
$metodo = $rutas[$accion]['metodo'];

//Ejecutamos el método del controlador.
$controlador = new $controlador();
$controlador->$metodo();