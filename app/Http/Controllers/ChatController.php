<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display chat interface
     */
    public function index()
    {
        $chats = Chat::conversation(auth()->id())->get();
        
        // Mark all messages FROM admin TO this user as read
        Chat::where('user_id', auth()->id())
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('chat.index', compact('chats'));
    }

    /**
     * Send a message
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
            'is_read' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.chat.sent'),
                'chat' => $chat->load('user'),
            ]);
        }

        return redirect()->route('chat.index')
                       ->with('success', __('messages.chat.sent'));
    }

    /**
     * Get messages via AJAX
     */
    public function getMessages()
    {
        $chats = Chat::conversation(auth()->id())->get();
        
        // Mark unread messages as read
        Chat::where('user_id', auth()->id())
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json($chats);
    }
}
