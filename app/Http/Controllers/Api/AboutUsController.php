<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();

        if (!$aboutUs) {
            return response()->json([
                'status' => true,
                'message' => 'No data found',
                'data' => null
            ]);
        }

        $data = $aboutUs->toArray();
        if ($aboutUs->image) {
            $data['image'] = asset($aboutUs->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'About Us data retrieved successfully',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // Since we only want one record, we can check if it exists and update, or create
        $aboutUs = AboutUs::first();

        $validated = $request->validate([
            'image' => 'nullable|file|image',
            'description' => 'nullable|string',
            'vision' => 'nullable|array',
            'vision.*.point' => 'required|string',
            'mission' => 'nullable|array',
            'mission.*.point' => 'required|string',
            'values' => 'nullable|array',
            'values.*.point' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('about-us', 'public');
        }

        if ($aboutUs) {
            $aboutUs->update($validated);
        } else {
            $aboutUs = AboutUs::create($validated);
        }

        $data = $aboutUs->toArray();
        if ($aboutUs->image) {
            $data['image'] = asset($aboutUs->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'About Us data updated successfully',
            'data' => $data
        ]);
    }
}
