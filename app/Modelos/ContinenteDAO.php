<?php
/**
 * Description of ContinenteDAO
 *
 * @author Álvaro Sánchez
 */
class ContinenteDAO {
    
    private $conn;
    
    function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function find($id) {
        
        $sql = "SELECT * FROM continente WHERE idContinente = ?";
        
            if(!$stmt = $this->conn->prepare($sql)){
            
                die("Error al preparar la consulta: " . $this->conn->error);
            
            }

            $stmt->bind_param('i',$id);
            $stmt->execute();
            $result = $stmt->get_result();
            
        return $result->fetch_object('Continente');
        
    }
    
    public function findAll(){
        
        $sql = "SELECT * FROM continente";
        
            if (!$result = $this->conn->query($sql)) {
                
                die("Error en la SQL : " . $this->conn->error);
                
            }
        
        $arrayContinentes = array();
        
        while($continente = $result->fetch_object('Continente')){
            
            $arrayContinentes[] = $continente;
            
        }     
        
        return $arrayContinentes;
    }
}