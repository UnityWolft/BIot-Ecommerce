<?php

require_once __DIR__ . "/../config/conexion.php";

class Usuario {

    private $conexion;

    public function __construct() {

        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function registrar(
    $nombre,
    $correo,
    $password,
    $token
) {

    $sql = "
        INSERT INTO usuarios
        (
            nombre,
            correo,
            password,
            token_verificacion,
            verificado
        )
        VALUES
        (
            :nombre,
            :correo,
            :password,
            :token,
            0
        )
    ";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':password' => $password,
        ':token' => $token
    ]);
}

    public function buscarCorreo($correo) {

        $sql = "SELECT * FROM usuarios
                WHERE correo = :correo";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':correo' => $correo
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function login($correo) {

    $sql = "SELECT * FROM usuarios
            WHERE correo = :correo";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute([
        ':correo' => $correo
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function obtenerPorId($id) {

    $sql = "SELECT
                id,
                nombre,
                correo,
                direccion,
                ciudad,
                estado_envio,
                codigo_postal,
                telefono
            FROM usuarios
            WHERE id = :id";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute([
        ":id" => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function actualizarPerfil(
    $id,
    $nombre,
    $correo,
    $direccion,
    $ciudad,
    $estado_envio,
    $codigo_postal,
    $telefono
){

    $sql = "UPDATE usuarios
            SET nombre = :nombre,
                correo = :correo,
                direccion = :direccion,
                ciudad = :ciudad,
                estado_envio = :estado_envio,
                codigo_postal = :codigo_postal,
                telefono = :telefono
            WHERE id = :id";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $id,
        ":nombre" => $nombre,
        ":correo" => $correo,
        ":direccion" => $direccion,
        ":ciudad" => $ciudad,
        ":estado_envio" => $estado_envio,
        ":codigo_postal" => $codigo_postal,
        ":telefono" => $telefono
    ]);
}
public function obtenerUsuarioCompleto($id) {

    $sql = "SELECT *
            FROM usuarios
            WHERE id = :id";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute([
        ":id" => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function actualizarPassword(
    $id,
    $password
) {

    $sql = "UPDATE usuarios
            SET password = :password
            WHERE id = :id";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $id,
        ":password" => $password
    ]);
}
public function verificarCuenta($token){

    // 1. Buscar usuario por token
    $sql = "SELECT id, verificado 
            FROM usuarios 
            WHERE token_verificacion = :token";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([":token" => $token]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // ❌ Token no existe
    if(!$usuario){
        return false;
    }

    // ⚠️ Ya estaba verificado (caso importante)
    if($usuario["verificado"] == 1){
        return "ya_verificado";
    }

    // ✅ Activar cuenta
    $sql = "UPDATE usuarios 
            SET verificado = 1,
                token_verificacion = NULL
            WHERE id = :id";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $usuario["id"]
    ]);
}
}
?>