<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FacilityService;
use Illuminate\Http\Request;
use App\Http\Resources\FacilityServiceResource;

class FacilityServiceController extends Controller
{
    public function index()
    {
        $service = FacilityService::first();
        
        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'No facility service found',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Facility service retrieved successfully',
            'data' => new FacilityServiceResource($service)
        ]);
    }

    public function show($id)
    {
        $service = FacilityService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Facility service not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Facility service retrieved successfully',
            'data' => new FacilityServiceResource($service)
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

        $service = FacilityService::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Facility service created successfully',
            'data' => $service
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $service = FacilityService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Facility service not found',
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
            'message' => 'Facility service updated successfully',
            'data' => $service
        ]);
    }

    public function destroy($id)
    {
        $service = FacilityService::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Facility service not found',
                'data' => null
            ], 404);
        }

        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Facility service deleted successfully',
            'data' => null
        ]);
    }
}
