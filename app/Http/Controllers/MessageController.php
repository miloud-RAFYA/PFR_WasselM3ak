<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessages(Request $request, Conversation $conversation)
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
            abort(403, 'Accès non autorisé.');
        }

        $perPage = $request->query('per_page', 20);
        $sinceId = $request->query('since_id');
        $lastId = $request->query('last_id');

        if ($sinceId) {
            $messages = $conversation->messages()
                ->with('sender')
                ->where('id', '>', $sinceId)
                ->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'messages' => $messages->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'conversation_id' => $message->conversation_id,
                        'sender_id' => $message->sender_id,
                        'sender_name' => $message->sender->prenom ?? $message->sender->name ?? 'Utilisateur',
                        'content' => $message->content,
                        'type' => $message->type,
                        'is_read' => $message->is_read,
                        'time' => $message->created_at->format('H:i'),
                    ];
                })->values(),
                'has_more' => false,
                'current_page' => 1,
            ]);
        }

        if ($lastId) {
            $messages = $conversation->messages()
                ->with('sender')
                ->where('id', '<', $lastId)
                ->orderBy('id', 'desc')
                ->limit($perPage)
                ->get()
                ->reverse()
                ->values();

            return response()->json([
                'messages' => $messages->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'conversation_id' => $message->conversation_id,
                        'sender_id' => $message->sender_id,
                        'sender_name' => $message->sender->prenom ?? $message->sender->name ?? 'Utilisateur',
                        'content' => $message->content,
                        'type' => $message->type,
                        'is_read' => $message->is_read,
                        'time' => $message->created_at->format('H:i'),
                    ];
                })->values(),
                'has_more' => $messages->count() === $perPage,
            ]);
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'conversation_id' => $message->conversation_id,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->prenom ?? $message->sender->name ?? 'Utilisateur',
                    'content' => $message->content,
                    'type' => $message->type,
                    'is_read' => $message->is_read,
                    'time' => $message->created_at->format('H:i'),
                ];
            })->values(),
            'next_page_url' => $messages->nextPageUrl(),
            'current_page' => $messages->currentPage(),
        ]);
    }
}
