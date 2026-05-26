<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourPackage;

class DeduplicatePackageItinerary extends Command
{
    protected $signature = 'packages:deduplicate-itinerary';
    protected $description = 'Remove duplicate itinerary items from tour packages';

    public function handle()
    {
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
        return 0;
    }
}
