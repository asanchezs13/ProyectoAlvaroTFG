<?php
//Conexión a la base de datos
class ConexionBD {
    public static function conectar(): mysqli{
        
        $conn = new mysqli('localhost','root','','bdviajes');

        if($conn->connect_error){
            die("Error al conectar con MySQL: " . $conn->error);
        }
        return $conn;
    }
}