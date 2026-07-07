document.addEventListener("DOMContentLoaded", async () => {

    try {

        const respuesta = await fetch("api/perfil.php");

        const datos = await respuesta.json();

        if (!datos.success) {

            window.location.href = "login.html";
            return;
        }

        document.getElementById("nombreUsuario")
            .textContent = datos.usuario.nombre;

        document.getElementById("correoUsuario")
            .textContent = datos.usuario.correo;

        document.getElementById("nombreCompleto")
            .textContent = datos.usuario.nombre;

        document.getElementById("correoCompleto")
            .textContent = datos.usuario.correo;

    } catch (error) {

        console.error(error);

        alert("Error al cargar el perfil");
    }
    const btnCerrar = document.querySelector(".btn-cerrar");

    btnCerrar.addEventListener("click", async (e) => {

    e.preventDefault();

    await fetch("api/logout.php");

    window.location.href = "login.html";

});

});
async function cargarPedidos(){

    const respuesta =
        await fetch(
            "api/obtener_pedidos.php"
        );

    const pedidos =
        await respuesta.json();

    const contenedor =
        document.getElementById(
            "lista-pedidos"
        );

    contenedor.innerHTML = "";

    if(pedidos.length === 0){

        contenedor.innerHTML = `
            <p>
                No tienes pedidos todavía.
            </p>
        `;

        return;
    }

    pedidos.forEach(pedido => {

        contenedor.innerHTML += `

        <div class="pedido">

    <span>
        Pedido #${pedido.id}
    </span>

    <strong>
        $${pedido.total}
    </strong>

    <button
        onclick="verDetalle(${pedido.id})">

        Ver Productos

    </button>

</div>

<div
    id="detalle-${pedido.id}"
    class="detalle-pedido">

</div>

        <small>
            Estado:
            ${pedido.estado}
            <br>
            ${pedido.fecha}
        </small>
        <a
            href="pago.php?id=${pedido.id}"
            class="btn-pagar">

            Pagar

        </a>

        `;
    });
}

cargarPedidos();

async function verDetalle(pedidoId){

    const contenedor =
        document.getElementById(
            `detalle-${pedidoId}`
        );

    if(contenedor.innerHTML !== ""){

        contenedor.innerHTML = "";
        return;
    }

    const respuesta =
        await fetch(
            `api/detalle_pedido.php?pedido_id=${pedidoId}`
        );

    const productos =
        await respuesta.json();

    productos.forEach(producto => {

        const imagen =
            producto.imagen
            ? `uploads/${producto.imagen}`
            : "img/sin-imagen.png";

        contenedor.innerHTML += `

        <div class="producto-pedido">

            <img
                src="${imagen}"
                width="60">

            <div>

                <strong>
                    ${producto.nombre}
                </strong>

                <p>
                    Cantidad:
                    ${producto.cantidad}
                </p>

                <p>
                    Precio:
                    $${producto.precio}
                </p>

            </div>

        </div>

        `;
    });
}
