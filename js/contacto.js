document
.getElementById("formContacto")
.addEventListener(
    "submit",
    async function(e){

        e.preventDefault();

        const formData =
            new FormData(this);

        const respuesta =
            await fetch(
                "api/contacto.php",
                {
                    method: "POST",
                    body: formData
                }
            );

        const datos =
            await respuesta.json();

        if(datos.success){

            alert(
                "Mensaje enviado correctamente"
            );

            this.reset();

        }else{

            alert(
                "Error al enviar mensaje"
            );
        }
    }
);