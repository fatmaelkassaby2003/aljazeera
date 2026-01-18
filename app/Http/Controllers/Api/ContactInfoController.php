<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first();

        if (!$contactInfo) {
            return response()->json([
                'status' => false,
                'message' => 'Contact information not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Contact information retrieved successfully',
            'data' => $contactInfo
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string',
        ]);

        // Delete existing record and create new one (singleton pattern)
        ContactInfo::query()->delete();
        $contactInfo = ContactInfo::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Contact information saved successfully',
            'data' => $contactInfo
        ]);
    }
}
