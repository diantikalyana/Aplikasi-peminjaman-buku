<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all notifications for logged-in user
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications (for dropdown/modal)
     */
    public function unread()
    {
        $user = Auth::user();
        $unreadCount = $user->unreadNotificationsCount();
        $unreadNotifications = $user->unreadNotifications()->limit(10)->get();

        return response()->json([
            'count' => $unreadCount,
            'notifications' => $unreadNotifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markRead($id)
    {
        $notification = Notification::find($id);
        
        if ($notification && $notification->user_id == Auth::id()) {
            $notification->update(['is_read' => true]);
            
            // Show alert with notification details
            $message = "Notifikasi: {$notification->title}\n\n{$notification->message}";
            
            return back()->with('notification_read', $message);
        }
        
        return back();
    }

    /**
     * Mark all as read
     */
    public function markAllRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);
        
        if ($notification && $notification->user_id == Auth::id()) {
            $notification->delete();
            return back()->with('success', 'Notifikasi dihapus.');
        }
        
        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }

    /**
     * Delete all notifications
     */
    public function destroyAll()
    {
        Auth::user()->notifications()->delete();
        return back()->with('success', 'Semua notifikasi telah dihapus.');
    }
}
