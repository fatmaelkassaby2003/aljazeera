<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IntegrationService;
use Illuminate\Http\Request;
use App\Http\Resources\IntegrationServiceResource;

class IntegrationServiceController extends Controller
{
    public function index()
    {
        $service = IntegrationService::first();
        
        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'No integration service found',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Integration service retrieved successfully',
            'data' => new IntegrationServiceResource($service)
        ]);
    }

    public function show($id)
    {
        $service = IntegrationService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Integration service not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Integration service retrieved successfully',
            'data' => new IntegrationServiceResource($service)
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
            'icon' => 'nullable|string',
        ]);

        $service = IntegrationService::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Integration service created successfully',
            'data' => $service
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $service = IntegrationService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Integration service not found',
                'data' => null
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'important_note' => 'nullable|string',
            'types' => 'nullable|array',
            'icon' => 'nullable|string',
        ]);

        $service->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Integration service updated successfully',
            'data' => $service
        ]);
    }

    public function destroy($id)
    {
        $service = IntegrationService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Integration service not found',
                'data' => null
            ], 404);
        }

        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Integration service deleted successfully',
            'data' => null
        ]);
    }
}
