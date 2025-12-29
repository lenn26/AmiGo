<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $table = 'UNIVERSITIES';

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'type',
    ];
}
