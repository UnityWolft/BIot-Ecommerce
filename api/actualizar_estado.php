<?php

require_once "../modelos/Pedido.php";

$pedido = new Pedido();

$id = $_POST["id"];
$estado = $_POST["estado"];

echo json_encode([
    "success" => $pedido->actualizarEstado($id, $estado)
]);