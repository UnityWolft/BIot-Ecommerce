document.addEventListener("DOMContentLoaded", async () => {

    const respuesta =
        await fetch("api/verificar_sesion.php");

    const datos =
        await respuesta.json();

    if (!datos.logueado) {

        alert("Debes iniciar sesión");

        window.location.href = "login.html";

        return;
    }

    if (datos.rol !== "admin") {

        alert("Acceso restringido");

        window.location.href = "index.html";

        return;
    }

});