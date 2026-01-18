<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Check if already subscribed
        $existing = NewsletterSubscription::where('email', $validated['email'])->first();

        if ($existing) {
            // If previously unsubscribed, reactivate
            if ($existing->status === 'unsubscribed') {
                $existing->update([
                    'status' => 'active',
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null,
                ]);
                
                return response()->json([
                    'status' => true,
                    'message' => 'تم تفعيل اشتراكك بنجاح!',
                    'data' => $existing
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'هذا البريد الإلكتروني مشترك بالفعل.',
                'data' => null
            ], 409);
        }

        $subscription = NewsletterSubscription::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'شكراً لاشتراكك! سنرسل لك آخر الأخبار والتحديثات.',
            'data' => $subscription
        ], 201);
    }

    public function index()
    {
        $subscriptions = NewsletterSubscription::latest()->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Newsletter subscriptions retrieved successfully',
            'data' => $subscriptions
        ]);
    }
}
