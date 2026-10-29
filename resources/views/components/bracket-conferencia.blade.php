@props(['conf', 'datos'])

<div {{ $attributes->merge(['class' => 'br-conf']) }}>
    <h3 class="br-conf-titulo">{{ $conf }}</h3>

    <div class="br-cols">
        {{-- Play-In --}}
        <div class="br-col br-col-playin">
            <span class="br-ronda">Play-In</span>
            <div class="br-items">
                {{-- orden visual: 9v10, final play-in, 7v8 --}}
                @foreach ([$datos['playin'][1], $datos['playin'][2], $datos['playin'][0]] as $p)
                    <div>
                        <span class="br-sub">{{ $p['titulo'] }}</span>
                        <div class="br-cruce">
                            <x-bracket-equipo :e="$p['a']" />
                            <x-bracket-equipo :e="$p['b']" />
                        </div>
                        <span class="br-nota">{{ $p['nota'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Primera ronda --}}
        <div class="br-col">
            <span class="br-ronda">Primera ronda</span>
            <div class="br-items">
                @foreach ($datos['ronda1'] as [$a, $b])
                    <div class="br-cruce">
                        <x-bracket-equipo :e="$a" />
                        <x-bracket-equipo :e="$b" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Semifinales --}}
        <div class="br-col">
            <span class="br-ronda">Semifinales</span>
            <div class="br-items">
                @for ($i = 0; $i < 2; $i++)
                    <div class="br-cruce"><x-bracket-equipo /><x-bracket-equipo /></div>
                @endfor
            </div>
        </div>

        {{-- Final de conferencia --}}
        <div class="br-col">
            <span class="br-ronda">Final {{ $conf }}</span>
            <div class="br-items">
                <div class="br-cruce"><x-bracket-equipo /><x-bracket-equipo /></div>
            </div>
        </div>
    </div>
</div>
