<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BudgetRange;
use Illuminate\Http\Request;

class BudgetRangeController extends Controller
{
    /**
     * Get all active budget ranges
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $budgetRanges = BudgetRange::active()
            ->orderBy('min_amount', 'asc')
            ->get()
            ->map(function ($range) {
                return [
                    'id' => $range->id,
                    'label' => $range->label,
                    'min_amount' => $range->min_amount,
                    'max_amount' => $range->max_amount,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $budgetRanges,
        ]);
    }
}
