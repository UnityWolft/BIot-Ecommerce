<?php

require_once "../modelos/Carrito.php";

class CarritoController {

    public function agregar() {

        session_start();

        if(!isset($_SESSION["id"])){

            echo json_encode([
                "success" => false,
                "mensaje" => "Debes iniciar sesión"
            ]);

            return;
        }

        $carrito = new Carrito();

        $resultado = $carrito->agregar(
            $_SESSION["id"],
            $_POST["producto_id"]
        );

        echo json_encode([
    "success" => $resultado,
    "usuario" => $_SESSION["id"],
    "producto" => $_POST["producto_id"]
]);
    }
    public function obtener(){

    session_start();

    if(!isset($_SESSION["id"])){

        echo json_encode([]);
        return;
    }

    $carrito = new Carrito();

    echo json_encode(
        $carrito->obtenerCarrito(
            $_SESSION["id"]
        )
    );
}
public function eliminar(){

    session_start();

    if(!isset($_SESSION["id"])){

        echo json_encode([
            "success" => false
        ]);

        return;
    }

    $carrito = new Carrito();

    $resultado = $carrito->eliminar(
        $_POST["id"],
        $_SESSION["id"]
    );

    echo json_encode([
        "success" => $resultado
    ]);
}
public function aumentar(){

    session_start();

    $carrito = new Carrito();

    $resultado = $carrito->aumentarCantidad(
        $_POST["id"],
        $_SESSION["id"]
    );

    echo json_encode([
        "success" => $resultado
    ]);
}

public function disminuir(){

    session_start();

    $carrito = new Carrito();

    $resultado = $carrito->disminuirCantidad(
        $_POST["id"],
        $_SESSION["id"]
    );

    echo json_encode([
        "success" => $resultado
    ]);
}
}