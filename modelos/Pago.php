<?php

require_once __DIR__ . "/../config/mercadopago.php";

class Pago{

    public function crearPreferencia($pedido){

        $url = "https://api.mercadopago.com/checkout/preferences";

       $datos = [

    "items" => [
        [
            "title" => "Pedido BioTransformo #".$pedido["id"],
            "quantity" => 1,
            "currency_id" => "MXN",
            "unit_price" => (float)$pedido["total"]
        ]
    ],

    "back_urls" => [
        "success" => "https://biot-ecommerce.biotransformo.com/pago_exitoso.php",
        "failure" => "https://biot-ecommerce.biotransformo.com/pago_error.php",
        "pending" => "https://biot-ecommerce.biotransformo.com/pago_pendiente.php"
    ],

    "auto_return" => "approved",

"external_reference" => $pedido["id"],

"notification_url" => "https://biot-ecommerce.biotransformo.com/api/webhook.php",

];
        

        $curl = curl_init($url);

        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        curl_setopt($curl,CURLOPT_POST,true);

        curl_setopt($curl,CURLOPT_HTTPHEADER,[

            "Authorization: Bearer ".MP_ACCESS_TOKEN,

            "Content-Type: application/json"

        ]);

        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($datos));

        $respuesta = curl_exec($curl);

        curl_close($curl);

        return json_decode($respuesta,true);

    }

}