<?php

require_once "../config/conexion.php";

if($_SERVER["REQUEST_METHOD"] != "POST"){
    exit;
}

$id = $_POST["id"] ?? 0;

$db = new Conexion();
$conexion = $db->conectar();

try{

    $conexion->beginTransaction();

    // Eliminar detalles primero
    $sql = "
        DELETE FROM detalle_pedido
        WHERE pedido_id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ":id" => $id
    ]);

    // Eliminar pedido
    $sql = "
        DELETE FROM pedidos
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ":id" => $id
    ]);

    $conexion->commit();

    echo json_encode([
        "success" => true
    ]);

}catch(Exception $e){

    $conexion->rollBack();

    echo json_encode([
        "success" => false
    ]);
}