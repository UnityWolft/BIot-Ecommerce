<?php

require_once "../modelos/Pago.php";
require_once "../modelos/Pedido.php";

class PagoController{

    public function crearPreferencia(){

        session_start();

        if(!isset($_SESSION["id"])){

            echo json_encode([
                "success" => false,
                "mensaje" => "Debes iniciar sesión."
            ]);

            return;
        }

        if(!isset($_POST["pedido"])){

            echo json_encode([
                "success" => false,
                "mensaje" => "Pedido inválido."
            ]);

            return;
        }

        $pedidoModel = new Pedido();

        $pedido = $pedidoModel->obtenerPedidoCompleto(
            $_POST["pedido"],
            $_SESSION["id"]
        );

        if(!$pedido){

            echo json_encode([
                "success" => false,
                "mensaje" => "Pedido no encontrado."
            ]);

            return;
        }

        $pago = new Pago();

        $respuesta = $pago->crearPreferencia($pedido);

        if(isset($respuesta["init_point"])){

            echo json_encode([
                "success" => true,
                "url" => $respuesta["init_point"]
            ]);

        }else{

            echo json_encode([
                "success" => false,
                "respuesta" => $respuesta
            ]);

        }

    }

}