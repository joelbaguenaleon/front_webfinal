<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $apiKey = config('services.balldontlie.key');

    $fecha = $request->input('fecha', Carbon::yesterday()->toDateString());

    $partidos = [];

    $responsePartidos = Http::withHeaders([
        'Authorization' => $apiKey,
    ])->get('https://api.balldontlie.io/nba/v1/games', [
        'dates[]' => $fecha,
        'per_page' => 100,
    ]);

        if ($responsePartidos->successful()) {
            $partidos = $responsePartidos->json('data') ?? [];
        }

        $clasificacion = collect(Cache::remember('clasificacion', 300, function () {
            try {
                $r = Http::timeout(10)->retry(2, 500)
                    ->get(config('services.fastapi.url') . '/api/stats/clasificacion');
                return $r->successful() ? $r->json() : null;
            } catch (\Exception $e) {
                return null;
            }
        }) ?? []);

        $este  = $clasificacion->where('conferencia', 'East')->sortBy('posicion')->values();
        $oeste = $clasificacion->where('conferencia', 'West')->sortBy('posicion')->values();

        $armar = function ($lista) {
            $eq = fn ($i) => $lista[$i] ?? null;

            return [
                'playin' => [
                    ['titulo' => '7º vs 8º',   'a' => $eq(6), 'b' => $eq(7),
                    'nota' => 'El ganador es el 7º seed'],
                    ['titulo' => '9º vs 10º',  'a' => $eq(8), 'b' => $eq(9),
                    'nota' => 'El perdedor queda eliminado'],
                    ['titulo' => 'Final Play-In',
                    'a' => ['texto' => 'Perdedor 7º/8º'],
                    'b' => ['texto' => 'Ganador 9º/10º'],
                    'nota' => 'El ganador es el 8º seed'],
                ],
                'ronda1' => [
                    [$eq(0), ['texto' => 'Ganador Final Play-In', 'seed' => 8]],
                    [$eq(3), $eq(4)],
                    [$eq(2), $eq(5)],
                    [$eq(1), ['texto' => 'Ganador 7º/8º', 'seed' => 7]],
                ],
            ];
        };
        $bracket = [
            'Oeste' => $armar($oeste),
            'Este'  => $armar($este),
        ];

        return view('home', compact('partidos', 'fecha', 'este', 'oeste', 'bracket'));
    }
}
