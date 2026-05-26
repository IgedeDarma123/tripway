<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::with(['category', 'destination', 'activePackages'])->where('is_active', true);

        if ($request->filled('destination')) {
            $query->whereHas('destination', function ($q) use ($request) {
                $q->where('slug', $request->destination);
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%')
                  ->orWhereHas('destination', fn($d) => $d->where('name', 'like', '%' . $keyword . '%'))
                  ->orWhereHas('category', fn($c) => $c->where('name', 'like', '%' . $keyword . '%'));
            });
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'rating' => $query->orderBy('rating', 'desc'),
                'popular' => $query->orderBy('review_count', 'desc'),
                default => $query->orderBy('created_at', 'desc'),
            };
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tours = $query->paginate(12);
        $categories = Category::orderBy('sort_order')->get();
        $destinations = Destination::all();

        return view('tours.index', compact('tours', 'categories', 'destinations'));
    }

    public function show($slug)
    {
        $tour = Tour::with(['category', 'destination', 'activePackages.groups' => fn($q) => $q->where('is_active', true)->orderBy('group_size'), 'activePackages.addons' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')])->where('slug', $slug)->firstOrFail();
        $relatedTours = Tour::with(['category', 'destination'])
            ->where('is_active', true)
            ->where('id', '!=', $tour->id)
            ->where(function ($q) use ($tour) {
                $q->where('category_id', $tour->category_id)
                  ->orWhere('destination_id', $tour->destination_id);
            })
            ->take(4)
            ->get();

        return view('tours.show', compact('tour', 'relatedTours'));
    }

    public function packages(Tour $tour)
    {
        return response()->json($tour->activePackages);
    }
}

