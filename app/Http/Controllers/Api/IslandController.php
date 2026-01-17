<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Island;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IslandController extends Controller
{
    /**
     * عرض معلومات الجزيرة
     * 
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $island = Island::first();

        if (!$island) {
            return $this->errorResponse('لا توجد بيانات للجزيرة', 404);
        }

        return $this->successResponse($this->transformIsland($island));
    }

    /**
     * إضافة أو تعديل معلومات الجزيرة
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function createOrUpdate(Request $request): JsonResponse
    {
        $island = Island::first();

        if ($island) {
            // منطق التحديث الجزئي
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'highlights' => 'nullable|array|min:1',
                'highlights.*' => 'required_with:highlights|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            if ($request->filled('name')) {
                $island->name = $validated['name'];
            }
            if ($request->filled('description')) {
                $island->description = $validated['description'];
            }
            if ($request->has('highlights')) {
                $island->highlights = $validated['highlights'];
            }

            $newImage = $this->handleImageUpload($request, $island);
            if ($newImage !== $island->image) {
                $island->image = $newImage;
            }
            
            $island->save();
            $message = 'تم تحديث بيانات الجزيرة بنجاح';
        } else {
            // منطق الإنشاء (مطلوب بالكامل)
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'highlights' => 'required|array|min:1',
                'highlights.*' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            $island = Island::create([
                ...$validated,
                'image' => $this->handleImageUpload($request)
            ]);
            $message = 'تم إضافة الجزيرة بنجاح';
        }

        return $this->successResponse(
            $this->transformIsland($island->fresh()),
            $message
        );
    }

    /**
     * تحويل بيانات الجزيرة للعرض
     * 
     * @param Island $island
     * @return array
     */
    private function transformIsland(Island $island): array
    {
        return [
            'name' => $island->name,
            'description' => $island->description,
            'highlights' => $island->highlights,
            'image_url' => $island->image_url
        ];
    }

    /**
     * التحقق من صحة بيانات الجزيرة
     * 
     * @param Request $request
     * @return array
     */
    private function validateIsland(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'highlights' => 'required|array|min:1',
            'highlights.*' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);
    }

    /**
     * التعامل مع رفع الصورة
     * 
     * @param Request $request
     * @param Island|null $island
     * @return string|null
     */
    private function handleImageUpload(Request $request, ?Island $island = null): ?string
    {
        if (!$request->hasFile('image')) {
            return $island?->image;
        }

        // حذف الصورة القديمة
        if ($island && $island->image) {
            $this->deleteImage($island->image);
        }

        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $imageName = time() . '_' . $safeName;
        
        $image->move(public_path('islands'), $imageName);
        
        return 'islands/' . $imageName;
    }

    /**
     * حذف صورة من المجلد
     * 
     * @param string|null $imagePath
     * @return void
     */
    private function deleteImage(?string $imagePath): void
    {
        if ($imagePath) {
            $fullPath = public_path($imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    /**
     * استجابة ناجحة
     * 
     * @param mixed $data
     * @param string|null $message
     * @param int $status
     * @return JsonResponse
     */
    private function successResponse($data = null, ?string $message = null, int $status = 200): JsonResponse
    {
        $response = ['success' => true];
        
        if ($message) {
            $response['message'] = $message;
        }
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        return response()->json($response, $status);
    }

    /**
     * استجابة خطأ
     * 
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    private function errorResponse(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $status);
    }
}
