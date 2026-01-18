<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkMethodController extends Controller
{
    public function index(): JsonResponse
    {
        $workMethods = WorkMethod::all();

        return response()->json([
            'success' => true,
            'data' => $workMethods,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $workMethod = WorkMethod::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة طريقة العمل بنجاح',
            'data' => $workMethod,
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $workMethod = WorkMethod::find($id);

        if (!$workMethod) {
            return response()->json([
                'success' => false,
                'message' => 'طريقة العمل غير موجودة',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $workMethod,
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $workMethod = WorkMethod::find($id);

        if (!$workMethod) {
            return response()->json([
                'success' => false,
                'message' => 'طريقة العمل غير موجودة',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);

        $workMethod->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث طريقة العمل بنجاح',
            'data' => $workMethod,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $workMethod = WorkMethod::find($id);

        if (!$workMethod) {
            return response()->json([
                'success' => false,
                'message' => 'طريقة العمل غير موجودة',
            ], 404);
        }

        $workMethod->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف طريقة العمل بنجاح',
        ]);
    }
}
