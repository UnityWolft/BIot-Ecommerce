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
    <title>BioT - Panel de Inventario</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/inventario.css">
</head>

<body>

    <header>

      
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>

      
        <div class="logo">
            <a href="index.html">
                <img src="img/biosn.png" alt="BioTransformo">
            </a>
        </div>

        
        <nav id="menu">
            <ul>
                <li><a href="index.html"><i class="fas fa-home"></i> INICIO</a></li>
                <li><a href="acerca.html"><i class="fas fa-info-circle"></i> ACERCA DE</a></li>
                <li><a href="productos.html"><i class="fas fa-leaf"></i> PRODUCTOS</a></li>
                <li><a href="contac.html"><i class="fas fa-envelope"></i> CONTACTO</a></li>
            </ul>
        </nav>

        <div class="overlay" id="overlay"></div>

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

    <div class="admin-container">

        <header class="admin-header">
            <div class="logo-area">
                <small>Panel de Inventario Ecológico</small>
            </div>

            <button class="btn-back" onclick="window.location.href='index.html'">
                ← Volver a la Tienda
            </button>
        </header>

        <main class="admin-content">

          
            <section class="form-section">

                <h2 id="form-title">Registrar Nuevo Producto</h2>

                <form id="product-form">

                    <input type="hidden" id="product-id">

                    <div class="form-group">
                        <label for="product-name">Nombre del Producto</label>
                        <input type="text" id="product-name"
                            placeholder="Ej. Cepillo de Bambú" required>
                    </div>
                    
                    
                    <div class="form-group">
                    <label>Imagen del Producto</label>
                    <input type="file" 
                    id="product-image" 
                    accept="image/*">
                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label for="product-category">Categoría</label>
                            <select id="product-category" required>
                                <option value="">Selecciona...</option>
                                <option value="Hogar">Hogar Sustentable</option>
                                <option value="Cuidado Personal">Cuidado Personal</option>
                                <option value="Empaques">Empaques Biodegradables</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product-price">Precio ($)</label>
                            <input type="number" id="product-price"
                                step="0.01" placeholder="0.00" required>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label for="product-stock">Stock Inicial</label>
                            <input type="number" id="product-stock"
                                placeholder="Cantidad" required>
                        </div>

                        <div class="form-group">
                            <label for="product-status">Estado</label>
                            <select id="product-status">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-buttons">
                        <button type="submit"
                            class="btn-action btn-save">
                            Guardar Producto
                        </button>

                        <button type="button"
                            id="btn-cancel"
                            class="btn-action btn-cancel hidden">
                            Cancelar Edición
                        </button>
                    </div>

                </form>

            </section>

            
            <section class="table-section">

                <div class="table-header">
                    <h2>Inventario de Productos</h2>

                    <div class="search-box">
                        <input type="text"
                            id="search-input"
                            placeholder="Buscar producto o categoría...">
                    </div>
                </div>

                <div class="table-responsive">

                    <table id="products-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody id="table-body"></tbody>

                    </table>

                </div>

            </section>

        </main>

    </div>
   
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

 
<script src="js/protegerAdmin.js"></script>
<script src="js/sesion.js"></script>
<script src="js/inventario.js?v=123"></script>

</body>

</html>