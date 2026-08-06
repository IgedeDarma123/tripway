<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['key' => 'whatsapp_number'],
            ['value' => '628983317309']
        );
    }
}
