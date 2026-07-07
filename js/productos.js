document.addEventListener(
    "DOMContentLoaded",
    cargarProductos
);

async function cargarProductos() {

    const respuesta =
        await fetch(
            "api/obtener_productos.php"
        );

    const productos =
        await respuesta.json();

    const contenedor =
        document.getElementById(
            "contenedor-productos"
        );

    contenedor.innerHTML = "";

    productos.forEach(producto => {

        if (producto.estado !== "Activo") {
            return;
        }

        const imagen =
            producto.imagen
            ? `uploads/${producto.imagen}`
            : "img/sin-imagen.png";

        contenedor.innerHTML += `
            <div class="producto-card">

                <img
                    src="${imagen}"
                    alt="${producto.nombre}"
                    class="producto-imagen">

                <h3>
                    ${producto.nombre}
                </h3>

                <p>
                    ${producto.categoria}
                </p>

                <h4>
                    $${producto.precio}
                </h4>

                <p>
                    Stock: ${producto.stock}
                </p>

                <button onclick="agregarCarrito(
                 ${producto.id}
                )">
                 Agregar al carrito
                </button>

            </div>
        `;
    });
}

async function agregarCarrito(
    productoId
){

    const formData =
        new FormData();

    formData.append(
        "producto_id",
        productoId
    );

    const respuesta =
        await fetch(
            "api/agregar_carrito.php",
            {
                method: "POST",
                body: formData
            }
        );

    const datos =
        await respuesta.json();

    if(datos.success){

        alert(
            "Producto agregado al carrito"
        );

    }else{

        alert(
            datos.mensaje ||
            "Error al agregar producto"
        );
    }
}