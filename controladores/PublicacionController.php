<?php

require_once "../modelos/Publicacion.php";

class PublicacionController {

    public function crear() {

    session_start();

    if (!isset($_SESSION["id"])) {

        echo json_encode([
            "success" => false,
            "mensaje" => "Debes iniciar sesión"
        ]);

        return;
    }

    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];

    $modelo = new Publicacion();

    $resultado = $modelo->crear(
        $_SESSION["id"],
        $titulo,
        $contenido
    );

    if($resultado){

        echo json_encode([
            "success" => true,
            "mensaje" => "Publicación creada correctamente"
        ]);

    }else{

        echo json_encode([
            "success" => false,
            "mensaje" => "Error al crear la publicación"
        ]);
    }
}

    public function listar() {

    session_start();

    require_once "../modelos/Publicacion.php";

    $publicacion = new Publicacion();

    $lista = $publicacion->listar();

    echo json_encode([
        "usuarioActual" => $_SESSION["id"] ?? null,
        "publicaciones" => $lista
    ]);
}
public function eliminar() {

    session_start();

    if (!isset($_SESSION["id"])) {

        echo json_encode([
            "success" => false
        ]);

        return;
    }

    $modelo =
        new Publicacion();

    $resultado =
        $modelo->eliminar(
            $_POST["id"],
            $_SESSION["id"]
        );

    echo json_encode([
        "success" => $resultado
    ]);
}
public function editar($id, $titulo, $contenido, $id_usuario) {

    $sql = "UPDATE publicaciones
            SET titulo = :titulo,
                contenido = :contenido
            WHERE id = :id
            AND id_usuario = :id_usuario";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ":id" => $id,
        ":titulo" => $titulo,
        ":contenido" => $contenido,
        ":id_usuario" => $id_usuario
    ]);
}
public function actualizar() {

    session_start();

    if (!isset($_SESSION["id"])) {

        echo json_encode([
            "success" => false
        ]);

        return;
    }

    $modelo = new Publicacion();

    $resultado = $modelo->editar(
        $_POST["id"],
        $_POST["titulo"],
        $_POST["contenido"],
        $_SESSION["id"]
    );

    echo json_encode([
        "success" => $resultado
    ]);
}
}