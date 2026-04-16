<?php

namespace App\Http\Controllers;

use App\Events\UserTyping;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypingController extends Controller
{
    public function typing(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $hasAccess = false;

        if ($user->expediteur && $conversation->expediteur_id === $user->expediteur->id) {
            $hasAccess = true;
        }

        if ($user->chauffeur && $conversation->chauffeur_id === $user->chauffeur->id) {
            $hasAccess = true;
        }

        if (! $hasAccess) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        broadcast(new UserTyping($conversation->id, $user->prenom))->toOthers();

        return response()->json(['status' => 'success']);
    }
}
