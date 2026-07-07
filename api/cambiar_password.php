<?php

session_start();

require_once "../modelos/Usuario.php";

if(!isset($_SESSION["id"])){

    echo json_encode([
        "success" => false,
        "mensaje" => "Debes iniciar sesión"
    ]);

    exit;
}

$actual =
    $_POST["actual"];

$nueva =
    $_POST["nueva"];

$confirmar =
    $_POST["confirmar"];

if($nueva !== $confirmar){

    echo json_encode([
        "success" => false,
        "mensaje" => "Las contraseñas no coinciden"
    ]);

    exit;
}

$usuario = new Usuario();

$datos =
    $usuario->obtenerUsuarioCompleto(
        $_SESSION["id"]
    );

if(
    !password_verify(
        $actual,
        $datos["password"]
    )
){

    echo json_encode([
        "success" => false,
        "mensaje" => "La contraseña actual es incorrecta"
    ]);

    exit;
}

$passwordNueva =
    password_hash(
        $nueva,
        PASSWORD_DEFAULT
    );

$resultado =
    $usuario->actualizarPassword(
        $_SESSION["id"],
        $passwordNueva
    );

echo json_encode([
    "success" => $resultado
]);