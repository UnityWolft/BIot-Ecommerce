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

$usuario = new Usuario();

$resultado = $usuario->actualizarPerfil(
    $_SESSION["id"],
    $_POST["nombre"],
    $_POST["correo"],
    $_POST["direccion"],
    $_POST["ciudad"],
    $_POST["estado_envio"],
    $_POST["codigo_postal"],
    $_POST["telefono"]
);

if($resultado){

    $_SESSION["nombre"] =
        $_POST["nombre"];

    $_SESSION["correo"] =
        $_POST["correo"];

    echo json_encode([
        "success" => true
    ]);

}else{

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo actualizar"
    ]);
}