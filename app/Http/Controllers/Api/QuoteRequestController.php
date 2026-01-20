<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'service_type' => 'required|in:financial,integration,facility',
            'budget_range_id' => 'nullable|exists:budget_ranges,id',
            'project_description' => 'required|string',
        ]);

        $quoteRequest = QuoteRequest::create($validated);
        
        // Load budget range relationship
        $quoteRequest->load('budgetRange');

        return response()->json([
            'status' => true,
            'message' => 'تم إرسال طلب عرض السعر بنجاح. سنتواصل معك قريباً.',
            'data' => $quoteRequest
        ], 201);
    }

    public function index()
    {
        $requests = QuoteRequest::with('budgetRange')->latest()->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Quote requests retrieved successfully',
            'data' => $requests
        ]);
    }

    public function show($id)
    {
        $quoteRequest = QuoteRequest::with('budgetRange')->find($id);

        if (!$quoteRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Quote request not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Quote request retrieved successfully',
            'data' => $quoteRequest
        ]);
    }
}
