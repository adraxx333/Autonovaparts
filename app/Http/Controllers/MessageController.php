<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:10',
        ]);

        $message = Message::create([
            'user_id' => Auth::user()->uuid,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Mensaje enviado correctamente',
            'data' => $message
        ], 201);
    }

    public function index()
    {
        $messages = Message::with('user')
            ->latest()
            ->get();

        return response()->json([
            'data' => $messages
        ]);
    }

    public function show(Message $message)
    {
        return response()->json([
            'data' => $message->load('user')
        ]);
    }

    public function destroy(Message $message)
    {
        // Verificar que el usuario es el propietario del mensaje
        if ($message->user_id !== Auth::user()->uuid) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar este mensaje'
            ], 403);
        }

        $message->delete();

        return response()->json([
            'message' => 'Mensaje eliminado correctamente'
        ]);
    }
}
