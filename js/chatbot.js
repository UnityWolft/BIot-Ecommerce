async function enviarMensaje() {

    const input =
        document.getElementById("mensaje");

    const texto =
        input.value.trim();

    if(texto === ""){
        return;
    }

    const chat =
        document.getElementById("chat-body");

    chat.innerHTML += `
        <div class="user">
            ${texto}
        </div>
    `;

    input.value = "";

    const formData =
        new FormData();

    formData.append(
        "mensaje",
        texto
    );

    try{

        const respuesta =
            await fetch(
                "api/chatbot.php",
                {
                    method: "POST",
                    body: formData
                }
            );

        const datos =
            await respuesta.json();

        chat.innerHTML += `
            <div class="bot">
                ${datos.respuesta}
            </div>
        `;

        chat.scrollTop =
            chat.scrollHeight;

    }catch(error){

        chat.innerHTML += `
            <div class="bot">
                Error al conectar con BioBot.
            </div>
        `;

        console.error(error);
    }
}

document.addEventListener(
    "DOMContentLoaded",
    () => {

        const input =
            document.getElementById("mensaje");

        input.addEventListener(
            "keypress",
            function(e){

                if(e.key === "Enter"){

                    e.preventDefault();

                    enviarMensaje();
                }
            }
        );
    }
);
function toggleChat(){

    const chat =
        document.getElementById("chatbot");

    chat.classList.toggle(
        "chat-minimizado"
    );
}