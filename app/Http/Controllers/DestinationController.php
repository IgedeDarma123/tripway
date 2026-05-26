<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function show(Destination $destination)
    {
        $packages = $destination->tours()
            ->where('is_active', true)
            ->with('category')
            ->get()
            ->map(function ($tour) {
                return [
                    'nama' => $tour->title,
                    'harga' => $tour->price,
                    'diskon' => $tour->original_price ? round((1 - $tour->price / $tour->original_price) * 100) : 0,
                    'max_grup' => $tour->max_people,
                    'slug' => $tour->slug
                ];
            });

        $addons = [
            ['nama' => 'Sewa Skuter', 'harga' => 150000],
            ['nama' => 'Peralatan Snorkeling', 'harga' => 50000],
            ['nama' => 'Lunch Box', 'harga' => 75000]
        ];

        return view('destinations.show', compact('destination', 'packages', 'addons'));
    }
}

