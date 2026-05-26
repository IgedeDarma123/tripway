<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'name',
        'price',
        'original_price',
        'max_people',
        'description',
        'itinerary_items',
        'included',
        'excluded',
        'is_active',
        'sort_order',
        'travel_type',
        'sharing_price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'sharing_price' => 'decimal:2',
        'itinerary_items' => 'array',
        'is_active' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_id');
    }

    public function groups()
    {
        return $this->hasMany(TourPackageGroup::class)->orderBy('sort_order');
    }

    public function activeGroups()
    {
        return $this->hasMany(TourPackageGroup::class)->where('is_active', true)->orderBy('group_size');
    }

    public function addons()
    {
        return $this->hasMany(TourPackageAddon::class)->orderBy('sort_order');
    }

    public function activeAddons()
    {
        return $this->hasMany(TourPackageAddon::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function isPrivate(): bool
    {
        return in_array($this->travel_type, ['private', 'both']);
    }

    public function isSharing(): bool
    {
        return in_array($this->travel_type, ['sharing', 'both']);
    }

    public function discountPercentage()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }
}
