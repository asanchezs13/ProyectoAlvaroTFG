<?php
/**
 * Description of UsuarioDAO
 *
 * @author Álvaro Sánchez
 */
class UsuarioDAO {
    
    private $conn;
    
    function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function find($id) {
        
        $sql = "SELECT * FROM usuario WHERE idUsuario = ?";
        
        if(!$stmt = $this->conn->prepare($sql)){
            
            die("Error al preparar la consulta: " . $this->conn->error);
            
        }
        
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
            
        return $result->fetch_object('Usuario');
        
    }
    
    public function insertarUsuario($usuario){
        
        if(!$usuario instanceof Usuario){  
            return false;
        }
        
        $nombre = $usuario->getNombre();
        $email = $usuario->getCorreo();
        $password = $usuario->getContrasena();
        $imagen = $usuario->getImagen();
        $idCookie = sha1(time() + rand());
        
        $sql = "INSERT INTO usuario (nombre, correo, contrasena, imagen, idCookie) VALUES" . 
                "(?,?,?,?,?)";
        
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        
        $stmt->bind_param('sssss',$nombre, $email, $password, $imagen, $idCookie);
        $stmt->execute();
        
        $usuario->setIdUsuario($this->conn->insert_id);
        
        return true;
        
    }
    
    public function updateUsuario($usuario){
        
        if(!$usuario instanceof Usuario){  
            return false;
        }
        
        $nombre = $usuario->getNombre();
        $correo = $usuario->getCorreo();
        $password = $usuario->getContrasena();
        $imagen = $usuario->getImagen();
        $idCookie = $usuario->getIdCookie();
        
        $sql = "UPDATE usuario SET"
                . " nombre=?, correo=?, contrasena=?, imagen=?, idCookie=? "
                . "WHERE idUsuario= ?";
        
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        
        $stmt->bind_param('sssssi',$nombre, $correo, $password, $imagen, $idCookie, $usuario->getIdUsuario());
        $stmt->execute();
        
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function findByEmail($email){
        
        $sql = "SELECT * FROM usuario WHERE correo = ?";
        
        if(!$stmt = $this->conn->prepare($sql)){
            
            die("Error al preparar la consulta: " . $this->conn->error);
            
        }
        
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_object('Usuario');
        
    }
    
    public function findByCookie($uid){
        
        $sql = "SELECT * FROM usuario WHERE idCookie = ?";
        
        if(!$stmt = $this->conn->prepare($sql)){
            
            die("Error al preparar la consulta: " . $this->conn->error);
            
        }
        
        $stmt->bind_param('s',$uid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_object('Usuario');
        
    }
    
}