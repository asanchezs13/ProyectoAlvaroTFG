<?php
/**
 * Description of controladorPublicacion
 *
 * @author Álvaro Sánchez
 */
class controladorPublicacion {
    
    public function listarMejoresPublicaciones(){
        
        $conn = ConexionBD::conectar();
        
        $pdao = new PublicacionDAO($conn);
        
        $mejoresPublicaciones = $pdao->findMejoresPublicaciones();
        
        require '../app/Vistas/mejoresPublicaciones.php';
        
    }
    
    public function verPublicacion(){
        
        $conn = ConexionBD::conectar();
        
        $pdao = new PublicacionDAO($conn);
        
        $publicacion = $pdao->findPublicacionById($_GET['id']);
        
        require '../app/Vistas/verPublicacion.php';
        
    }
    
    public function publicacionesUsuario(){
        
        $conn = ConexionBD::conectar();

        $pdao = new PublicacionDAO($conn);

        $publicacionesUsuario = $pdao->findPublicacionesByIdUsuario(Sesion::obtener()->getIdUsuario());
        
        require '../app/Vistas/publicacionesUsuario.php';
        
    }
    
    public function mostrarNuevaPublicacion(){
        
        $conn = ConexionBD::conectar();
        
        $cdao = new ContinenteDAO($conn);
        
        $continentes = $cdao->findAll();
        
        require '../app/Vistas/nuevaPublicacion.php';
        
    }
    
