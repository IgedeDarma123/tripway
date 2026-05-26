<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackageAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_package_id',
        'name',
        'description',
        'price',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }
}
