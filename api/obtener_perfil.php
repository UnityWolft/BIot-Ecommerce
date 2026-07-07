<?php

session_start();

require_once "../modelos/Usuario.php";

if(!isset($_SESSION["id"])){

    echo json_encode([
        "success" => false
    ]);

    exit;
}

$usuario = new Usuario();

$datos = $usuario->obtenerPorId(
    $_SESSION["id"]
);

echo json_encode([
    "success" => true,
    "nombre" => $datos["nombre"],
    "correo" => $datos["correo"],
    "direccion" => $datos["direccion"],
    "ciudad" => $datos["ciudad"],
    "estado_envio" => $datos["estado_envio"],
    "codigo_postal" => $datos["codigo_postal"],
    "telefono" => $datos["telefono"]
]);