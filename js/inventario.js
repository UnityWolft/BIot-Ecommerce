document.addEventListener(
    "DOMContentLoaded",
    () => {

        cargarProductos();
    }
);

document.addEventListener("DOMContentLoaded", async () => {

    const respuesta =
        await fetch("api/verificar_sesion.php");

    const datos =
        await respuesta.json();

    if (!datos.logueado) {

        window.location.href = "login.html";
        return;
    }

    if (datos.rol !== "admin") {

        alert("No tienes permisos para acceder.");
        window.location.href = "index.html";
        return;
    }

});

document
.getElementById("product-form")
.addEventListener(
    "submit",
    guardarProducto
);

async function guardarProducto(e) {
    console.log("ENTRO A GUARDAR PRODUCTO");

    e.preventDefault();

    const id =
        document.getElementById(
            "product-id"
        ).value;

    const formData =
        new FormData();

    formData.append(
        "nombre",
        document.getElementById(
            "product-name"
        ).value
    );

    formData.append(
        "categoria",
        document.getElementById(
            "product-category"
        ).value
    );

    formData.append(
        "precio",
        document.getElementById(
            "product-price"
        ).value
    );

    formData.append(
        "stock",
        document.getElementById(
            "product-stock"
        ).value
    );

    formData.append(
        "estado",
        document.getElementById(
            "product-status"
        ).value
    );
    
    const imagen =
    document.getElementById(
        "product-image"
    ).files[0];

    if(imagen){

    formData.append(
        "imagen", imagen);
    }

    console.log(imagen);

    for (let par of formData.entries()) {
    console.log(par[0], par[1]);
    }
    if (id) {

        formData.append(
            "id",
            id
        );
    }

    const url = id
        ? "api/editar_producto.php"
        : "api/crear_producto.php";

    const respuesta =
        await fetch(
            url,
            {
                method: "POST",
                body: formData
            }
        );

    const datos =
        await respuesta.json();

    if (datos.success) {

        alert(
            id
                ? "Producto actualizado"
                : "Producto registrado"
        );

        document
            .getElementById(
                "product-form"
            )
            .reset();

        document
            .getElementById(
                "product-id"
            )
            .value = "";

        document
            .getElementById(
                "form-title"
            )
            .innerText =
                "Registrar Nuevo Producto";

        document
            .getElementById(
                "btn-cancel"
            )
            .classList.add(
                "hidden"
            );

        cargarProductos();

    } else {

        alert(
            datos.mensaje ||
            "Error al guardar"
        );
    }
}

async function cargarProductos() {

    const respuesta =
        await fetch(
            "api/listar_productos.php"
        );

    const productos =
        await respuesta.json();

    const tabla =
        document.getElementById(
            "table-body"
        );

    tabla.innerHTML = "";

    productos.forEach(producto => {

        tabla.innerHTML += `
            <tr>

                <td>
                    ${producto.id}
                </td>

                <td>
                    ${producto.nombre}
                </td>

                <td>
                    ${producto.categoria}
                </td>

                <td>
                    $${producto.precio}
                </td>

                <td>
                    ${producto.stock}
                </td>

                <td>
                    ${producto.estado}
                </td>

                <td>

    <button
        class="btn-edit"
        onclick="cargarEdicion(
            ${producto.id},
            '${producto.nombre}',
            '${producto.categoria}',
            ${producto.precio},
            ${producto.stock},
            '${producto.estado}'
        )">

        Editar

    </button>

    <button
    class="btn-delete"
    onclick="eliminarProducto(${producto.id})">
    Eliminar
    </button>

</td>

            </tr>
        `;
    });
}

function cargarEdicion(
    id,
    nombre,
    categoria,
    precio,
    stock,
    estado
) {

    document.getElementById(
        "product-id"
    ).value = id;

    document.getElementById(
        "product-name"
    ).value = nombre;

    document.getElementById(
        "product-category"
    ).value = categoria;

    document.getElementById(
        "product-price"
    ).value = precio;

    document.getElementById(
        "product-stock"
    ).value = stock;

    document.getElementById(
        "product-status"
    ).value = estado;

    document.getElementById(
        "form-title"
    ).innerText =
        "Editar Producto";

    document.getElementById(
        "btn-cancel"
    ).classList.remove(
        "hidden"
    );
}

document
.getElementById("btn-cancel")
.addEventListener(
    "click",
    () => {

        document
        .getElementById(
            "product-form"
        )
        .reset();

        document
        .getElementById(
            "product-id"
        )
        .value = "";

        document
        .getElementById(
            "form-title"
        )
        .innerText =
            "Registrar Nuevo Producto";

        document
        .getElementById(
            "btn-cancel"
        )
        .classList.add(
            "hidden"
        );
    });

async function eliminarProducto(id) {

    const confirmar =
        confirm(
            "¿Deseas eliminar este producto?"
        );

    if (!confirmar) return;

    const formData =
        new FormData();

    formData.append(
        "id",
        id
    );

    const respuesta =
        await fetch(
            "api/eliminar_producto.php",
            {
                method: "POST",
                body: formData
            }
        );

    const datos =
        await respuesta.json();

    if (datos.success) {

        alert(
            "Producto eliminado"
        );

        cargarProductos();

    } else {

        alert(
            datos.mensaje ||
            "No se pudo eliminar"
        );
    }
}