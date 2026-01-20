<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        if (isset($data['types']) && is_array($data['types'])) {
            foreach ($data['types'] as &$type) {
                if (isset($type['images']) && is_array($type['images'])) {
                    $type['images'] = array_map(function ($image) {
                        return asset($image);
                    }, $type['images']);
                }
            }
        }

        return $data;
    }
}
