<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'RATINGS';

    protected $fillable = [
        'rating',
        'comment',
        'trip_id',
        'rated_id',
        'rater_id',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function ratedUser()
    {
        return $this->belongsTo(User::class, 'rated_id');
    }

    public function raterUser()
    {
        return $this->belongsTo(User::class, 'rater_id');
    }
}
