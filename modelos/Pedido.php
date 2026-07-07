<?php

require_once __DIR__ . "/../config/conexion.php";

class Pedido {

    private $conexion;

    public function __construct(){

        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function crearPedido($usuarioId){

        try{

            $this->conexion->beginTransaction();

            $sql = "
                SELECT
                    c.producto_id,
                    c.cantidad,
                    p.precio
                FROM carrito c
                INNER JOIN productos p
                    ON c.producto_id = p.id
                WHERE c.usuario_id = :usuario
            ";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ":usuario" => $usuarioId
            ]);

            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($productos) == 0){
                return false;
            }

            $total = 0;

            foreach($productos as $producto){

                $total +=
                    $producto["precio"] *
                    $producto["cantidad"];
            }

            $sql = "
                INSERT INTO pedidos
                (
                    usuario_id,
                    total,
                    estado
                )
                VALUES
                (
                    :usuario,
                    :total,
                    'Pendiente'
                )
            ";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ":usuario" => $usuarioId,
                ":total" => $total
            ]);

            $pedidoId =
                $this->conexion->lastInsertId();

            foreach($productos as $producto){

                $sql = "
                    INSERT INTO detalle_pedido
                    (
                        pedido_id,
                        producto_id,
                        cantidad,
                        precio
                    )
                    VALUES
                    (
                        :pedido,
                        :producto,
                        :cantidad,
                        :precio
                    )
                ";

                $stmt =
                    $this->conexion->prepare($sql);

                $stmt->execute([
                    ":pedido" => $pedidoId,
                    ":producto" => $producto["producto_id"],
                    ":cantidad" => $producto["cantidad"],
                    ":precio" => $producto["precio"]
                ]);
            }

            $sql = "
                DELETE FROM carrito
                WHERE usuario_id = :usuario
            ";

            $stmt =
                $this->conexion->prepare($sql);

            $stmt->execute([
                ":usuario" => $usuarioId
            ]);

            $this->conexion->commit();

            return $pedidoId;

        }catch(Exception $e){

            $this->conexion->rollBack();

            return false;
        }
    }
    public function obtenerPedidos($usuarioId){

    $sql = "
        SELECT
            id,
            total,
            estado,
            fecha
        FROM pedidos
        WHERE usuario_id = :usuario
        ORDER BY id DESC
    ";

    $stmt =
        $this->conexion->prepare($sql);

    $stmt->execute([
        ":usuario" => $usuarioId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerDetalle($pedidoId, $usuarioId){

    $sql = "
        SELECT
            p.nombre,
            p.imagen,
            d.cantidad,
            d.precio
        FROM detalle_pedido d
        INNER JOIN productos p
            ON d.producto_id = p.id
        INNER JOIN pedidos pe
            ON d.pedido_id = pe.id
        WHERE d.pedido_id = :pedido
        AND pe.usuario_id = :usuario
    ";

    $stmt =
        $this->conexion->prepare($sql);

    $stmt->execute([
        ":pedido" => $pedidoId,
        ":usuario" => $usuarioId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerTodos(){

    $sql = "
        SELECT
            p.id,
            p.total,
            p.estado,
            p.fecha,
            u.nombre AS usuario
        FROM pedidos p
        INNER JOIN usuarios u
            ON p.usuario_id = u.id
        ORDER BY p.id DESC
    ";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function actualizarEstado($pedidoId, $estado){

    $sql = "
        UPDATE pedidos
        SET estado = :estado
        WHERE id = :id
    ";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $pedidoId,
        ":estado" => $estado
    ]);
}
public function obtenerTodosAdmin(){

    $sql = "
        SELECT
            p.id,
            p.total,
            p.estado,
            p.fecha,

            u.nombre,
            u.correo,
            u.direccion,
            u.ciudad,
            u.estado_envio,
            u.codigo_postal,
            u.telefono

        FROM pedidos p
        INNER JOIN usuarios u
            ON p.usuario_id = u.id
        ORDER BY p.id DESC
    ";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerPedidoPorId($pedidoId){

    $sql = "
        SELECT
            p.id,
            p.total,
            p.estado,
            p.fecha,

            u.nombre,
            u.correo,
            u.direccion,
            u.ciudad,
            u.estado_envio,
            u.codigo_postal,
            u.telefono

        FROM pedidos p

        INNER JOIN usuarios u
            ON p.usuario_id = u.id

        WHERE p.id = :id
    ";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute([
        ":id" => $pedidoId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function obtenerPedidoCompleto($pedidoId, $usuarioId){

    $sql = "
    SELECT
        p.id,
        p.total,
        p.estado,

        u.nombre,
        u.correo,
        u.direccion,
        u.ciudad,
        u.estado_envio,
        u.codigo_postal,
        u.telefono

    FROM pedidos p
    LEFT JOIN usuarios u
        ON p.usuario_id = u.id
    WHERE p.id = :id
    AND p.usuario_id = :usuario
";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute([
        ":id" => $pedidoId,
        ":usuario" => $usuarioId
    ]);

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    return $resultado ? $resultado : [];
}
public function obtenerProductosPedido($pedidoId){

    $sql = "
        SELECT
            pr.nombre,
            dp.cantidad,
            dp.precio

        FROM detalle_pedido dp

        INNER JOIN productos pr
            ON dp.producto_id = pr.id

        WHERE dp.pedido_id = :pedido
    ";

    $stmt = $this->conexion->prepare($sql);

    $stmt->execute([
        ":pedido" => $pedidoId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function marcarComoPagado($pedidoId){

    $sql = "
        UPDATE pedidos
        SET estado = 'Pagado'
        WHERE id = :id
    ";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([

        ":id"=>$pedidoId

    ]);
}
public function guardarPago(
    $pedidoId,
    $paymentId,
    $metodo,
    $monto,
    $estado
){

    $sql = "
        INSERT INTO pagos
        (
            pedido_id,
            payment_id,
            metodo,
            monto,
            estado
        )
        VALUES
        (
            :pedido,
            :payment,
            :metodo,
            :monto,
            :estado
        )
    ";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([

        ":pedido" => $pedidoId,
        ":payment" => $paymentId,
        ":metodo" => $metodo,
        ":monto" => $monto,
        ":estado" => $estado

    ]);

}

}