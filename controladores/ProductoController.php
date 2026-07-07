<?php

require_once "../modelos/Producto.php";

class ProductoController {

    public function crear() {

    session_start();

    if (
        !isset($_SESSION["rol"]) ||
        $_SESSION["rol"] !== "admin"
    ) {

        echo json_encode([
            "success" => false,
            "mensaje" => "Acceso denegado"
        ]);
        return;
    }

    $nombreImagen = null;

    if (
        isset($_FILES["imagen"]) &&
        $_FILES["imagen"]["error"] == 0
    ) {

        $nombreImagen =
            time() . "_" .
            $_FILES["imagen"]["name"];

        move_uploaded_file(
            $_FILES["imagen"]["tmp_name"],
            "../uploads/" . $nombreImagen
        );
    }
    
    $producto = new Producto();

    $resultado = $producto->crear(
        $_POST["nombre"],
        $_POST["categoria"],
        $_POST["precio"],
        $_POST["stock"],
        $_POST["estado"],
        $nombreImagen
    );

    echo json_encode([
        "success" => $resultado
    ]);
}

public function listar() {

    $producto = new Producto();

    $productos = $producto->listar();

    echo json_encode(
        $productos
    );
}
    
public function editar() {

    session_start();

    if (
        !isset($_SESSION["rol"]) ||
        $_SESSION["rol"] !== "admin"
    ) {

        echo json_encode([
            "success" => false,
            "mensaje" => "Acceso denegado"
        ]);

        return;
    }

    $producto = new Producto();

    $resultado = $producto->editar(
        $_POST["id"],
        $_POST["nombre"],
        $_POST["categoria"],
        $_POST["precio"],
        $_POST["stock"],
        $_POST["estado"]
    );

    echo json_encode([
        "success" => $resultado
    ]);
}

public function eliminar() {

    session_start();

    if (
        !isset($_SESSION["rol"]) ||
        $_SESSION["rol"] !== "admin"
    ) {

        echo json_encode([
            "success" => false,
            "mensaje" => "Acceso denegado"
        ]);

        return;
    }

    $producto = new Producto();

    $resultado = $producto->eliminar(
        $_POST["id"]
    );

    echo json_encode([
        "success" => $resultado
    ]);
}
}