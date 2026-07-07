document.addEventListener("DOMContentLoaded", () => {

    cargarPublicaciones();

    document
        .getElementById("btnPublicar")
        .addEventListener("click", publicar);
});

let usuarioActual = null;
// =======================
// 📌 PUBLICAR
// =======================
async function publicar() {

    const titulo = document.getElementById("tituloPublicacion").value;
    const contenido = document.getElementById("contenidoPublicacion").value;

    if (!titulo || !contenido) {
        alert("Completa todos los campos");
        return;
    }

    const formData = new FormData();
    formData.append("titulo", titulo);
    formData.append("contenido", contenido);

    const respuesta = await fetch("api/crear_publicacion.php", {
        method: "POST",
        body: formData
    });

    const datos = await respuesta.json();

    alert(datos.mensaje);

    if (datos.success) {
        document.getElementById("tituloPublicacion").value = "";
        document.getElementById("contenidoPublicacion").value = "";
        cargarPublicaciones();
    }
}


// =======================
// 📌 CARGAR PUBLICACIONES
// =======================
async function cargarPublicaciones() {

    const respuesta = await fetch("api/listar_publicaciones.php");
    const datos = await respuesta.json();

    const publicaciones = Array.isArray(datos.publicaciones)
        ? datos.publicaciones
        : [];

    usuarioActual = datos.usuarioActual;

    const contenedor = document.getElementById("contenedorPublicaciones");

    if (!contenedor) return;

    contenedor.innerHTML = "";

    if (publicaciones.length === 0) {
        contenedor.innerHTML = "<p>No hay publicaciones aún</p>";
        return;
    }

    publicaciones.forEach(publicacion => {

        let botones = "";

        // SOLO SI ES EL DUEÑO
        if (usuarioActual == publicacion.id_usuario) {

            botones = `
                <div class="acciones-publicacion">

                    <button onclick="editarPublicacion(
                        ${publicacion.id},
                        '${escapeQuotes(publicacion.titulo)}',
                        \`${escapeBackticks(publicacion.contenido)}\`
                    )">
                        <i class="fas fa-pen"></i> Editar
                    </button>

                    <button onclick="eliminarPublicacion(${publicacion.id})">
                       <i class="fas fa-trash"></i> Eliminar
                    </button>

                </div>
            `;
        }

        contenedor.innerHTML += `
            <article class="tema">

                <div class="tema-header">
                    <h3>${publicacion.titulo}</h3>
                    <span>Publicado por ${publicacion.nombre}</span>
                </div>

                <div class="tema-contenido">
                <p>${publicacion.contenido}</p>
                </div>

                ${botones}

                <div class="comentarios">

                <h4>Comentarios</h4>

        <div id="comentarios-${publicacion.id}">
        </div>

            <textarea
            id="comentario-${publicacion.id}"
            placeholder="Escribe un comentario">
            </textarea>

            <button
            onclick="crearComentario(${publicacion.id})">

            <i class="fas fa-paper-plane"></i> Comentar

            </button>

            </div>

            </article>
            
        `;
        cargarComentarios(publicacion.id);
        console.log("Cargando comentarios de publicación:", publicacion.id);
    });
}

async function crearComentario(idPublicacion) {

    const comentario = document.getElementById(
        `comentario-${idPublicacion}`
    ).value;

    if (comentario.trim() === "") {

        alert("Escribe un comentario");

        return;
    }

    const formData = new FormData();

    formData.append(
        "id_publicacion",
        idPublicacion
    );

    formData.append(
        "comentario",
        comentario
    );

    const respuesta = await fetch(
        "api/crear_comentario.php",
        {
            method: "POST",
            body: formData
        }
    );

    const datos = await respuesta.json();

    if (datos.success) {

        document.getElementById(
            `comentario-${idPublicacion}`
        ).value = "";

        cargarComentarios(
            idPublicacion
        );

    } else {

        alert(
            datos.mensaje || "Error al comentar"
        );
    }
}

async function cargarComentarios(idPublicacion) {

    const respuesta = await fetch(
        `api/listar_comentarios.php?id_publicacion=${idPublicacion}`
    );

    const comentarios = await respuesta.json();

    const contenedor = document.getElementById(
        `comentarios-${idPublicacion}`
    );

    if (!contenedor) return;

    contenedor.innerHTML = "";

    comentarios.forEach(comentario => {

        console.log("Usuario actual:", usuarioActual);
        console.log("Dueño comentario:", comentario.id_usuario);

       let botonEliminar = `
    <button>
        PRUEBA BOTON
    </button>
`;

        if (usuarioActual == comentario.id_usuario) {

            console.log("Mostrar botón eliminar");

            botonEliminar = `
                <button
                    class="btn-eliminar-comentario"
                    onclick="eliminarComentario(
                        ${comentario.id},
                        ${idPublicacion}
                    )">

                    <i class="fas fa-trash"></i>
                    Eliminar

                </button>
            `;
        }

        contenedor.innerHTML += `
            <div class="comentario">

                <strong>
                    ${comentario.nombre}
                </strong>

                <p>
                    ${comentario.comentario}
                </p>

                ${botonEliminar}

            </div>
        `;
    });
}
// =======================
// ✏ EDITAR PUBLICACIÓN
// =======================
async function editarPublicacion(id, tituloActual, contenidoActual) {

    const nuevoTitulo = prompt("Nuevo título:", tituloActual);
    const nuevoContenido = prompt("Nuevo contenido:", contenidoActual);

    if (!nuevoTitulo || !nuevoContenido) return;

    const formData = new FormData();
    formData.append("id", id);
    formData.append("titulo", nuevoTitulo);
    formData.append("contenido", nuevoContenido);

    const respuesta = await fetch("api/editar_publicacion.php", {
        method: "POST",
        body: formData
    });

    const texto = await respuesta.text();

    console.log("RESPUESTA:", texto);

    try {

        const datos = JSON.parse(texto);

        if (datos.success) {

            alert("Publicación actualizada");

            cargarPublicaciones();

        } else {

            alert("No se pudo actualizar");
        }

    } catch(error) {

        console.error("Error JSON:", error);
    }
}

// =======================
// 🗑 ELIMINAR PUBLICACIÓN
// =======================
async function eliminarPublicacion(id) {

    if (!confirm("¿Seguro que deseas eliminar esta publicación?")) return;

    const formData = new FormData();
    formData.append("id", id);

    const respuesta = await fetch("api/eliminar_publicacion.php", {
        method: "POST",
        body: formData
    });

    const datos = await respuesta.json();

    alert(datos.mensaje || "Eliminado");

    if (datos.success) {
        cargarPublicaciones();
    }
}

async function eliminarComentario(
    idComentario,
    idPublicacion
) {

    const confirmar = confirm(
        "¿Eliminar comentario?"
    );

    if (!confirmar) return;

    const formData = new FormData();

    formData.append(
        "id",
        idComentario
    );

    const respuesta = await fetch(
        "api/eliminar_comentario.php",
        {
            method: "POST",
            body: formData
        }
    );

    const datos = await respuesta.json();

    if (datos.success) {

        cargarComentarios(
            idPublicacion
        );
    } else {

        alert(
            datos.mensaje ||
            "No se pudo eliminar"
        );
    }
}

// =======================
// 🔐 HELPERS (evitar errores de comillas)
// =======================
function escapeQuotes(text) {
    return String(text).replace(/'/g, "\\'");
}

function escapeBackticks(text) {
    return String(text).replace(/`/g, "\\`");
}