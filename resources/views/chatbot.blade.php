<title>NBAguena</title>
<link rel="stylesheet" href="{{ asset('style.css') }}">

<h1>ChatBotNBA</h1>

<div class="menu">
    <a href="/"><button>Home</button></a>
    <a href="/regular-season"><button>Estadídticas jugadores temporada regular 2026</button></a>
    <a href="/playoffs"><button>Estadídticas jugadores playoffs 2026</button></a>
    <a href="/chatbot"><button>ChatBotNBA</button></a>
</div>


<div id="chatBox" class="chat-box"></div>

<div class="chat-input">
    <input id="mensaje" type="text" placeholder="Pregunta algo...">

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
        const chatBox = document.getElementById('chatBox');
        const texto = input.value.trim();

        if (!texto) return;

        chatBox.innerHTML += `
        <div class="mensaje user">
            <strong>Tú:</strong><br>
            ${texto}
        </div>
    `;

        input.value = "";

        const response = await fetch("{{ route('chatbot.preguntar') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                texto
            })
        });

        const data = await response.json();

        chatBox.innerHTML += `
        <div class="mensaje bot">
            <strong>ChatBotNBA:</strong>
            <pre>${data.respuesta}</pre>
        </div>
    `;

        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>
