<?php
class Conexion {

    private $host = "localhost";
    private $db = "u187294151_Boit";
    private $user = "u187294151_Administrador";
    private $pass = "Kl-po90a9.";
    private $conexion;

    public function conectar() {

        try {

            $this->conexion = new PDO(
                "mysql:host=$this->host;dbname=$this->db;charset=utf8",
                $this->user,
                $this->pass
            );

            $this->conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->conexion;

        } catch(PDOException $e) {

            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>