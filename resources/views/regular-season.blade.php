<!DOCTYPE html>
<html>

<head>
    <title>NBAguena</title>
    <link rel="stylesheet" href="/style.css">
</head>


<body>

    <h1>Estadísticas jugadores temporada regular 2026</h1>

    <div class="menu">
        <a href="/"><button>Home</button></a>
        <a href="/regular-season"><button>Estadídticas jugadores temporada regular 2026</button></a>
        <a href="/playoffs"><button>Estadídticas jugadores playoffs 2026</button></a>
        <a href="/chatbot"><button>ChatBotNBA</button></a>
    </div>

    <div class="top-bar">
        <a href="{{ route('guia.uso') }}" class="btn-guia">
            📘 Guía de uso
        </a>
    </div>


    <select id="teamSelect">
        @foreach ($teams as $team)
            <option value="{{ $team['TEAM_ABBREVIATION'] }}">
                {{ $team['TEAM_ABBREVIATION'] }}
            </option>
        @endforeach
    </select>

    <select id="playerSelect">
        <option value="">Selecciona jugador</option>
    </select>

    <button id="compareBtn">Cara a Cara</button>

    <span id="compareBox" style="display:none;">
        <select id="teamSelect2">
            @foreach ($teams as $team)
                <option value="{{ $team['TEAM_ABBREVIATION'] }}">
                    {{ $team['TEAM_ABBREVIATION'] }}
                </option>
            @endforeach
        </select>

        <select id="playerSelect2">
            <option value="">Selecciona jugador</option>
        </select>

        <button id="searchCompareBtn">Comparar</button>
    </span>

    <div id="stats"></div>

    <script>
        const teamSelect = document.getElementById("teamSelect");
        const playerSelect = document.getElementById("playerSelect");
        const compareBtn = document.getElementById("compareBtn");
        const compareBox = document.getElementById("compareBox");
        const teamSelect2 = document.getElementById("teamSelect2");
        const playerSelect2 = document.getElementById("playerSelect2");
        const searchCompareBtn = document.getElementById("searchCompareBtn");
        const stats = document.getElementById("stats");

        let modoComparacion = false;
        let seasonType = "Regular Season";

        async function cargarJugadores(team, selectElement) {
            const response = await fetch(`/players/${team}/${seasonType}`);
            const players = await response.json();

            selectElement.innerHTML = '<option value="">Selecciona jugador</option>';

            players.forEach(player => {
                const option = document.createElement("option");
                option.value = player.PLAYER_ID;
                option.textContent = player.PLAYER_NAME;
                selectElement.appendChild(option);
            });
        }

        async function obtenerJugador(playerId) {
            const response = await fetch(`/player/${playerId}/${seasonType}`);
            return await response.json();
        }

        function renderStats(player) {
            return `
        <h2>${player.PLAYER_NAME}</h2>
        <p>Equipo: ${player.TEAM_ABBREVIATION}</p>
        <p>Partidos: ${player.GP}</p>
        <p>Minutos: ${player.MIN}</p>
        <p>Puntos: ${player.PTS}</p>
        <p>Rebotes: ${player.REB}</p>
        <p>Asistencias: ${player.AST}</p>
        <p>Robos: ${player.STL}</p>
        <p>Tapones: ${player.BLK}</p>
        <p>FG%: ${player.FG_PCT}</p>
        <p>3P%: ${player.FG3_PCT}</p>
        <p>FT%: ${player.FT_PCT}</p>
        <p class="stat-tooltip">
            TS%: ${player.TS_PCT}
            <span class="tooltip-text">
                True Shooting %: mide la eficiencia total de tiro.
            </span>
        </p>
        <p class="stat-tooltip">
            USG%: ${player.USG_PCT}

            <span class="tooltip-text">
                Usage Rate: porcentaje de posesiones ofensivas que finaliza el jugador.
            </span>
        </p>
        <p class="stat-tooltip">
            OFF Rating: ${player.OFF_RATING}

            <span class="tooltip-text">
                Offensive Rating: puntos generados por cada 100 posesiones ofensivas.
            </span>
        </p>
        <p class="stat-tooltip">
        DEF Rating: ${player.DEF_RATING}

            <span class="tooltip-text">
                Defensive Rating: puntos permitidos por cada 100 posesiones.
            </span>
        </p>
        <p class="stat-tooltip">
            NET Rating: ${player.NET_RATING}

            <span class="tooltip-text">
                Net Rating: diferencia entre el Offensive Rating y el Defensive Rating.
            </span>
        </p>
    `;
        }

        cargarJugadores(teamSelect.value, playerSelect);

        teamSelect.addEventListener("change", function() {
            cargarJugadores(this.value, playerSelect);
            stats.innerHTML = "";
        });

        playerSelect.addEventListener("change", async function() {
            if (!this.value) return;

            const player = await obtenerJugador(this.value);
            stats.innerHTML = renderStats(player);
        });

        compareBtn.addEventListener("click", function() {
            modoComparacion = !modoComparacion;

            if (modoComparacion) {
                compareBox.style.display = "inline-block";
                compareBtn.textContent = "Cerrar comparativa";
                cargarJugadores(teamSelect2.value, playerSelect2);
            } else {
                compareBox.style.display = "none";
                compareBtn.textContent = "Cara a Cara";
                playerSelect2.innerHTML = '<option value="">Selecciona jugador</option>';

                if (playerSelect.value) {
                    obtenerJugador(playerSelect.value).then(player => {
                        stats.innerHTML = renderStats(player);
                    });
                } else {
                    stats.innerHTML = "";
                }
            }
        });

        teamSelect2.addEventListener("change", function() {
            cargarJugadores(this.value, playerSelect2);
        });

        searchCompareBtn.addEventListener("click", async function() {
            const player1Id = playerSelect.value;
            const player2Id = playerSelect2.value;

            if (!player1Id || !player2Id) return;

            const player1 = await obtenerJugador(player1Id);
            const player2 = await obtenerJugador(player2Id);

            stats.innerHTML = `
        <div style="display:flex; gap:60px; align-items:flex-start;">
            <div>
                ${renderStats(player1)}
            </div>

            <div>
                ${renderStats(player2)}
            </div>
        </div>
    `;
        });
    </script>
    <p class="sample-warning">
        ⚠️ Las estadísticas avanzadas (TS%, USG%, OFF Rating, DEF Rating y NET Rating)pueden resultar engañosas en
        jugadores con
        muestras pequeñas de partidos o minutos jugados, especialmente en suplentes.
    </p>
</body>

</html>
