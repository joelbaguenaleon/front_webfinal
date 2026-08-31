<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Guía de Uso</title>
    <link rel="stylesheet" href="/guia.css">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
</head>

<body>


    <div class="header-guia">

        <a href=class="btn-volver">
            @if (request('from') === 'playoffs')
                <a href="{{ route('playoffs') }}" class="btn-volver">
                    ← Volver
                </a>
            @else
                <a href="{{ route('regular-season') }}" class="btn-volver">
                    ← Volver
                </a>
            @endif
        </a>

        <h1>Guía de Uso</h1>

        <p>La idea es mostrar de manera rápida los promedios de los jugadores en la NBA durante 2026.
            La web contempla tanto estadísticas normales, promedios y algunas estadísticas avanzadas.
        </p>

        <h2>Funcionalidades</h2>

        <ul>
            <li>
                <strong>Seleccionador de equipo:</strong>
                En el primer desplegable se selecciona un equipo.
            </li>

            <li>
                <strong>Seleccionador de jugador:</strong>
                En el segundo desplegable aparecerán automáticamente los jugadores del equipo elegido.
                Al seleccionar un jugador se mostrarán sus estadísticas.
            </li>

            <li>
                <strong>Comparador de jugadores:</strong>
                Al pulsar el botón <em>Cara a Cara</em> se abrirá otro desplegable para elegir otro equipo y jugador.
                Después de escogerlos y pulsar <em>Comparar</em>, se mostrarán las estadísticas de ambos jugadores lado
                a lado.
            </li>
        </ul>

        <h2>Guía de las estadísticas</h2>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Estadística</th>
                    <th>Definición</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>GP</td>
                    <td>Partidos jugados</td>
                </tr>

                <tr>
                    <td>MIN</td>
                    <td>Minutos por partido</td>
                </tr>

                <tr>
                    <td>PTS</td>
                    <td>Puntos por partido</td>
                </tr>

                <tr>
                    <td>REB</td>
                    <td>Rebotes por partido</td>
                </tr>

                <tr>
                    <td>AST</td>
                    <td>Asistencias por partido</td>
                </tr>

                <tr>
                    <td>STL</td>
                    <td>Robos por partido</td>
                </tr>

                <tr>
                    <td>BLK</td>
                    <td>Tapones por partido</td>
                </tr>

                <tr>
                    <td>FG%</td>
                    <td>Porcentaje total de tiro</td>
                </tr>

                <tr>
                    <td>3P%</td>
                    <td>Porcentaje de triples</td>
                </tr>

                <tr>
                    <td>FT%</td>
                    <td>Porcentaje de tiros libres</td>
                </tr>

                <tr>
                    <td>TS%</td>
                    <td>
                        True Shooting %.
                        Mide la eficiencia real de anotación teniendo en cuenta tiros de 2, triples y tiros libres.
                        Un valor alto indica que el jugador anota de forma eficiente.
                    </td>
                </tr>

                <tr>
                    <td>USG%</td>
                    <td>
                        Usage Rate.
                        Indica cuánto participa un jugador en el ataque de su equipo.
                        Un porcentaje alto significa que tiene mucho protagonismo ofensivo.
                    </td>
                </tr>

                <tr>
                    <td>OFF Rating</td>
                    <td>
                        Puntos que anota el equipo cada 100 posesiones con el jugador en pista.
                        Cuanto más alto, mejor impacto ofensivo tiene el jugador.
                    </td>
                </tr>

                <tr>
                    <td>DEF Rating</td>
                    <td>
                        Puntos que recibe el equipo cada 100 posesiones con el jugador en pista.
                        Cuanto más bajo, mejor rendimiento defensivo aporta.
                    </td>
                </tr>

                <tr>
                    <td>NET Rating</td>
                    <td>
                        Diferencia entre OFF Rating y DEF Rating.
                    </td>
                </tr>
            </tbody>
        </table>

</body>

</html>
