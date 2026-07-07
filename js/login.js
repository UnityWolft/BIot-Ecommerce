document
.getElementById("formLogin")
.addEventListener("submit", async (e) => {

    e.preventDefault();

    const formData = new FormData();

    formData.append(
        "correo",
        document.getElementById("correo").value
    );

    formData.append(
        "password",
        document.getElementById("password").value
    );

    const respuesta = await fetch(
        "../api/login.php",
        {
            method: "POST",
            body: formData
        }
    );

    const datos = await respuesta.json();

    alert(datos.mensaje);

    if(datos.success){

        window.location.href = "index.html";

    }
    
});

