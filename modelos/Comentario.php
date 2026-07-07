<?php

require_once "../config/conexion.php";

class Comentario {

    private $conexion;

    public function __construct() {

        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function crear($id_publicacion, $id_usuario, $comentario) {

        $sql = "INSERT INTO comentarios
                (id_publicacion, id_usuario, comentario)
                VALUES (:id_publicacion, :id_usuario, :comentario)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ":id_publicacion" => $id_publicacion,
            ":id_usuario" => $id_usuario,
            ":comentario" => $comentario
        ]);
    }

    public function listarPorPublicacion($id_publicacion) {

    $sql = "SELECT
                c.*,
                u.nombre
            FROM comentarios c
            INNER JOIN usuarios u
                ON c.id_usuario = u.id
            WHERE c.id_publicacion = :id_publicacion
            ORDER BY c.fecha_creacion ASC";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute([
        ":id_publicacion" => $id_publicacion
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function eliminar($idComentario, $idUsuario) {

    $sql = "DELETE FROM comentarios
            WHERE id = :id
            AND id_usuario = :id_usuario";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $idComentario,
        ":id_usuario" => $idUsuario
    ]);
}
}