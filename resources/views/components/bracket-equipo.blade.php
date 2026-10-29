@props(['e' => null])

<div class="br-eq">
    @if (is_array($e) && isset($e['texto']))
        @if (isset($e['seed']))
            <span class="seed">{{ $e['seed'] }}</span>
        @endif
        <em>{{ $e['texto'] }}</em>
    @elseif (is_array($e) && isset($e['equipo'], $e['id']))
        <span class="seed">{{ $e['posicion'] ?? '' }}</span>
        <img src="https://cdn.nba.com/logos/nba/{{ $e['id'] }}/global/L/logo.svg" alt="" loading="lazy">
        <span>{{ $e['equipo'] }}</span>
    @else
        <em>Por definir</em>
    @endif
</div>
