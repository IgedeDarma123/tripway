<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort_order')->get();
        $destinations = Destination::withCount('tours')->take(6)->get();
        $popularTours = Tour::with(['category', 'destination', 'activePackages'])
            ->where('is_active', true)
            ->orderBy('review_count', 'desc')
            ->take(8)
            ->get();
        $featuredTours = Tour::with(['category', 'destination', 'activePackages'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)
            ->get();

        return view('landing', compact('categories', 'destinations', 'popularTours', 'featuredTours'));
    }
}

