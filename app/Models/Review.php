<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'user_name',
        'user_email',
        'rating',
        'comment',
        'photos',
        'is_fake',
        'reviewed_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_fake' => 'boolean',
        'reviewed_at' => 'datetime',
        'photos' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

