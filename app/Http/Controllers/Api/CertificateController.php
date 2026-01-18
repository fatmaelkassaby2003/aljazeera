<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::all()->map(function ($certificate) {
            return [
                'id' => $certificate->id,
                'name' => $certificate->name,
                'image' => asset($certificate->image),
                'issue_date' => $certificate->issue_date,
                'issuing_authority' => $certificate->issuing_authority,
            ];
        });

        return response()->json([
            'status' => 200,
            'data' => $certificates,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'issue_date' => 'nullable|date',
            'issuing_authority' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('certificates', 'public');

        $certificate = Certificate::create([
            'name' => $request->name,
            'image' => $imagePath,
            'issue_date' => $request->issue_date,
            'issuing_authority' => $request->issuing_authority,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Certificate created successfully',
            'data' => $certificate,
        ]);
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::find($id);

        if (!$certificate) {
            return response()->json(['status' => 404, 'message' => 'Certificate not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'issue_date' => 'nullable|date',
            'issuing_authority' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('certificates', 'public');
            $certificate->image = $imagePath;
        }

        if ($request->has('name')) {
            $certificate->name = $request->name;
        }
        if ($request->has('issue_date')) {
            $certificate->issue_date = $request->issue_date;
        }
        if ($request->has('issuing_authority')) {
            $certificate->issuing_authority = $request->issuing_authority;
        }

        $certificate->save();

        return response()->json([
            'status' => 200,
            'message' => 'Certificate updated successfully',
            'data' => $certificate,
        ]);
    }

    public function destroy($id)
    {
        $certificate = Certificate::find($id);

        if (!$certificate) {
            return response()->json(['status' => 404, 'message' => 'Certificate not found'], 404);
        }

        $certificate->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Certificate deleted successfully',
        ]);
    }
}
