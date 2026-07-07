<?php

require_once "../modelos/Pedido.php";

$pedido = new Pedido();

$datos = $pedido->obtenerTodosAdmin();

echo json_encode($datos);