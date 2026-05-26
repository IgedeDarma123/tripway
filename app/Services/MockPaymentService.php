<?php

namespace App\Services;

use App\Models\Booking;

/**
 * Mock Payment Service for testing purposes
 * This creates a fake payment token without connecting to actual Midtrans API
 * Use this for local development and testing only
 */
class MockPaymentService
{
    public static function init()
    {
        // No initialization needed for mock
    }

    public static function createSnapToken(Booking $booking)
    {
        // Generate a fake snap token for testing
        $fakeToken = 'mock_token_' . time() . '_' . $booking->id . '_' . bin2hex(random_bytes(8));
        
        $orderId = 'MOCK' . time() . $booking->id;

        $booking->update([
            'snap_token' => $fakeToken,
            'order_id' => $orderId,
        ]);

        return $fakeToken;
    }

    public static function isMockEnabled()
    {
        return config('midtrans.mock_enabled', true);
    }
}
