<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\TourPackage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('packages:deduplicate-itinerary', function () {
    $packages = TourPackage::all();
    $total = $packages->count();
    $fixed = 0;

    foreach ($packages as $package) {
        $items = $package->itinerary_items['items'] ?? null;
        if (!is_array($items) || count($items) === 0) {
            continue;
        }

        $unique = [];
        $seen = [];
        foreach ($items as $item) {
            $key = ($item['time'] ?? '') . '__' . ($item['desc'] ?? '') . '__' . ($item['photo'] ?? '');
            if (!in_array($key, $seen)) {
                $seen[] = $key;
                $unique[] = $item;
            }
        }

        if (count($unique) < count($items)) {
            $package->itinerary_items = ['items' => $unique];
            $package->save();
            $fixed++;
            $this->info("Fixed package ID {$package->id}: " . count($items) . " -> " . count($unique) . " items");
        }
    }

    $this->info("Done. Processed {$total} packages, fixed {$fixed} packages with duplicates.");
})->purpose('Remove duplicate itinerary items from tour packages');
