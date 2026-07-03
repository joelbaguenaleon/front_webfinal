<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $apiKey = config('services.balldontlie.key');

    $fecha = $request->input('fecha', '2026-06-13');

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


    return view('home', compact('partidos', 'fecha'));
}
}