    public function subirPublicacion(){
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $error = false;
            
            if(empty($_POST['cabecera'])){
                mostrarMensajes::anadirMensaje("No puedes dejar la cabecera en blanco.");
                $error = true;
            }
            if(empty($_POST['cuerpo'])){
                mostrarMensajes::anadirMensaje("No puedes dejar el cuerpo sin rellenar.");
                $error = true;
            }
            if(empty($_POST['continente'])){
                mostrarMensajes::anadirMensaje("No puedes no elegir un continente.");
                $error = true;
            }else if($_POST['continente']!= 1 && $_POST['continente'] != 2 && $_POST['continente'] != 3 && $_POST['continente'] != 4 && $_POST['continente'] != 5 && $_POST['continente'] != 6){
                mostrarMensajes::anadirMensaje("El continente seleccionado no existe.");
                $error = true;
            }
            if(empty($_POST['estrellas'])){
                mostrarMensajes::anadirMensaje("No puedes no poner estrellas.");
                $error = true;
            }else if($_POST['estrellas'] != 1 && $_POST['estrellas'] != 2 && $_POST['estrellas'] != 3 && $_POST['estrellas'] != 4 && $_POST['estrellas'] != 5 && $_POST['estrellas'] != 0){
                mostrarMensajes::anadirMensaje("La cantidad de estrellas no es válida.");
                $error = true;
            }    
            
            if(!$error){
                
                $cabecera = $_POST['cabecera'];
                $cuerpo = $_POST['cuerpo'];
                $continente = $_POST['continente'];
                $estrellas = $_POST['estrellas'];
                
                $conn = ConexionBD::conectar();

                $pdao = new PublicacionDAO($conn);
                $publicacion = new Publicacion();

                $cabecera = filter_var($cabecera, FILTER_SANITIZE_SPECIAL_CHARS);
                $cuerpo = filter_var($cuerpo, FILTER_SANITIZE_SPECIAL_CHARS);
                $idContinente = filter_var($continente, FILTER_SANITIZE_SPECIAL_CHARS);
                $estrellas = filter_var($estrellas, FILTER_SANITIZE_NUMBER_INT);
                $idUsuario = Sesion::obtener()->getIdUsuario();
                
                $publicacion->setCabecera($cabecera);
                $publicacion->setCuerpo($cuerpo);
                $publicacion->setEstrellas($estrellas);
                $publicacion->setIdContinente($idContinente);
                $publicacion->setIdUsuario($idUsuario);
                
                $pdao->insertPublicacion($publicacion);
                
                for($i = 0; $i < count($_FILES['imagen']['name']); $i++){
                    
                    //Comprobamos que el archivo sea una imagen o que tenga esas extensiones.
                    if($_FILES['imagen']['type'][$i] != 'image/jpg' &&
                        $_FILES['imagen']['type'][$i] != 'image/gif' &&
                        $_FILES['imagen']['type'][$i] != 'image/jpeg' &&
                        $_FILES['imagen']['type'][$i] != 'image/png'){

                        mostrarMensajes::anadirMensaje("El archivo seleccionado no es una imagen.");
                        $error = true;
                    }
                    //Comprobamos que el archivo no sea mayor de 1000000 bytes.
                    if($_FILES['imagen']['size'][$i] > 1000000){

                        mostrarMensajes::anadirMensaje("El archivo seleccionado es demasiado grande.");
                        $error = true;

                    }
                    if(!$error){
                        $nombreImg = md5(time() + rand(0, 999999));
                        $extensionImg = substr($_FILES['imagen']['name'][$i], strrpos($_FILES['imagen']['name'][$i], '.'));
                        $extensionImg = filter_var($extensionImg, FILTER_SANITIZE_SPECIAL_CHARS);

                        while(file_exists("imgPublicaciones/$nombreImg$extensionImg")){

                            $nombreImg = md5(time() + rand(0, 999999));

                        }

                        if(!move_uploaded_file($_FILES['imagen']['tmp_name'][$i], "imgPublicaciones/$nombreImg$extensionImg")){
                            mostrarMensajes::anadirMensaje("No se ha podido copiar la foto.");
                            header("Location: index.php");
                            die();
                        }

                        $idPublicacion = $publicacion->getIdPublicacion();
                        $nombreImagen = "$nombreImg$extensionImg";

                        $idao = new ImagenDAO($conn);
                        $imagen = new Imagen();

                        $imagen->setIdPublicacion($idPublicacion);
                        $imagen->setNombreImagen($nombreImagen);

                        if(!$idao->insertImagen($imagen)){
                            die("No se ha podido insertar la imagen en la base de datos.");
                        }   
                    }
                } 
                mostrarMensajes::anadirMensaje("Publicación creada.");
                header('Location: index.php');
                die();
            }
            header("Location: /ProyectoAlvaroTFG/web/index.php?accion=mostrarNuevaPublicacion");
            die();
        }   
    }  
    
    public function mostrarBuscarPublicacion(){
        require '../app/Vistas/busquedaPublicaciones.php';
    }
    
    public function busquedaPublicaciones(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $parametroBusqueda = $_POST['parametroBusqueda'];
            $parametroCoincidencia = $_POST['parametroCoincidencia'];
            
            $error = false;
            
            if(empty($parametroBusqueda)){
                mostrarMensajes::anadirMensaje("Debes seleccionar un parámetro de búsqueda.");
                $error = true;
            }
            if(empty($parametroCoincidencia)){
                mostrarMensajes::anadirMensaje("Debes introducir un parámetro de coincidencia.");
                $error = true;
            }
            
            if(!$error){
                
                $conn = ConexionBD::conectar();
                $pdao = new PublicacionDAO($conn);
                
                if($parametroBusqueda == 'estrellas' || $parametroBusqueda == 'cabecera'){
                    
                    $publicaciones1 = $pdao->findByParametros($parametroBusqueda, $parametroCoincidencia);
                    
                    if(empty($publicaciones1)){
                        mostrarMensajes::anadirMensaje("No encontramos coincidencias con esos parámetros.");
                    }
                    
                    require '../app/Vistas/busquedaPublicaciones.php';
                    
                    die();
                    
                }else{
                    mostrarMensajes::anadirMensaje("Ese parámetro de búsqueda no es válido.");
                    require '../app/Vistas/busquedaPublicaciones.php';
                    die();
                }
                
            }
            
            header("Location: /ProyectoAlvaroTFG/web/index.php?accion=mostrarBuscarPublicacion");
            die();
            
        }
        
    }
    
    public function borrarPublicacion(){
        
        if($_GET['tk'] != $_SESSION['token']){
            
            mostrarMensajes::anadirMensaje("El token no coincide.");
            require '../app/Vistas/publicacionesUsuario.php';
            die();
            
        }
        
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $conn = ConexionBD::conectar();
        $pdao = new PublicacionDAO($conn);
        $publicacion = $pdao->findPublicacionById($id);
        
        if($publicacion->getIdUsuario() == Sesion::obtener()->getIdUsuario()){
            
            for($i = 0; $i < count($publicacion->getImagenes()); $i++){
                unlink("imgPublicaciones/".$publicacion->getImagenes()[$i]->getNombreImagen());
            }
            
            if($pdao->deletePublicacion($publicacion)){
                mostrarMensajes::anadirMensaje("Publicación eliminada.");
                header("Location:/ProyectoAlvaroTFG/web/index.php?accion=publicacionesUsuario");
                die();
            }else{
                mostrarMensajes::anadirMensaje("No se ha podido eliminar la publicación.");
                header("Location:/ProyectoAlvaroTFG/web/index.php?accion=publicacionesUsuario");
                die();
            }
            
        }else{
            mostrarMensajes::anadirMensaje("El artículo no es tuyo.");
            header("Location:/ProyectoAlvaroTFG/web/index.php?accion=publicacionesUsuario");
            die();
        }
    }
}