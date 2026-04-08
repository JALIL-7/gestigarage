<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('client')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Message::with('client')->findOrFail($id);
        if ($message->statut === 'non_lu') {
            $message->update(['statut' => 'lu']);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function repondre(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $data = $request->validate(['reponse_admin' => 'required|string|max:3000']);
        $message->update([
            'reponse_admin' => $data['reponse_admin'],
            'statut' => 'repondu',
            'repondu_le' => now(),
        ]);

        return redirect()->route('admin.messages.index')->with('success', 'Réponse envoyée.');
    }

    public function destroy($id)
    {
        Message::findOrFail($id)->delete();

        return back()->with('success', 'Message supprimé.');
    }
}
