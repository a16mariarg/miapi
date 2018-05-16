<?php

class Db{
    private $servidor = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "api_db";

public function conectar(){
    try{
        $conexion = new PDO("mysql:host=$this->servidor;dbname=$this->db", $this->user,$this->password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
       // echo "Conexión establecida";
    }catch(PDOException $e){
        echo "Fallo al conectar: ". $e->getMessage();
    }
    $conexion->exec("set names utf8");
    return $conexion;
}

} //  cierre de la clase Db

?>
