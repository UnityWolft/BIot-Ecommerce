<?php

require_once "../modelos/Producto.php";

$producto = new Producto();

echo json_encode(
    $producto->obtenerActivos()
);