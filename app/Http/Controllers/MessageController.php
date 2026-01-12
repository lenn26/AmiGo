<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Affiche la liste des conversations.
     */
    public function index()
    {
        $userId = Auth::id();

        // Récupérer tous les messages où l'utilisateur est impliqué, triés par date décroissante
        $messages = Message::where('from_user_id', $userId)
            ->orWhere('to_user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->with(['sender', 'receiver'])
            ->get();

        // Grouper par (autre utilisateur + trajet) pour avoir des conversations distinctes par trajet
        $conversations = $messages->groupBy(function ($message) use ($userId) {
            $otherUserId = $message->from_user_id == $userId ? $message->to_user_id : $message->from_user_id;
            // On inclut l'ID du trajet dans la clé de groupement. Si c'est null, ce sera une conversation "générale"
            return $otherUserId . '-' . ($message->trip_id ?? 'general');
        })->map(function ($msgs) {
            // Pour chaque groupe, on prend le premier message (le plus récent)
            return $msgs->first();
        });

        // Charger les utilisateurs et trajets associés aux conversations
        $formattedConversations = $conversations->map(function ($msg) use ($userId) {
            $isSender = $msg->from_user_id == $userId;
            $otherUser = $isSender ? $msg->receiver : $msg->sender;
            
            return (object) [
                'user' => $otherUser,
                'trip' => $msg->trip, // On récupère le trajet lié
                'last_message' => $msg,
                'unread_count' => Message::where('from_user_id', $otherUser->id)
                                        ->where('to_user_id', $userId)
                                        // On filtre aussi par trip_id pour scinder le comptage non-lu
                                        ->where('trip_id', $msg->trip_id)
                                        ->where('is_read', false)
                                        ->count()
            ];
        });

        return view('messages.index', compact('formattedConversations'));
    }

    /**
     * Affiche la conversation avec un utilisateur spécifique.
     */
    public function show(User $user)
    {
        $authId = Auth::id();
        $tripId = request()->query('trip_id');

        // Empêcher de s'envoyer des messages à soi-même
        if ($user->id === $authId) {
            return redirect()->route('messages.index');
        }

        // Marquer les messages comme lus (pour ce trajet spécifique ou général)
        $updateQuery = Message::where('from_user_id', $user->id)
            ->where('to_user_id', $authId)
            ->where('is_read', false);
            
        if ($tripId) {
            $updateQuery->where('trip_id', $tripId);
        } else {
            $updateQuery->whereNull('trip_id');
        }
        
        $updateQuery->update(['is_read' => true]);

        // Récupérer l'historique de la conversation
        $messages = Message::where(function ($query) use ($authId, $user) {
            // Requête pour les messages entre les deux utilisateurs
            // (from = me AND to = other) OR (from = other AND to = me)
            $query->where(function ($q) use ($authId, $user) {
                $q->where('from_user_id', $authId)->where('to_user_id', $user->id);
            })
            ->orWhere(function ($q) use ($authId, $user) {
                $q->where('from_user_id', $user->id)->where('to_user_id', $authId);
            });
        })
        // AND (trip_id = x OR trip_id IS NULL based on context)
        ->where(function($q) use ($tripId) {
            if ($tripId) {
                $q->where('trip_id', $tripId);
            } else {
                $q->whereNull('trip_id');
            }
        })
        ->orderBy('created_at', 'asc')
        ->get();
            
        // Si un trip_id est fourni, on peut récupérer les infos du trajet pour l'affichage
        $trip = $tripId ? \App\Models\Trip::find($tripId) : null;

        return view('messages.show', compact('user', 'messages', 'trip'));
    }

    /**
     * Envoie un nouveau message.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $user->id,
            'content' => $request->content,
            'trip_id' => $request->trip_id, // Optionnel
        ]);

        // Notifier le destinataire
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'message',
            'message' => Auth::user()->first_name . ' ' . Auth::user()->last_name . ' vous a envoyé un message.',
            'is_read' => false,
        ]);

        return redirect()->route('messages.show', ['user' => $user->id, 'trip_id' => $request->trip_id])->with('success', 'Message envoyé');
    }
}
