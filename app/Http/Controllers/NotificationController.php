<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Afficher toutes les notifications de l'utilisateur
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Notifications avec des liens de redirection si possible
        $notifications->getCollection()->transform(function ($notification) {
            $notification->action_url = null;

            if ($notification->type === 'message') {
                // On essaie de retrouver le message correspondant via l'heure de création
                // Le message est créé juste avant la notification
                $message = \App\Models\Message::where('to_user_id', $notification->user_id)
                    ->where('created_at', '<=', $notification->created_at->addSeconds(1)) // Tolérance légère
                    ->where('created_at', '>=', $notification->created_at->subSeconds(15)) // Fenêtre de 15s
                    ->latest()
                    ->first();
                
                if ($message) {
                    $url = route('messages.show', ['user' => $message->from_user_id]);
                    if ($message->trip_id) {
                        $url .= '?trip_id=' . $message->trip_id;
                    }
                    $notification->action_url = $url;
                }
            }

            return $notification;
        });

        return view('notifications', compact('notifications'));
    }

    // Marquer une notification comme lue
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return back();
    }

    // Marquer toutes les notifications comme lues
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    // Obtenir le nombre de notifications non lues (pour le badge)
    public function getUnreadCount()
    {
        return Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }
}
