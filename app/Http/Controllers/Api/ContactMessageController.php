<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $contactMessage = ContactMessage::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.',
            'data' => $contactMessage
        ], 201);
    }

    public function index()
    {
        $messages = ContactMessage::latest()->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Contact messages retrieved successfully',
            'data' => $messages
        ]);
    }

    public function show($id)
    {
        $message = ContactMessage::find($id);

        if (!$message) {
            return response()->json([
                'status' => false,
                'message' => 'Contact message not found',
                'data' => null
            ], 404);
        }

        // Mark as read when viewed
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Contact message retrieved successfully',
            'data' => $message
        ]);
    }
}
