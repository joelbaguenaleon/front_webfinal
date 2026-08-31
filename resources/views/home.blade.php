<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBAguena</title>
    <link rel="stylesheet" href="/style.css?v=30">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
</head>

<body>
    <h1>NBAguena</h1>
    <div class="menu">
        <a href="/"><button>Home</button></a>
        <a href="/regular-season"><button>Estadísticas jugadores temporada regular 2026</button></a>
        <a href="/playoffs"><button>Estadísticas jugadores playoffs 2026</button></a>
        <a href="/chatbot"><button>ChatBotNBA</button></a>
    </div>
    <h2>Una web diseñada para consultar información actual de la NBA.</h2>
    <h3>🚨La temporada 2025/26 ha terminado. Debido a que la liga se encuentra en período de traspasos, la web podría
        presentar fallos en las plantillas. Les pedimos disculpas, ya estamos trabajando en ello.🚨</h3>


    <div class="home-grid">
        <section class="home-card">
            <h2>Partidos NBA</h2>
            <h4>Se pueden consultar todos los partidos de la NBA.</h4>

            <form method="GET" action="/">
                <input type="date" name="fecha" value="{{ $fecha }}">
                <button type="submit">Buscar</button>
            </form>

            @if (count($partidos))
                @foreach ($partidos as $partido)
                    <span class="game-type">
                        {{ $partido['postseason'] ? '🏆 Playoffs Game' : '🏀 Regular Season Game' }}
                    </span>

                    <div class="game-card">
                        <strong>{{ $partido['visitor_team']['full_name'] }}</strong>
                        {{ $partido['visitor_team_score'] }}
                        -
                        {{ $partido['home_team_score'] }}
                        <strong>{{ $partido['home_team']['full_name'] }}</strong>

                        <p>{{ $partido['status'] }}</p>
                    </div>
                @endforeach
            @else
                <p>No hay partidos para esa fecha.</p>
            @endif
        </section>
        <section class="home-card">
            <h2>🏆 Bracket Final Playoffs 2026</h2>

            <a href="{{ asset('bracket.png') }}" target="_blank">
                <img src="{{ asset('bracket.png') }}" class="bracket-img" alt="Bracket Playoffs">
            </a>
        </section>
    </div>

</body>

</html>
