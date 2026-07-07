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
    <title>Mi Perfil - BioTransformo</title>

    <link rel="stylesheet" href="css/perfil.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
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
                <li><a href="Foro.html"><i class="fas fa-comments"></i> FORO</a></li>
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

            <a href="perfil.html" class="btn-login">
                <i class="fas fa-user"></i>
                Mi Perfil
            </a>

            <a href="carrito.html" class="btn-carrito">
                <i class="fas fa-cart-shopping"></i>
                Carrito
            </a>
             <a href="api/logout.php" class="btn-cerrar">Cerrar Sesión</a>

        </div>

    </header>

    <!-- CONTENIDO PERFIL -->

    <main class="perfil-container">

        <div class="perfil-card">

            <div class="perfil-header">

                <img src="img/perfil.png" alt="Usuario">

                <h2 id="nombreUsuario">Usuario</h2>

                <p id="correoUsuario">correo@ejemplo.com</p>

            </div>

            <div class="perfil-info">

                <div class="dato">
                    <i class="fas fa-user"></i>
                    <span id="nombreCompleto">
                        Nombre del Usuario
                    </span>
                </div>

                <div class="dato">
                    <i class="fas fa-envelope"></i>
                    <span id="correoCompleto">
                        correo@ejemplo.com
                    </span>
                </div>

               <div class="dato">
                 <i class="fas fa-location-dot"></i>
                 <span id="direccionUsuario"></span>
                </div>

            </div>

            <div class="perfil-botones">

                <a href="editarp.php" class="btn-editar">
                    <i class="fas fa-pencil"></i>&nbsp;&nbsp;
                    Editar Perfil
                </a>

               

            </div>

        </div>

        <div class="pedidos-card">

         <h3>Mis Pedidos</h3>

         <div id="lista-pedidos">

        </div>
        </div>

    </main>
<br>
<br>
<br>
<br>
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
    <script src="js/perfil.js"></script>
</body>

</html>