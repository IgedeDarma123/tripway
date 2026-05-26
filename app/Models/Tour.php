<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'highlights',
        'itinerary',
        'inclusions',
        'exclusions',
        'duration',
        'duration_type',
        'price',
        'original_price',
        'image',
        'gallery',
        'rating',
        'review_count',
        'category_id',
        'destination_id',
        'max_people',
        'min_people',
        'itinerary_items',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'gallery' => 'array',
        'itinerary_items' => 'array',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'float',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function packages()
    {
        return $this->hasMany(TourPackage::class)->orderBy('sort_order');
    }

    public function activePackages()
    {
        return $this->hasMany(TourPackage::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function recalculateRating()
    {
        $avg = $this->reviews()->avg('rating') ?? 0;
        $count = $this->reviews()->count();
        $this->update([
            'rating' => round($avg, 1),
            'review_count' => $count,
        ]);
    }

    public function discountPercentage()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function lowestPrice()
    {
        // Cek harga terendah dari packages aktif
        $lowestPackage = $this->activePackages->min('price');
        if ($lowestPackage) {
            return $lowestPackage;
        }
        return $this->price;
    }
}

