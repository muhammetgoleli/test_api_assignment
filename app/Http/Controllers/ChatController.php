<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function chat(Request $request) {
        $request->validate([
            'userId'  => 'required|integer',
            'chatId'  => 'required|string',
            'message' => 'required|string'
        ]);

        $user = User::where('userId', $request->userId)->first();

        if ($user->subscription_status !== 'premium') {
            return response()->json(['error' => 'You need a premium subscription to access chat.'], 403);
        }


        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer test',
            ],
            'json' => [
                'prompt' => $request->message,
                'max_tokens' => 150,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        
        $newChatId = $this->generateUniqueChatId();
        // $chat = Chat::where('id', $request->chatId)->first();

        Chat::updateOrCreate(
            ['id' => $newChatId],
            ['user_id' => $request->userId],
            ['message' => $response['choices'][0]['text']]
        );

        return response()->json([
            'message' => $response()->json(['message' => $data['choices'][0]['text']])->message
        ]);
    }

    public function generateUniqueChatId() {
        return uniqid('chat_');
    }
}
