<?php

require_once "../config/conexion.php";

class Publicacion {

    private $conexion;

    public function __construct() {

        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function crear(
        $idUsuario,
        $titulo,
        $contenido
    ) {

        $sql = "INSERT INTO publicaciones
                (
                    id_usuario,
                    titulo,
                    contenido
                )
                VALUES
                (
                    :id_usuario,
                    :titulo,
                    :contenido
                )";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ":id_usuario" => $idUsuario,
            ":titulo" => $titulo,
            ":contenido" => $contenido
        ]);
    }

    public function listar() {

        $sql = "
            SELECT
                p.*,
                u.nombre
            FROM publicaciones p
            INNER JOIN usuarios u
                ON p.id_usuario = u.id
            ORDER BY p.fecha_creacion DESC
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminar(
    $idPublicacion,
    $idUsuario) {

    $sql = "
        DELETE FROM publicaciones
        WHERE id = :id
        AND id_usuario = :id_usuario
    ";

    $stmt =
        $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $idPublicacion,
        ":id_usuario" => $idUsuario
    ]);
}
public function editar($id, $titulo, $contenido, $id_usuario) {

    $sql = "UPDATE publicaciones
            SET titulo = :titulo,
                contenido = :contenido
            WHERE id = :id
            AND id_usuario = :id_usuario";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $id,
        ":titulo" => $titulo,
        ":contenido" => $contenido,
        ":id_usuario" => $id_usuario
    ]);
}

}