<?php

require_once "../config/conexion.php";

class Carrito {

    private $conexion;

    public function __construct(){

        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function agregar(
        $usuarioId,
        $productoId
    ){

        $sql = "
            SELECT *
            FROM carrito
            WHERE usuario_id = :usuario
            AND producto_id = :producto
        ";

        $stmt =
            $this->conexion->prepare($sql);

        $stmt->execute([
            ":usuario" => $usuarioId,
            ":producto" => $productoId
        ]);

        $existe =
            $stmt->fetch();

        if($existe){

            $sql = "
                UPDATE carrito
                SET cantidad = cantidad + 1
                WHERE id = :id
            ";

            $stmt =
                $this->conexion->prepare($sql);

            return $stmt->execute([
                ":id" => $existe["id"]
            ]);
        }

        $sql = "
            INSERT INTO carrito
            (
                usuario_id,
                producto_id,
                cantidad
            )
            VALUES
            (
                :usuario,
                :producto,
                1
            )
        ";

        $stmt =
            $this->conexion->prepare($sql);

        return $stmt->execute([
            ":usuario" => $usuarioId,
            ":producto" => $productoId
        ]);
    }
public function obtenerCarrito($usuarioId){

    $sql = "
        SELECT
            c.id,
            c.cantidad,
            p.nombre,
            p.precio,
            p.imagen
        FROM carrito c
        INNER JOIN productos p
            ON c.producto_id = p.id
        WHERE c.usuario_id = :usuario
    ";

    $stmt =
        $this->conexion->prepare($sql);

    $stmt->execute([
        ":usuario" => $usuarioId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function eliminar($idCarrito, $usuarioId){

    $sql = "
        DELETE FROM carrito
        WHERE id = :id
        AND usuario_id = :usuario
    ";

    $stmt =
        $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $idCarrito,
        ":usuario" => $usuarioId
    ]);
}
public function aumentarCantidad($idCarrito, $usuarioId){

    $sql = "
        UPDATE carrito
        SET cantidad = cantidad + 1
        WHERE id = :id
        AND usuario_id = :usuario
    ";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $idCarrito,
        ":usuario" => $usuarioId
    ]);
}

public function disminuirCantidad($idCarrito, $usuarioId){

    $sql = "
        UPDATE carrito
        SET cantidad = cantidad - 1
        WHERE id = :id
        AND usuario_id = :usuario
        AND cantidad > 1
    ";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $idCarrito,
        ":usuario" => $usuarioId
    ]);
}
}

