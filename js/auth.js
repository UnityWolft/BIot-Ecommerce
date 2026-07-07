document
.getElementById("formRegistro")
.addEventListener("submit", async (e) => {

    e.preventDefault();

    const formData = new FormData();

    formData.append(
        "nombre",
        document.getElementById("nombre").value
    );

    formData.append(
        "correo",
        document.getElementById("correo").value
    );

    formData.append(
        "password",
        document.getElementById("password").value
    );

    try {

        const respuesta = await fetch(
            "api/registro.php",
            {
                method: "POST",
                body: formData
            }
        );

        const datos = await respuesta.json();

        alert(datos.mensaje);

        if (datos.success) {
            window.location.href = "login.html";
        }

    } catch (error) {

        console.error("Error:", error);

        alert("Ocurrió un error al registrar el usuario.");
    }

});