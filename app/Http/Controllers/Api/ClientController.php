<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * عرض جميع العملاء
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $clients = Client::orderBy('id', 'DESC')
            ->get()
            ->map(fn($client) => $this->transformClient($client));

        return $this->successResponse($clients);
    }

    /**
     * إضافة عميل جديد
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        // رفع اللوجو
        $logo = $request->file('logo');
        $originalName = $logo->getClientOriginalName();
        // تنظيف الاسم من المسافات والرموز
        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $logoName = time() . '_' . $safeName;
        
        $logo->move(public_path('clients'), $logoName);

        $client = Client::create([
            'name' => $validated['name'],
            'logo' => 'clients/' . $logoName
        ]);

        return $this->successResponse(
            $this->transformClient($client),
            'تم إضافة العميل بنجاح',
            201
        );
    }

    /**
     * تحديث عميل موجود (POST لدعم الصور)
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return $this->errorResponse('العميل غير موجود', 404);
        }

        // جعل الحقول اختيارية للتعديل الجزئي
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        // تحديث اللوجو إذا تم رفع واحد جديد
        if ($request->hasFile('logo')) {
            // حذف اللوجو القديم
            $this->deleteLogo($client->logo);

            $logo = $request->file('logo');
            $originalName = $logo->getClientOriginalName();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
            $logoName = time() . '_' . $safeName;
            
            $logo->move(public_path('clients'), $logoName);
            $client->logo = 'clients/' . $logoName;
        }

        // تحديث الاسم فقط إذا تم إرساله
        if ($request->filled('name')) {
            $client->name = $validated['name'];
        }

        $client->save();

        return $this->successResponse(
            $this->transformClient($client),
            'تم تحديث العميل بنجاح'
        );
    }

    /**
     * حذف عميل
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return $this->errorResponse('العميل غير موجود', 404);
        }

        $this->deleteLogo($client->logo);
        $client->delete();

        return $this->successResponse(null, 'تم حذف العميل بنجاح');
    }

    /**
     * تحويل بيانات العميل للعرض
     * 
     * @param Client $client
     * @return array
     */
    private function transformClient(Client $client): array
    {
        return [
            'id' => $client->id,
            'name' => $client->name,
            'logo_url' => $client->logo_url
        ];
    }

    /**
     * حذف لوجو من المجلد
     * 
     * @param string|null $logoPath
     * @return void
     */
    private function deleteLogo(?string $logoPath): void
    {
        if ($logoPath) {
            $fullPath = public_path($logoPath);
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
