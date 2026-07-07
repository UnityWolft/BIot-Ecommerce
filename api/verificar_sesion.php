<?php

session_start();

echo json_encode([
    "logueado" => isset($_SESSION["id"]),
    "id" => $_SESSION["id"] ?? null,
    "nombre" => $_SESSION["nombre"] ?? null,
    "rol" => $_SESSION["rol"] ?? null
]);