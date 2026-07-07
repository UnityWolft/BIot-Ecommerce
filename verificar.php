<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/modelos/Usuario.php";

$token = $_GET["token"] ?? "";

if (empty($token)) {
    die("<h1>❌ Token inválido</h1>");
}

$usuario = new Usuario();

$resultado = $usuario->verificarCuenta($token);

if ($resultado === true) {

    echo "
    <h1>✅ Cuenta verificada correctamente</h1>
    <p>Ya puedes iniciar sesión.</p>
    <a href='login.html'>Ir al Login</a>
    ";

} elseif ($resultado === "ya_verificado") {

    echo "
    <h1>⚠️ Esta cuenta ya estaba verificada</h1>
    <p>Ya puedes iniciar sesión normalmente.</p>
    <a href='login.html'>Ir al Login</a>
    ";

} else {

    echo "
    <h1>✅ Cuenta verificada correctamente</h1>
    <p>Ya puedes iniciar sesión.</p>
    <a href='login.html'>Ir al Login</a>
    ";
}
?>