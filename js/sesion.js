document.addEventListener("DOMContentLoaded", async () => {

    try {

        const respuesta = await fetch("api/perfil.php");

        const datos = await respuesta.json();

        if (datos.success) {

            const btnLogin =
                document.getElementById("btnLogin");

            const btnRegistro =
                document.getElementById("btnRegistro");

            const btnPerfil =
                document.getElementById("btnPerfil");

            if (btnLogin) {
                btnLogin.style.display = "none";
            }

            if (btnRegistro) {
                btnRegistro.style.display = "none";
            }

            if (btnPerfil) {
                btnPerfil.style.display = "inline-block";
            }
        }

    } catch (error) {

        console.error(
            "Error al verificar sesión:",
            error
        );
    }

});