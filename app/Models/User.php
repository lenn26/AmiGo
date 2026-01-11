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

    protected $appends = [
        'average_rating',
        'ratings_count',
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

    // Obtenir la moyenne des notes reçues
    public function getAverageRatingAttribute()
    {
        $avg = $this->ratingsReceived()->avg('rating');

        // Par défaut, on retourne 5 si aucune note n'est disponible
        // On formate avec une virgule et une décimale
        return number_format((float) ($avg ?: 5), 1, ',', '');
    }

    public function getRatingsCountAttribute()
    {
        return $this->ratingsReceived()->count();
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
