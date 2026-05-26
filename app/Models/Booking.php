<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_id',
        'package_id',
        'package_type',
        'quantity',
        'travel_date',
        'adults',
        'children',
        'total_price',
        'snap_token',
        'payment_status',
        'payment_type',
        'order_id',
        'pdf_url',
        'status',
        'special_requests',
        'contact_name',
        'contact_email',
        'contact_phone',
        'payment_proof',
        'payment_confirmed_at',
        'travel_type',
        'group_option_id',
        'num_persons',
        'addon_ids',
        'addon_price',
    ];

    protected $casts = [
        'travel_date'          => 'date',
        'total_price'          => 'decimal:2',
        'addon_ids'            => 'array',
        'addon_price'          => 'decimal:2',
        'payment_confirmed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }

    public function groupOption()
    {
        return $this->belongsTo(TourPackageGroup::class, 'group_option_id');
    }
}

