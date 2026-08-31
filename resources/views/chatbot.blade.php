<!DOCTYPE html>
<html lang="es">

<title>NBAguena</title>

<head>
    <h1>ChatBotNBA</h1>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css?v=40">

</head>

<div class="menu">
    <a href="/"><button>Home</button></a>
    <a href="/regular-season"><button>Estadísticas jugadores temporada regular 2026</button></a>
    <a href="/playoffs"><button>Estadísticas jugadores playoffs 2026</button></a>
    <a href="/chatbot"><button>ChatBotNBA</button></a>
</div>

<div class="chat-header">

    <button type="button" id="infoChatBtn" class="btn-info-chat" aria-label="Información de uso del chatbot">
        ⓘ
    </button>
</div>

<div id="infoChatModal" class="info-chat-overlay" hidden>

    <div class="info-chat-modal">

        <button type="button" id="cerrarInfoChat" class="cerrar-info-chat" aria-label="Cerrar">
            ×
        </button>

        <h2>🏀 ¿Cómo usar ChatBotNBA?</h2>

        <p>
            Puedes preguntarme sobre información y estadísticas de la NBA.
        </p>

        <h3>Preguntas que puede contestar el chat:</h3>

        <ul>
            <li>Partidos de hoy</li>
            <li>Últimos partidos de Boston</li>
            <li>Clasificación NBA</li>
            <li>Estadísticas de Lebron James</li>
            <li>Información Lebron James</li>
            <li>Jugadores de los Lakers</li>
        </ul>

        <p>
            Intenta escribir nombres completos o abreviaturas reconocibles
            para obtener mejores resultados, así como evitar faltas de ortografía.
        </p>

    </div>

</div>

<div id="chatBox" class="chat-box">
    <div class="mensaje bot">
        <strong>ChatBotNBA:</strong>
        <p>
            Hola soy ChatBotNBA. Puedes preguntarme sobre equipos, jugadores, partidos,
            clasificaciones o estadísticas de la NBA.
        </p>
    </div>
</div>

<div class="chat-input-area">
    <input type="text" id="mensaje" placeholder="Pregunta algo...">

    <button onclick="preguntar()">Enviar</button>
</div>

<script>
    const input = document.getElementById('mensaje');

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            preguntar();
        }
    });

    async function preguntar() {
        const chatBox = document.getElementById("chatBox");
        const texto = input.value.trim();

        if (!texto) return;

        chatBox.innerHTML += `
            <div class="mensaje user">
                <strong>Tú:</strong><br>
                ${texto}
            </div>
        `;

        input.value = "";

        try {
            const response = await fetch("/chatbot/preguntar", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    texto: texto
                })
            });

            const data = await response.json();

            console.log("Respuesta Laravel:", data);

            if (!response.ok) {
                throw new Error(
                    data.message ??
                    data.respuesta ??
                    `Error ${response.status}`
                );
            }

            const mensajeBot = document.createElement("div");
            mensajeBot.classList.add("mensaje", "bot");

            const titulo = document.createElement("strong");
            titulo.textContent = "ChatBotNBA:";

            const respuestaTexto = document.createElement("div");
            respuestaTexto.classList.add("respuesta-texto");

            const lineas = String(data.respuesta ?? "")
                .replace(/\\n/g, "\n")
                .split(/\r?\n/);

            lineas.forEach((linea, index) => {
                respuestaTexto.appendChild(
                    document.createTextNode(linea)
                );

                if (index < lineas.length - 1) {
                    respuestaTexto.appendChild(
                        document.createElement("br")
                    );
                }
            });

            mensajeBot.appendChild(titulo);
            mensajeBot.appendChild(respuestaTexto);

            chatBox.appendChild(mensajeBot);

        } catch (error) {
            console.error("Error chatbot:", error);

            chatBox.innerHTML += `
                <div class="mensaje bot">
                    <strong>Error:</strong>
                    <p>No se pudo obtener respuesta del chatbot.</p>
                </div>
            `;
        }

        chatBox.scrollTop = chatBox.scrollHeight;

        const infoChatBtn = document.getElementById("infoChatBtn");
        const infoChatModal = document.getElementById("infoChatModal");
        const cerrarInfoChat = document.getElementById("cerrarInfoChat");

        infoChatBtn.addEventListener("click", () => {
            infoChatModal.hidden = false;
        });

        cerrarInfoChat.addEventListener("click", () => {
            infoChatModal.hidden = true;
        });

        infoChatModal.addEventListener("click", (event) => {
            if (event.target === infoChatModal) {
                infoChatModal.hidden = true;
            }
        });
    }
</script>
