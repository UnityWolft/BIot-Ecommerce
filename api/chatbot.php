<?php

header("Content-Type: application/json");

$mensaje = strtolower(trim($_POST["mensaje"] ?? ""));

$respuesta = "Lo siento, no entendí tu pregunta.";

if(strpos($mensaje, "hola") !== false){
    $respuesta = "Hola, bienvenido a BioT Ecommerce la parte de venta de productos de biotransformo 🌱";
}
elseif(strpos($mensaje, "productos") !== false){
    $respuesta = "Puedes ver nuestros productos en la sección Productos.";
}
elseif(strpos($mensaje, "que es biot") !== false){
    $respuesta = "Somos un proyecto de ventas de productos por parte de biotransformo que se especializa en varias areas toda la informacion lo puedes encontrar en contacto dandole click al logo manda a la pagina oficial.";
}
elseif(strpos($mensaje, "envio") !== false){
    $respuesta = "Realizamos envíos a todo México.";
}
elseif(strpos($mensaje, "carrito") !== false){
    $respuesta = "Puedes revisar tu carrito desde el ícono superior.";
}
elseif(strpos($mensaje, "contacto") !== false){
    $respuesta = "Puedes contactarnos desde la sección Contacto.";
}
elseif(strpos($mensaje, "adios") !== false){
    $respuesta = "Hasta Luego que te vaya bien!!!.";
}

echo json_encode([
    "respuesta" => $respuesta
]);