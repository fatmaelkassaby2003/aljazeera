<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialService;
use Illuminate\Http\Request;

class FinancialServiceController extends Controller
{
    public function index()
    {
        $service = FinancialService::first();
        
        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'No financial service found',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Financial service retrieved successfully',
            'data' => $service
        ]);
    }

    public function show($id)
    {
        $service = FinancialService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Financial service not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Financial service retrieved successfully',
            'data' => $service
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'important_note' => 'nullable|string',
            'types' => 'nullable|array',
            'work_mechanism' => 'nullable|array',
            'financial_periods' => 'nullable|array',
            'icon' => 'nullable|string',
        ]);

        $service = FinancialService::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Financial service created successfully',
            'data' => $service
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $service = FinancialService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Financial service not found',
                'data' => null
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'important_note' => 'nullable|string',
            'types' => 'nullable|array',
            'work_mechanism' => 'nullable|array',
            'financial_periods' => 'nullable|array',
            'icon' => 'nullable|string',
        ]);

        $service->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Financial service updated successfully',
            'data' => $service
        ]);
    }

    public function destroy($id)
    {
        $service = FinancialService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Financial service not found',
                'data' => null
            ], 404);
        }

        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Financial service deleted successfully',
            'data' => null
        ]);
    }
}
