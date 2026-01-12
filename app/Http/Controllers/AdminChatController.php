<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,staff']);
    }

    /**
     * Display all chat conversations
     */
    public function index()
    {
        // Get all users who have sent messages, with unread count
        $conversations = Chat::select('user_id')
            ->with('user')
            ->groupBy('user_id')
            ->get()
            ->map(function ($chat) {
                $unreadCount = Chat::where('user_id', $chat->user_id)
                                  ->where('sender_type', 'user')
                                  ->where('is_read', false)
                                  ->count();
                
                $lastMessage = Chat::where('user_id', $chat->user_id)
                                   ->latest()
                                   ->first();
                
                return [
                    'user' => $chat->user,
                    'unread_count' => $unreadCount,
                    'last_message' => $lastMessage,
                ];
            })->sortByDesc('last_message.created_at');
        
        return view('admin.chats.index', compact('conversations'));
    }

    /**
     * Display chat with specific user
     */
    public function show(User $user)
    {
        $chats = Chat::conversation($user->id)->get();
        
        // Mark all messages FROM user TO admin as read
        Chat::where('user_id', $user->id)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('admin.chats.show', compact('chats', 'user'));
    }

    /**
     * Admin reply to user
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::create([
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'admin',
            'is_read' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'chat' => $chat->load('admin'),
            ]);
        }

        return redirect()->route('admin.chats.show', $user)
                       ->with('success', 'Message sent successfully');
    }
}
