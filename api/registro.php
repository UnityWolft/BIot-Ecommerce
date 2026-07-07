<?php
header('Content-Type: application/json');
require_once "../controladores/UsuarioController.php";

$controller = new UsuarioController();
$controller->registrar();