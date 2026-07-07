document.addEventListener("DOMContentLoaded", () => {

    const boton = document.getElementById("btnPagar");

    if (!boton) return;

    boton.addEventListener("click", async () => {

        const pedido = boton.dataset.pedido;

        const formData = new FormData();

        formData.append("pedido", pedido);

        try {

            const respuesta = await fetch("api/crear_preferencia.php", {
                method: "POST",
                body: formData
            });

            const datos = await respuesta.json();

            if (datos.success) {

                // Redirige al Checkout de Mercado Pago
                window.location.href = datos.url;

            } else {

                console.error(datos);

                alert("No se pudo iniciar el pago.");

            }

        } catch (error) {

            console.error(error);

            alert("Error al conectar con Mercado Pago.");

        }

    });

});