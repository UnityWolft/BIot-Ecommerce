<?php

require_once "../config/mercadopago.php";
require_once "../modelos/Pedido.php";

$input = file_get_contents("php://input");

$evento = json_decode($input, true);

if (
    !isset($evento["type"]) ||
    $evento["type"] != "payment"
){
    http_response_code(200);
    exit;
}

$paymentId = $evento["data"]["id"];

/*
Consultar el pago directamente
a Mercado Pago
*/

$url = "https://api.mercadopago.com/v1/payments/".$paymentId;

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_HTTPHEADER, [

    "Authorization: Bearer ".MP_ACCESS_TOKEN

]);

$respuesta = curl_exec($curl);

curl_close($curl);

$pago = json_decode($respuesta, true);


if($pago["status"] != "approved"){

    http_response_code(200);
    exit;
}
$pedidoId = $pago["external_reference"];

$paymentId = $pago["id"];

$metodo = $pago["payment_method_id"];

$monto = $pago["transaction_amount"];

$estado = $pago["status"];$pedidoId = $pago["external_reference"];

$paymentId = $pago["id"];

$metodo = $pago["payment_method_id"];

$monto = $pago["transaction_amount"];

$estado = $pago["status"];

if($pago["status"] != "approved"){

    http_response_code(200);
    exit;
}

$pedidoId = $pago["external_reference"];

$pedido = new Pedido();

$pedido->guardarPago(

    $pedidoId,
    $paymentId,
    $metodo,
    $monto,
    $estado

);

$pedido->marcarComoPagado($pedidoId);

http_response_code(200);

echo "OK";