<?php
/**
 * Description of PublicacionDAO
 *
 * @author Álvaro Sánchez
 */
class PublicacionDAO {
    
    private $conn;
    
    function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function deletePublicacion($publicacion){
        
        if(!$publicacion instanceof Publicacion || $publicacion == null){
            return false;
        }
        
        $sql = "DELETE FROM publicacion WHERE idPublicacion = ?";
        
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        
        $stmt->bind_param('i',$publicacion->getIdPublicacion());
        $stmt->execute();
        
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function insertPublicacion($publicacion){
        
        if(!$publicacion instanceof Publicacion){
            return false;
        }
        
        $cabecera = $publicacion->getCabecera();
        $idContinente = $publicacion->getIdContinente();
        $cuerpo = $publicacion->getCuerpo();
        $estrellas = $publicacion->getEstrellas();
        $idUsuario = $publicacion->getIdUsuario();
        
        $sql = "INSERT INTO publicacion (cabecera, cuerpo, idContinente, idUsuario, estrellas) VALUES" . 
                "(?,?,?,?,?)";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('ssiii',$cabecera, $cuerpo, $idContinente, $idUsuario, $estrellas);
        $stmt->execute();
        
        $publicacion->setIdPublicacion($this->conn->insert_id);
        
        return true;
        
    }

    public function findAllPublicaciones() {
        
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM publicacion ORDER BY fecha DESC";
        
        if(!$result = $this->conn->query($sql)){
            
            die("Error en la consulta: " + $this->conn->error);
            
        }
        
        $arrayPublicaciones = array();
        
        while ($publicacion = $result->fetch_object('Publicacion')) {
            
            $arrayPublicaciones[] = $publicacion;
            
        }
        
        return $arrayPublicaciones;
        
    }
    
    public function findMejoresPublicaciones(){
        
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM publicacion WHERE estrellas > 4.5 ORDER BY fecha DESC";
        
        if(!$result = $this->conn->query($sql)){
            
            die("Error en la consulta : " . $this->conn->error);
            
        }
        
        $arrayMejoresPublicaciones = array();
        
        while($mejoresPublicaciones = $result->fetch_object('Publicacion')){
            
            $arrayMejoresPublicaciones[] = $mejoresPublicaciones;
            
        }
        
        return $arrayMejoresPublicaciones;
    }
    
    public function findPublicacionesByEmail($email){
        
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM publicacion p WHERE correo = ? ORDER BY fecha DESC";
        
        if(!$stmt = $this->conn->prepare($sql)){
            
            die("Error al preparar la consulta: " . $this->conn->error);
            
        }
        
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $arrayPublicacionesUsuario = array();
        
        while($publicacionesUsuario = $result->fetch_object('Publicacion')){
            
            $arrayPublicacionesUsuario[] = $publicacionesUsuario;
            
        }
        
        return $arrayPublicacionesUsuario;
        
    }
    public function findPublicacionesByIdUsuario($id){
        
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM publicacion p WHERE idUsuario = ? ORDER BY fecha DESC";
        
        if(!$stmt = $this->conn->prepare($sql)){
            
            die("Error al preparar la consulta: " . $this->conn->error);
            
        }
        
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $arrayPublicacionesUsuario = array();
        
        while($publicacionesUsuario = $result->fetch_object('Publicacion')){
            
            $arrayPublicacionesUsuario[] = $publicacionesUsuario;
            
        }
        
        return $arrayPublicacionesUsuario;
        
    }
    
    public function findPublicacionById($id){
        
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM publicacion WHERE idPublicacion= ?";
        
        if(!$stmt = $this->conn->prepare($sql)){
            
            die("Error al preparar la consulta: " . $this->conn->error);
            
        }
        
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
  
        return $result->fetch_object('Publicacion');
        
    }
    
    public function findByParametros($parametroBusqueda, $parametroCoincidencia){
        
        if($parametroBusqueda == "cabecera"){
            $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM publicacion WHERE cabecera LIKE ?";

            if(!$stmt = $this->conn->prepare($sql)){

                die("Error al preparar la consulta: " . $this->conn->error);

            }
            $param = "%".$parametroCoincidencia."%";

            $stmt->bind_param('s', $param);
            $stmt->execute();
            $result = $stmt->get_result();

            $arrayPublicaciones = array();

            while($publicacion = $result->fetch_object('Publicacion')){

                $arrayPublicaciones[] = $publicacion;

            }

            return $arrayPublicaciones;
            
        }
        if($parametroBusqueda == "estrellas"){
            $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM publicacion WHERE estrellas LIKE ?";
        
            if(!$stmt = $this->conn->prepare($sql)){

                die("Error al preparar la consulta: " . $this->conn->error);

            }

            $stmt->bind_param('i', $parametroCoincidencia);
            $stmt->execute();
            $result = $stmt->get_result();

            $arrayPublicaciones = array();

            while($publicacion = $result->fetch_object('Publicacion')){

                $arrayPublicaciones[] = $publicacion;

            }

            return $arrayPublicaciones;
            
        }
        
    }
}