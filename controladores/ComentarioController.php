<?php

require_once "../modelos/Comentario.php";

class ComentarioController {

    public function crear() {

        session_start();

        if (!isset($_SESSION["id"])) {

            echo json_encode([
                "success" => false,
                "mensaje" => "Debes iniciar sesión"
            ]);

            return;
        }

        $modelo = new Comentario();

        $resultado = $modelo->crear(
            $_POST["id_publicacion"],
            $_SESSION["id"],
            $_POST["comentario"]
        );

        echo json_encode([
            "success" => $resultado
        ]);
    }

    public function listar() {

        $modelo = new Comentario();

        $comentarios = $modelo->listarPorPublicacion(
            $_GET["id_publicacion"]
        );

        echo json_encode($comentarios);
    }

    public function eliminar() {

        session_start();

        if (!isset($_SESSION["id"])) {

            echo json_encode([
                "success" => false,
                "mensaje" => "Debes iniciar sesión"
            ]);

            return;
        }

        $modelo = new Comentario();

        $resultado = $modelo->eliminar(
            $_POST["id"],
            $_SESSION["id"]
        );

        echo json_encode([
            "success" => $resultado
        ]);
    }
}