<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'USERS';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'bio',
        'avatar',
        'is_verified',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Récupère les attributs qui doivent être convertis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Détermine si l'utilisateur a vérifié son adresse email.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return $this->is_verified;
    }

    /**
     * Marque l'email de l'utilisateur donné comme vérifié.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'is_verified' => true,
        ])->save();
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'rated_id');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ratingsReceived()->avg('rating'), 1) ?: 5.0;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'passenger_id');
    }
}
