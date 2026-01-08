<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'REPORTS';

    protected $fillable = [
        'reason',
        'description',
        'status',
        'trip_id',
        'reported_user_id',
        'reporter_id',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
