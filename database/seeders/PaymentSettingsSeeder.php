<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSetting;

class PaymentSettingsSeeder extends Seeder
{
    public function run()
    {
        $methods = [
            [
                'method' => 'qris',
                'name' => 'QRIS',
                'account_number' => null,
                'account_name' => null,
                'image' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'method' => 'bca',
                'name' => 'BCA VA',
                'account_number' => '779912345678',
                'account_name' => 'TripWay Tour',
                'image' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'method' => 'bni',
                'name' => 'BNI VA',
                'account_number' => '8812345678',
                'account_name' => 'TripWay Tour',
                'image' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'method' => 'mandiri',
                'name' => 'Mandiri VA',
                'account_number' => '1234567890',
                'account_name' => 'TripWay Tour',
                'image' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'method' => 'bri',
                'name' => 'BRI VA',
                'account_number' => '12345678901',
                'account_name' => 'TripWay Tour',
                'image' => null,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'method' => 'gopay',
                'name' => 'GoPay',
                'account_number' => '081234567890',
                'account_name' => 'TripWay Tour',
                'image' => null,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'method' => 'ovo',
                'name' => 'OVO',
                'account_number' => '081234567890',
                'account_name' => 'TripWay Tour',
                'image' => null,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'method' => 'dana',
                'name' => 'DANA',
                'account_number' => '081234567890',
                'account_name' => 'TripWay Tour',
                'image' => null,
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($methods as $method) {
            PaymentSetting::updateOrCreate(
                ['method' => $method['method']],
                $method
            );
        }
    }
}
