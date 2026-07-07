<?php

session_start();

if(
    !isset($_SESSION["rol"]) ||
    $_SESSION["rol"] !== "admin"
){

    header(
        "Location: index.html"
    );

    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BioTransformo</title>

        <link rel="stylesheet" href="css/estilo.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="css/status.css">
    </head>



    <body>

        <header>

            <!-- MENU HAMBURGUESA -->
            <div class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>

            <div class="logo">
                <a href="index.html">
                    <img src="img/biosn.png" alt="BioTransformo">
                </a>
            </div>
            <!-- MENU OCULTO -->
            <nav id="menu">
                <ul>
                    <li><a href="index.html"><i class="fas fa-home"></i> INICIO</a></li>
                    <li><a href="acerca.html"><i class="fas fa-info-circle"></i> ACERCA DE</a></li>
                    <li><a href="productos.html"><i class="fas fa-leaf"></i> PRODUCTOS</a></li>
                    <li><a href="Foro.html"><i class="fas fa-comments"></i> FORO</a></li>
                    <li><a href="contac.html"><i class="fas fa-envelope"></i> CONTACTO</a></li>
                    <li><a href="status.php"><i class="fa-solid fa-truck"></i> STATUS</a></li>
                </ul>
            </nav>

            <!-- FONDO OSCURO -->
            <div class="overlay" id="overlay"></div>

            <!-- ACCIONES -->
            <div class="acciones">

                <div class="buscar">
                    <input type="text" placeholder="Buscar">
                    <i class="fas fa-search"></i>
                </div>

                <a href="login.html" class="btn-login" id="btnLogin">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </a>

                <a href="registro.html" class="btn-registro" id="btnRegistro">
                    <i class="fas fa-user-plus"></i>
                    Registro
                </a>
                <a href="perfil.php" class="btn-login" id="btnPerfil" style="display:none;">
                    <i class="fas fa-user"></i>
                    Mi Perfil
                </a>

                <a href="carrito.html" class="btn-carrito">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Carrito
                </a>

            </div>

        </header>

<main class="status-container">

    <h1 class="titulo-status">
        Panel de Administración de Pedidos
    </h1>

    <div id="lista-pedidos">

        <p>Cargando pedidos...</p>

    </div>

</main>


        <script>
            function toggleStatusModal() {
                const modal = document.getElementById('statusModal');
                modal.classList.toggle('show');
            }
        </script>
        <footer>

            <div class="copyright">
                COPYRIGHT © 2026 BIOTRANSFORMO
            </div>

            <div class="redes">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <br>
            <br>
            <br>
        </footer>
        <!-- BOTÓN CHAT -->
        <div id="chat-toggle" onclick="toggleChat()">
            🌱
        </div>

        <!-- CHATBOT -->
        <div id="chatbot" class="chat-minimizado">

            <div id="chat-header">

                <span>
                    🌱 BioBot
                </span>

                <button onclick="toggleChat()">
                    −
                </button>

            </div>

            <div id="chat-body">

                <div class="bot">
                    Hola 👋 Soy tu chatbot personal de BioTransformo.
                    ¿En qué puedo ayudarte?
                </div>

            </div>

            <div id="chat-footer">

                <input type="text" id="mensaje" placeholder="Escribe tu pregunta">

                <button onclick="enviarMensaje()">
                    Enviar
                </button>

            </div>

        </div>

        <script>

document.addEventListener("DOMContentLoaded", () => {

    cargarPedidos();

});

async function cargarPedidos(){

    try{

        const respuesta =
            await fetch("api/admin_pedidos.php");

        const pedidos =
            await respuesta.json();

        const contenedor =
            document.getElementById("lista-pedidos");

        contenedor.innerHTML = "";

        pedidos.forEach(pedido => {

            contenedor.innerHTML += `

                <div class="pedido-card">

                    <h3>Pedido #${pedido.id}</h3>

                    <p>
                        <strong>Cliente:</strong>
                        ${pedido.nombre}
                    </p>

                    <p>
                        <strong>Correo:</strong>
                        ${pedido.correo}
                    </p>

                    <p>
                        <strong>Teléfono:</strong>
                        ${pedido.telefono || "No registrado"}
                    </p>

                    <hr>

                    <p>
                        <strong>Dirección:</strong>
                        ${pedido.direccion}
                    </p>

                    <p>
                        <strong>Ciudad:</strong>
                        ${pedido.ciudad}
                    </p>

                    <p>
                        <strong>Estado:</strong>
                        ${pedido.estado_envio}
                    </p>

                    <p>
                        <strong>C.P:</strong>
                        ${pedido.codigo_postal}
                    </p>

                    <hr>

                    <p>
                        <strong>Total:</strong>
                        $${pedido.total}
                    </p>

                    <p>
                        <strong>Fecha:</strong>
                        ${pedido.fecha}
                    </p>

                    <p>
                        <strong>Estado del pedido:</strong>
                        ${pedido.estado}
                    </p>

                    <select onchange="actualizarEstado(${pedido.id}, this.value)">

                        <option value="Pendiente"
                        ${pedido.estado === "Pendiente" ? "selected" : ""}>
                            Pendiente
                        </option>

                        <option value="En Camino"
                        ${pedido.estado === "En Camino" ? "selected" : ""}>
                            En Camino
                        </option>

                        <option value="Entregado"
                        ${pedido.estado === "Entregado" ? "selected" : ""}>
                            Entregado
                        </option>

                    </select>

                    <button class="btn-eliminar"
                        onclick="eliminarPedido(${pedido.id})">

                        Eliminar Pedido

                    </button>

                </div>

            `;
        });

    }catch(error){

        console.error("Error cargando pedidos:", error);

    }
}

async function actualizarEstado(id, estado){

    const datos = new FormData();

    datos.append("id", id);
    datos.append("estado", estado);

    await fetch("api/actualizar_estado.php",{

        method:"POST",
        body:datos

    });

    cargarPedidos();
}
async function eliminarPedido(id){

    if(!confirm("¿Deseas eliminar este pedido?")){
        return;
    }

    const datos = new FormData();

    datos.append("id", id);

    const respuesta =
        await fetch(
            "api/eliminar_pedido.php",
            {
                method:"POST",
                body:datos
            }
        );

    const resultado =
        await respuesta.json();

    if(resultado.success){

        alert("Pedido eliminado");

        cargarPedidos();

    }else{

        alert("Error al eliminar");

    }
}

</script>

        <script>

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
        </script>
        
        <script src="js/sesion.js"></script>
        <script src="js/permisos.js"></script>
        <script src="js/chatbot.js"></script>

    </body>

    </html>