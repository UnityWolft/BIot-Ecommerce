<?php

require_once "modelos/Pago.php";

$pago = new Pago();

$resultado = $pago->crearPreferencia([

    "id"=>1,

    "total"=>100

]);

echo "<pre>";

print_r($resultado);

echo "</pre>";