<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'mobile',
        'referral_code',
        'sponsor_code',
        'position',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship with Role model.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relationship with Sponsor User by referral_code.
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_code', 'referral_code');
    }

    /**
     * Helper to check if user is Admin.
     */
    public function isAdmin(): bool
    {
        return $this->role_id === 1 || ($this->role && $this->role->slug === 'admin');
    }

    /**
     * Generate unique random referral code (e.g., NGF-0967542).
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = 'NGF-'.str_pad((string) rand(100000, 9999999), 7, '0', STR_PAD_LEFT);
        } while (static::where('referral_code', $code)->exists());

        return $code;
    }
}
