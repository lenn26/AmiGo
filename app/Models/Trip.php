<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'TRIPS';

    protected $fillable = [
        'start_address',
        'start_lat',
        'start_long',
        'end_address',
        'end_lat',
        'end_long',
        'start_time',
        'end_time',
        'distance_km',
        'description',
        'price',
        'status',
        'girl_only',
        'accepts_pets',
        'accepts_luggage',
        'seats_available',
        'driver_id',
        'vehicle_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'girl_only' => 'boolean',
        'accepts_pets' => 'boolean',
        'accepts_luggage' => 'boolean',
        'price' => 'decimal:2',
        'start_lat' => 'decimal:6',
        'start_long' => 'decimal:6',
        'end_lat' => 'decimal:6',
        'end_long' => 'decimal:6',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
