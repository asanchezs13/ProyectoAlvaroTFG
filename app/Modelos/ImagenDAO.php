<?php
/**
 * Description of ImagenDAO
 *
 * @author Álvaro Sánchez
 */
class ImagenDAO {
    
    private $conn;
    
    function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function find($idPublicacion){
        
        $sql = "SELECT * FROM imagen WHERE idPublicacion = ?";
        
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        
        $stmt->bind_param('i', $idPublicacion);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $arrayImagenes = array();
        
        while ($imagen = $result->fetch_object('Imagen')) {
            
            $arrayImagenes[] = $imagen;
            
        }
        
        return $arrayImagenes;
        
    }
    
    public function insertImagen($imagen){
        
        if(!$imagen instanceof Imagen){
            return false;
        }
        
        $nombre = $imagen->getNombreImagen();
        $idPubli = $imagen->getIdPublicacion();
        
        $sql = "INSERT INTO imagen (nombreImagen, idPublicacion) VALUES" .
                "(?,?)";
        
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('si', $nombre, $idPubli);
        $stmt->execute();
        
        $imagen->setIdImagen($this->conn->insert_id);
        
        return true;
        
    }
}