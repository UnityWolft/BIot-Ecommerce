<?php

session_start();

header('Content-Type: application/json');

if (!isset($_SESSION["id"])) {

    echo json_encode([
        "success" => false,
        "mensaje" => "Sesión no iniciada"
    ]);

    exit;
}

echo json_encode([
    "success" => true,
    "usuario" => [
        "id" => $_SESSION["id"],
        "nombre" => $_SESSION["nombre"],
        "correo" => $_SESSION["correo"]
    ]
]);