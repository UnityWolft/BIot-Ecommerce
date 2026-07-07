    <?php
session_start();

if(!isset($_SESSION["id"])){
    header("Location: login.html");
    exit;
}

require_once __DIR__ . "/modelos/Pedido.php";

$pedidoId = $_GET["id"] ?? 0;

$pedidoModel = new Pedido();

// 🔥 USAR MÉTODOS QUE YA EXISTEN EN TU MVC
$productos = $pedidoModel->obtenerDetalle(
    $pedidoId,
    $_SESSION["id"]
);

// traer datos del pedido
$pedido = $pedidoModel->obtenerPedidoCompleto(
    $pedidoId,
    $_SESSION["id"]
);


if(!$pedido){
    die("Pedido no encontrado");
}
?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pago | BioTransformo</title>

<link rel="stylesheet" href="css/pago.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

    <!-- BOTÓN HAMBURGUESA -->
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
<div class="contenedor-pago">

    <!-- ENCABEZADO -->
    <div class="encabezado">

    <div class="titulo-pago">

        <div class="icono">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <div class="texto">

            <h1>Confirmar Compra</h1>

            <p>Pedido #<?= $pedido["id"] ?></p>

        </div>

    </div>

</div>

    <div class="grid-pago">

        <!-- IZQUIERDA -->
        <div class="columna">

            <div class="card direccion-card">

                <h2>
                    <i class="fa-solid fa-location-dot"></i>
                    Dirección de Entrega
                </h2>

                <div class="dato">
                    <i class="fa-solid fa-user"></i>
                    <div>
                        <small>Cliente</small>
                        <strong><?= $pedido["nombre"] ?></strong>
                    </div>
                </div>

                <div class="dato">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <small>Correo</small>
                        <strong><?= $pedido["correo"] ?></strong>
                    </div>
                </div>

                <div class="dato">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <small>Teléfono</small>
                        <strong><?= $pedido["telefono"] ?></strong>
                    </div>
                </div>

                <div class="dato">
                    <i class="fa-solid fa-road"></i>
                    <div>
                        <small>Dirección</small>
                        <strong><?= $pedido["direccion"] ?></strong>
                    </div>
                </div>

                <div class="dato">
                    <i class="fa-solid fa-city"></i>
                    <div>
                        <small>Ciudad</small>
                        <strong><?= $pedido["ciudad"] ?></strong>
                    </div>
                </div>

                <div class="dato">
                    <i class="fa-solid fa-map"></i>
                    <div>
                        <small>Estado</small>
                        <strong><?= $pedido["estado_envio"] ?></strong>
                    </div>
                </div>

                <div class="dato">
                    <i class="fa-solid fa-mail-bulk"></i>
                    <div>
                        <small>Código Postal</small>
                        <strong><?= $pedido["codigo_postal"] ?></strong>
                    </div>
                </div>

            </div>

        </div>

        <!-- DERECHA -->
        <div class="columna">

            <div class="card resumen-card">

                <h2>
                    <i class="fa-solid fa-cart-shopping"></i>
                    Resumen del Pedido
                </h2>

                <?php foreach($productos as $producto): ?>

                    <div class="producto">

                        <div class="producto-info">

                            <strong>
                                <?= $producto["nombre"]; ?>
                            </strong>

                            <small>
                                Cantidad:
                                <?= $producto["cantidad"]; ?>
                            </small>

                        </div>

                        <div class="producto-precio">

                            $
                            <?= number_format(
                                $producto["precio"] * $producto["cantidad"],
                                2
                            ); ?>

                        </div>

                    </div>

                <?php endforeach; ?>

                <hr>

                <div class="total">

                    <span>Total a pagar</span>

                    <span>

                        $

                        <?= number_format(
                            $pedido["total"],
                            2
                        ); ?>

                    </span>

                </div>

            </div>

            <div class="card metodo-pago">

                <h2>
                    <i class="fa-solid fa-credit-card"></i>
                    Método de Pago
                </h2>

                <div class="opciones-pago">

                    <label class="opcion-pago">

                        <input
                            type="radio"
                            name="metodo"
                            value="debito"
                            checked>

                        <div class="contenido-pago">

                            <i class="fa-solid fa-credit-card"></i>

                            <div>

                                <strong>Tarjeta Débito</strong>

                                <small>
                                    Visa • Mastercard
                                </small>

                            </div>

                        </div>

                    </label>

                    <label class="opcion-pago">

                        <input
                            type="radio"
                            name="metodo"
                            value="credito">

                        <div class="contenido-pago">

                            <i class="fa-solid fa-wallet"></i>

                            <div>

                                <strong>Tarjeta Crédito</strong>

                                <small>
                                    Hasta 12 meses
                                </small>

                            </div>

                        </div>

                    </label>

                    <label class="opcion-pago">

                        <input
                            type="radio"
                            name="metodo"
                            value="bbva">

                        <div class="contenido-pago">

                            <i class="fa-solid fa-building-columns"></i>

                            <div>

                                <strong>Transferencia BBVA</strong>

                                <small>
                                    SPEI
                                </small>

                            </div>

                        </div>

                    </label>

                </div>

                <button
                 id="btnPagar"
                  data-pedido="<?= $pedido["id"]; ?>"
                  class="btn-pagar">
                <i class="fa-solid fa-lock"></i>
                 Confirmar Pago Seguro

    </button>

            </div>

        </div>

    </div>

</div>
<footer>
 <br>
  <br>
   <br>
    <br>
    <div class="copyright">
        COPYRIGHT © 2026 BIOTRANSFORMO
    </div>

    <div class="redes">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
    </div>

</footer>
<script src="js/pago.js"></script>
<script src="js/protegerAdmin.js"></script>
<script src="js/sesion.js"></script>

</body>
</html>
