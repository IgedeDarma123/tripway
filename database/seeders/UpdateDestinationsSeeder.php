<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class UpdateDestinationsSeeder extends Seeder
{
    public function run(): void
    {
        $coords = [
            ['slug' => 'ubud', 'latitude' => -8.515078, 'longitude' => 115.263093],
            ['slug' => 'seminyak', 'latitude' => -8.6886, 'longitude' => 115.1686],
            ['slug' => 'uluwatu', 'latitude' => -8.5299, 'longitude' => 115.0897],
            ['slug' => 'nusa-penida', 'latitude' => -8.7218, 'longitude' => 115.4455],
            ['slug' => 'kuta', 'latitude' => -8.7351, 'longitude' => 115.1703],
            ['slug' => 'canggu', 'latitude' => -8.6531, 'longitude' => 115.1278],
        ];

        foreach ($coords as $coord) {
            $dest = Destination::where('slug', $coord['slug'])->first();
            if ($dest) {
                $dest->update([
                    'latitude' => $coord['latitude'],
                    'longitude' => $coord['longitude'],
                ]);
            }
        }
    }
}

