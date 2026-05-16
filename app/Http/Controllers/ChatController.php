<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            return response()->json(['reply' => 'API Key is missing.'], 500);
        }

        $userMessage = $request->message;

        $prompt = "You are Dr. MindBoard, a friendly, professional, and compassionate therapist. " .
                  "Your responses should be concise (1-3 sentences), warm, and supportive. " .
                  "Offer genuine, evidence-based mental health advice or simply be a good listener. " .
                  "User says: " . $userMessage;

        $response = Http::withoutVerifying()->withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? "Sorry, my marker dried up. Try again?";
            return response()->json(['reply' => $reply]);
        }

        // Return exact error to help debug
        $errorBody = $response->body();
        return response()->json(['reply' => 'API Error: ' . $errorBody], 500);
    }
}
