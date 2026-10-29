<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBAguena</title>
    <link rel="stylesheet" href="/style.css?v=30">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}?v=2">
</head>

<body>
    <h1>NBAguena</h1>
    <div class="menu">
        <a href="/"><button>Home</button></a>
        <a href="/regular-season"><button>Estadísticas jugadores temporada regular 2027</button></a>
        <a> <!--añadir ruta cuando lleguen los playoffs: href="/playoffs"*-->
            <button class="btn-tooltip">Estadísticas jugadores playoffs 2027
                <span class="tooltip-text">Disponible cuando lleguen los playoffs.</span>
                <!--comentar tooltip cuando se habilite boton-->
            </button>
        </a>
        <a href="/chatbot"><button>ChatBotNBA</button></a>
    </div>
    <h2>Actualidad NBA</h2>

    <div class="home-grid">
        <section class="home-card">
            <h2>Partidos</h2>

            <form method="GET" action="/">
                <input type="date" name="fecha" value="{{ $fecha }}">
                <button type="submit">Buscar</button>
            </form>

            @if (count($partidos))
                @foreach ($partidos as $partido)
                    <span class="game-type">
                        @if (!empty($partido['ist_stage']))
                            Copa NBA
                        @elseif (!empty($partido['preseason']))
                            Pretemporada
                        @elseif (!empty($partido['postseason']))
                            Playoffs
                        @else
                            Regular Season
                        @endif
                    </span>

                    <div class="game-card">
                        <strong>{{ $partido['visitor_team']['full_name'] }}</strong>
                        {{ $partido['visitor_team_score'] }}
                        -
                        {{ $partido['home_team_score'] }}
                        <strong>{{ $partido['home_team']['full_name'] }}</strong>

                        <p>
                            @if (\Carbon\Carbon::hasFormat($partido['status'], 'Y-m-d\TH:i:s\Z') || strtotime($partido['status']))
                                ⏰{{ \Carbon\Carbon::parse($partido['status'])->setTimezone('Europe/Madrid')->format('H:i') }}
                            @else
                                {{ $partido['status'] }}
                            @endif
                        </p>
                    </div>
                @endforeach
            @else
                <p>Sin partidos en esta fecha</p>
            @endif
        </section>
        <section class="home-card clasificacion">
            <div class="clas-cabecera">
                <h2>Clasificación</h2>
                <button type="button" class="btn-info" id="abrir-bracket" title="Ver bracket de playoffs">Bracket
                    playoffs</button>
            </div>

            <p class="clas-leyenda">
                <span class="punto playoffs"></span> Playoffs (1-6)
                <span class="punto playin"></span> Play-In (7-10)
            </p>

            @foreach (['Este' => $este, 'Oeste' => $oeste] as $titulo => $lista)
                <h3 class="clas-conf">Conferencia {{ $titulo }}</h3>

                <table class="clas-tabla">
                    <thead>
                        <tr>
                            <th>Puesto</th>
                            <th>Equipo</th>
                            <th>V-D</th>
                            <th>Racha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lista as $e)
                            <tr class="{{ $e['posicion'] <= 6 ? 'playoffs' : ($e['posicion'] <= 10 ? 'playin' : '') }}">
                                <td class="pos">{{ $e['posicion'] }}</td>
                                <td class="clas-equipo">{{ $e['equipo'] }}</td>
                                <td class="vd">{{ $e['victorias'] }}-{{ $e['derrotas'] }}</td>
                                <td class="racha {{ str_starts_with($e['racha'], 'W') ? 'gana' : 'pierde' }}">
                                    {{ $e['racha'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </section>
        <dialog id="dialogo-bracket" class="bracket-dialog">
            <div class="bracket-top">
                <h2>🏆 Bracket de playoffs proyectado</h2>
                <button type="button" class="btn-cerrar" id="cerrar-bracket" aria-label="Cerrar">✕</button>
            </div>
            <p class="bracket-nota">Cómo quedaría si la temporada terminara hoy. Los puestos 7-10 se deciden en el
                Play-In.</p>

            <div class="br-wrap">
                <x-bracket-conferencia conf="Oeste" :datos="$bracket['Oeste']" class="br-conf br-oeste" />

                <div class="br-centro">
                    <span class="br-ronda">Final NBA</span>
                    <div class="br-cruce"><x-bracket-equipo /><x-bracket-equipo /></div>
                </div>

                <x-bracket-conferencia conf="Este" :datos="$bracket['Este']" class="br-conf br-este" />
            </div>
        </dialog>

        <script>
            const dlg = document.getElementById('dialogo-bracket');
            document.getElementById('abrir-bracket').addEventListener('click', () => dlg.showModal());
            document.getElementById('cerrar-bracket').addEventListener('click', () => dlg.close());
            dlg.addEventListener('click', e => {
                if (e.target === dlg) dlg.close();
            }); // clic fuera
        </script>

    </div>

</body>

</html>
