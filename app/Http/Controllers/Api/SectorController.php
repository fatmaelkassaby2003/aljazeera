<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use App\Models\SectorService;
use App\Models\SectorMethodology;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * عرض جميع القطاعات
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $limit = $request->query('limit');
        
        $query = Sector::with(['services', 'methodologies'])->orderBy('id', 'DESC');
        
        if ($limit && is_numeric($limit)) {
            $query->limit((int) $limit);
        }
        
        $sectors = $query->get()->map(fn($sector) => $this->transformSector($sector));

        return $this->successResponse($sectors);
    }

    /**
     * عرض قطاع معين
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $sector = Sector::with(['services', 'methodologies'])->find($id);

        if (!$sector) {
            return $this->errorResponse('القطاع غير موجود', 404);
        }

        return $this->successResponse($this->transformSector($sector));
    }

    /**
     * إضافة قطاع جديد
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateSector($request);
        
        $sector = Sector::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $this->handleImageUpload($request),
            'category_id' => $request->category_id ?? null
        ]);

        // إضافة الخدمات
        foreach ($validated['services'] as $service) {
            $sector->services()->create(['service' => $service]);
        }

        // إضافة المناهج
        foreach ($validated['methodologies'] as $methodology) {
            $sector->methodologies()->create($methodology);
        }

        return $this->successResponse(
            $this->transformSector($sector->load(['services', 'methodologies', 'category'])),
            'تم إضافة القطاع بنجاح',
            201
        );
    }

    /**
     * تحديث قطاع موجود (POST بدلاً من PUT لدعم الصور)
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $sector = Sector::find($id);

        if (!$sector) {
            return $this->errorResponse('القطاع غير موجود', 404);
        }

        // تحقق مرن يسمح بالتحديث الجزئي
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'services' => 'nullable|array|min:1',
            'services.*' => 'required_with:services|string',
            'methodologies' => 'nullable|array|min:1',
            'methodologies.*.title' => 'required_with:methodologies|string',
            'methodologies.*.description' => 'required_with:methodologies|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'nullable|exists:categories,id'
        ]);
        
        // تحديث الحقول الأساسية إذا وجدت
        if ($request->filled('name')) {
            $sector->name = $validated['name'];
        }
        if ($request->filled('description')) {
            $sector->description = $validated['description'];
        }
        if ($request->filled('category_id')) {
            $sector->category_id = $validated['category_id'];
        }
        
        // التعامل مع الصورة
        $newImage = $this->handleImageUpload($request, $sector);
        if ($newImage !== $sector->image) {
             $sector->image = $newImage;
        }
        $sector->save();

        // تحديث الخدمات إذا أرسلت (استبدال كامل)
        if ($request->has('services')) {
            $sector->services()->delete();
            foreach ($request->services as $service) {
                $sector->services()->create(['service' => $service]);
            }
        }

        // تحديث المناهج إذا أرسلت (استبدال كامل)
        if ($request->has('methodologies')) {
            $sector->methodologies()->delete();
            foreach ($request->methodologies as $methodology) {
                $sector->methodologies()->create($methodology);
            }
        }

        return $this->successResponse(
            $this->transformSector($sector->load(['services', 'methodologies'])),
            'تم تحديث القطاع بنجاح'
        );
    }

    /**
     * حذف قطاع
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $sector = Sector::find($id);

        if (!$sector) {
            return $this->errorResponse('القطاع غير موجود', 404);
        }

        $this->deleteImage($sector->image);
        $sector->delete(); // cascade will delete services and methodologies

        return $this->successResponse(null, 'تم حذف القطاع بنجاح');
    }


    /**
     * التحقق من صحة بيانات القطاع
     * 
     * @param Request $request
     * @return array
     */
    private function validateSector(Request $request): array
    {
        return $request->validate([
            'services' => 'required|array|min:1',
            'services.*' => 'required|string',
            'methodologies' => 'required|array|min:1',
            'methodologies.*.title' => 'required|string',
            'methodologies.*.description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'nullable|exists:categories,id'
        ]);
    }

    /**
     * التعامل مع رفع الصورة
     * 
     * @param Request $request
     * @param Sector|null $sector
     * @return string|null
     */
    private function handleImageUpload(Request $request, ?Sector $sector = null): ?string
    {
        if (!$request->hasFile('image')) {
            return $sector?->image;
        }

        // حذف الصورة القديمة
        if ($sector && $sector->image) {
            $this->deleteImage($sector->image);
        }

        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $imageName = time() . '_' . $safeName;
        
        $image->move(public_path('sectors'), $imageName);
        
        return 'sectors/' . $imageName;
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

    /**
     * تحويل بيانات القطاع للعرض
     * 
     * @param Sector $sector
     * @return array
     */
    private function transformSector(Sector $sector): array
    {
        return [
            'id' => $sector->id,
            'name' => $sector->name,
            'description' => $sector->description,
            'image_url' => $sector->image_url,
            'category' => $sector->category ? [
                'id' => $sector->category->id,
                'name' => $sector->category->name
            ] : null,
            'services' => $sector->services->pluck('service')->toArray(),
            'methodologies' => $sector->methodologies->map(fn($m) => [
                'title' => $m->title,
                'description' => $m->description
            ])->toArray()
        ];
    }
}
