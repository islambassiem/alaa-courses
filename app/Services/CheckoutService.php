<?php

namespace App\Services;

use App\Models\Course;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutService
{
    private static function setUp(): void
    {
        /** @var string */
        $apiKey = config('services.stripe.secret');

        Stripe::setApiKey($apiKey);
    }

    public static function createCheckoutSession(Course $course, string $successUrl, string $cancelUrl): Session
    {
        self::setUp();

        return Session::create([
            'line_items' => [
                [
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => (int) ($course->price * 100),
                        'product_data' => [
                            'name' => $course->title,
                        ],
                    ],
                ],
            ],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'course_id' => (string) $course->id,
            ],
        ]);
    }
}
