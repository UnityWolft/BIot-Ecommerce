<?php

require_once "../config/conexion.php";

class Producto {

    private $conexion;

    public function __construct() {

        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function crear(
    $nombre,
    $categoria,
    $precio,
    $stock,
    $estado,
    $imagen
) {

    $sql = "INSERT INTO productos
            (
                nombre,
                categoria,
                precio,
                stock,
                estado,
                imagen
            )
            VALUES
            (
                :nombre,
                :categoria,
                :precio,
                :stock,
                :estado,
                :imagen
            )";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":nombre" => $nombre,
        ":categoria" => $categoria,
        ":precio" => $precio,
        ":stock" => $stock,
        ":estado" => $estado,
        ":imagen" => $imagen
    ]);
}

    public function listar() {

        $sql = "SELECT *
                FROM productos
                ORDER BY id DESC";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
public function editar(
    $id,
    $nombre,
    $categoria,
    $precio,
    $stock,
    $estado
) {

    $sql = "UPDATE productos
            SET nombre = :nombre,
                categoria = :categoria,
                precio = :precio,
                stock = :stock,
                estado = :estado
            WHERE id = :id";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $id,
        ":nombre" => $nombre,
        ":categoria" => $categoria,
        ":precio" => $precio,
        ":stock" => $stock,
        ":estado" => $estado
    ]);
}

public function eliminar($id) {

    $sql = "DELETE FROM productos
            WHERE id = :id";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $id
    ]);
}

public function obtenerActivos() {

    $sql = "SELECT *
            FROM productos
            WHERE estado = 'Activo'
            ORDER BY id DESC";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}