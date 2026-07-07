<?php

session_start();

if(!isset($_SESSION["id"])){
    header("Location: login.html");
    exit();

}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - BioTransformo</title>

    <link rel="stylesheet" href="css/editarp.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<script>

document.addEventListener("DOMContentLoaded", () => {

    const menuToggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("menu");
    const overlay = document.getElementById("overlay");

    menuToggle.addEventListener("click", () => {
        menu.classList.toggle("activo");
        overlay.classList.toggle("activo");
    });

    overlay.addEventListener("click", () => {
        menu.classList.remove("activo");
        overlay.classList.remove("activo");
    });

});

</script>

<body>

  
    <header>

        <!-- MENÚ HAMBURGUESA -->
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>

        <!-- LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="img/biosn.png" alt="BioTransformo">
            </a>
        </div>

        <!-- MENÚ LATERAL -->
        <nav id="menu">
            <ul>
                <li><a href="index.html"><i class="fas fa-home"></i> INICIO</a></li>
                <li><a href="acerca.html"><i class="fas fa-info-circle"></i> ACERCA DE</a></li>
                <li><a href="productos.html"><i class="fas fa-leaf"></i> PRODUCTOS</a></li>
                <li><a href="contac.html"><i class="fas fa-envelope"></i> CONTACTO</a></li>
            </ul>
        </nav>

        <!-- OVERLAY -->
        <div class="overlay" id="overlay"></div>

        <!-- ACCIONES -->
        <div class="acciones">

            <div class="buscar">
                <input type="text" placeholder="Buscar">
                <i class="fas fa-search"></i>
            </div>

            <a href="perfil.php" class="btn-login">
                <i class="fas fa-user"></i>
                Mi Perfil
            </a>

            <a href="carrito.html" class="btn-carrito">
                <i class="fas fa-cart-shopping"></i>
                Carrito
            </a>

        </div>

    </header>

    <main class="perfil-container">

        <div class="perfil-card">

            <div class="perfil-header">

                <img src="img/perfil.png" alt="Usuario">

                <h2>Editar Perfil</h2>

                <p>Actualiza tu información personal</p>

            </div>

            <form id="formPerfil">

                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text"
                        id="nombre"
                        required>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email"
                        id="correo"
                        required>
                </div>
                <div class="form-group">
    <label>Dirección</label>
    <input
        type="text"
        id="direccion"
        name="direccion">
</div>

<div class="form-group">
    <label>Ciudad</label>
    <input
        type="text"
        id="ciudad"
        name="ciudad">
</div>

<div class="form-group">
    <label>Estado</label>
    <input
        type="text"
        id="estado_envio"
        name="estado_envio">
</div>

<div class="form-group">
    <label>Código Postal</label>
    <input
        type="text"
        id="codigo_postal"
        name="codigo_postal">
</div>

<div class="form-group">
    <label>Teléfono</label>
    <input
        type="text"
        id="telefono"
        name="telefono">
</div>

                <hr>

                <h3>Cambiar Contraseña</h3>

                <div class="form-group">
                    <label>Contraseña Actual</label>
                    <input type="password"
                        id="actual"
                        placeholder="Ingresa tu contraseña actual">
                </div>

                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password"
                        id="nueva"
                        placeholder="Nueva contraseña">
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password"
                        id="confirmar"
                        placeholder="Confirma la contraseña">
                </div>

                <div class="perfil-botones">

                      <button type="submit" class="btn-editar">
                        <i class="fas fa-save"></i>&nbsp;&nbsp;
                        Guardar Cambios
                    </button>

                    <a href="perfil.html" class="btn-cerrar">
                        <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </main>
     <footer>

        <div class="copyright">
            COPYRIGHT © 2026 BIOTRANSFORMO
        </div>

        <div class="redes">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>

    </footer>

<script>

document.addEventListener(
    "DOMContentLoaded",
    async () => {

        const respuesta =
            await fetch(
                "api/obtener_perfil.php"
            );

        const datos =
            await respuesta.json();

        if(!datos.success){

            window.location.href =
                "login.html";

            return;
        }

        document.getElementById(
            "nombre"
        ).value = datos.nombre || "";

        document.getElementById(
            "correo"
        ).value = datos.correo || "";

        document.getElementById(
            "direccion"
        ).value = datos.direccion || "";

        document.getElementById(
            "ciudad"
        ).value = datos.ciudad || "";

        document.getElementById(
            "estado_envio"
        ).value = datos.estado_envio || "";

        document.getElementById(
            "codigo_postal"
        ).value = datos.codigo_postal || "";

        document.getElementById(
            "telefono"
        ).value = datos.telefono || "";
    }
);

document
.getElementById("formPerfil")
.addEventListener(
    "submit",
    async function(e){

        e.preventDefault();

        const formData =
            new FormData();

        formData.append(
            "nombre",
            document.getElementById("nombre").value
        );

        formData.append(
            "correo",
            document.getElementById("correo").value
        );

        formData.append(
            "direccion",
            document.getElementById("direccion").value
        );

        formData.append(
            "ciudad",
            document.getElementById("ciudad").value
        );

        formData.append(
            "estado_envio",
            document.getElementById("estado_envio").value
        );

        formData.append(
            "codigo_postal",
            document.getElementById("codigo_postal").value
        );

        formData.append(
            "telefono",
            document.getElementById("telefono").value
        );

        const respuesta =
            await fetch(
                "api/actualizar_perfil.php",
                {
                    method: "POST",
                    body: formData
                }
            );

        const datos =
            await respuesta.json();

        if(!datos.success){

            alert(datos.mensaje);
            return;
        }

        const actual =
            document.getElementById("actual").value;

        const nueva =
            document.getElementById("nueva").value;

        const confirmar =
            document.getElementById("confirmar").value;

        if(
            actual !== "" &&
            nueva !== "" &&
            confirmar !== ""
        ){

            const passwordData =
                new FormData();

            passwordData.append(
                "actual",
                actual
            );

            passwordData.append(
                "nueva",
                nueva
            );

            passwordData.append(
                "confirmar",
                confirmar
            );

            const respuestaPassword =
                await fetch(
                    "api/cambiar_password.php",
                    {
                        method: "POST",
                        body: passwordData
                    }
                );

            const datosPassword =
                await respuestaPassword.json();

            if(!datosPassword.success){

                alert(
                    datosPassword.mensaje
                );

                return;
            }
        }

        alert(
            "Perfil actualizado correctamente"
        );

        window.location.href =
            "perfil.php";
    }
);

</script>   
</body>

</html>