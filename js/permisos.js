document.addEventListener(
    "DOMContentLoaded",
    async () => {

        try {

            const respuesta =
                await fetch(
                    "api/verificar_sesion.php"
                );

            const datos =
                await respuesta.json();

            const menuInventario =
                document.getElementById(
                    "menuInventario"
                );

            if (
                menuInventario &&
                datos.rol === "admin"
            ) {

                menuInventario.style.display =
                    "block";
            }

        } catch(error) {

            console.error(error);
        }
    }
);