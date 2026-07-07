<?php

require_once "../modelos/Pedido.php";

class PedidoController {

public function crear(){


session_start();

if(!isset($_SESSION["id"])){

    echo json_encode([
        "success" => false,
        "mensaje" => "Debes iniciar sesión"
    ]);

    return;
}

$pedido = new Pedido();

$pedidoId = $pedido->crearPedido(
    $_SESSION["id"]
);

if($pedidoId){

    echo json_encode([
        "success" => true,
        "pedido_id" => $pedidoId
    ]);

}else{

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo crear el pedido"
    ]);
}


}

    public function obtener(){

    session_start();

    if(!isset($_SESSION["id"])){

        echo json_encode([]);
        return;
    }

    $pedido = new Pedido();

    echo json_encode(
        $pedido->obtenerPedidos(
            $_SESSION["id"]
        )
    );
}
public function detalle(){

    session_start();

    if(!isset($_SESSION["id"])){

        echo json_encode([]);
        return;
    }

    $pedido = new Pedido();

    echo json_encode(
        $pedido->obtenerDetalle(
            $_GET["pedido_id"],
            $_SESSION["id"]
        )
    );
}
}