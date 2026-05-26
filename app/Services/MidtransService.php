<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;

class MidtransService
{
    public static function init()
    {
        // Try to get from config, otherwise use fallback test keys
        $serverKey = config('midtrans.server_key') ?: 'SB-Mid-server-Test-Key-Valid';
        $clientKey = config('midtrans.client_key') ?: 'SB-Mid-client-Test-Key-Valid';
        
        Config::$serverKey = $serverKey;
        Config::$clientKey = $clientKey;
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public static function createSnapToken(Booking $booking)
    {
        self::init();

        $transactionDetails = [
            'order_id' => 'TRIP' . time() . $booking->id,
            'gross_amount' => (int) $booking->total_price,
        ];

        $customerDetails = [
            'first_name' => $booking->contact_name,
            'email' => $booking->contact_email,
            'phone' => $booking->contact_phone,
        ];

        $itemDetails = [
            [
                'id' => 'TOUR-' . $booking->tour_id,
                'price' => (int) $booking->tour->price,
                'quantity' => $booking->adults + $booking->children,
                'name' => $booking->tour->title . ' - ' . $booking->travel_date->format('d/m/Y'),
            ]
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        $snapToken = Snap::getSnapToken($params);

        $booking->update([
            'snap_token' => $snapToken,
            'order_id' => $transactionDetails['order_id'],
        ]);

        return $snapToken;
    }
}

