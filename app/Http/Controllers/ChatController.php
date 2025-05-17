<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Request as Req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
public function show($request_id)
{
    $request = Request::with(['murid.user', 'guru.user'])->findOrFail($request_id);
    $chats = Chat::where('request_id', $request_id)->orderBy('created_at')->get();

    return view('layouts.chat.index', compact('request', 'chats'));
}

public function send(Request $request)
{
    $chat = new Chat();
    $chat->request_id = $request->request_id;
    $chat->sender_id = auth()->id();
    $chat->message = $request->message;
    $chat->is_offer = $request->has('is_offer');
    $chat->save();

    return back();
}

}

