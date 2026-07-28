<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/playoffs', function () {

    $response = Http::get(config('services.fastapi.url') . '/api/stats/teams', [
        'season' => '2025-26',
        'season_type' => 'Playoffs'
    ]);

    $teams = $response->json();

    return view('playoffs', compact('teams'));
})->name('playoffs');
Route::get('/regular-season', function () {

    $response = Http::get(config('services.fastapi.url') . '/api/stats/teams', [
        'season' => '2025-26',
        'season_type' => 'Regular Season'
    ]);

    $teams = $response->json();

    return view('regular-season', compact('teams'));
})->name('regular-season');

Route::get('/players/{team}/{seasonType}', function ($team, $seasonType) {

    $response = Http::get(config('services.fastapi.url') . '/api/stats/players', [
        'equipo' => $team,
        'season' => '2025-26',
        'season_type' => $seasonType
    ]);

    return $response->json();
});

Route::get('/player/{id}/{seasonType}', function ($id, $seasonType) {

    $response = Http::get(config('services.fastapi.url') . '/api/stats/player/stats', [
        'player_id' => $id,
        'season' => '2025-26',
        'season_type' => $seasonType
    ]);

    return $response->json();
});

Route::get('/guia-uso', function () {
    return view('guia-uso');
})->name('guia.uso');

Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/preguntar', [ChatbotController::class, 'preguntar'])->name('chatbot.preguntar');
