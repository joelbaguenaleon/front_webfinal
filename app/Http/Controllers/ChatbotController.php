<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function preguntar(Request $request)
    {
        $request->validate([
            'texto' => 'required|string'
        ]);

        $response = Http::post('http://127.0.0.1:8001/api/chatbot/preguntar', [
            'texto' => $request->texto
        ]);

        return response()->json($response->json());
    }
}
