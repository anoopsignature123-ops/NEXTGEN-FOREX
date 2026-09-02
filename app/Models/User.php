<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'deposit_wallet',
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
            'deposit_wallet' => 'decimal:2',
        ];
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function userPackages(): HasMany
    {
        return $this->hasMany(UserPackage::class);
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
     * Relationship for all direct referrals sponsored by this user.
     */
    public function directMembers(): HasMany
    {
        return $this->hasMany(User::class, 'sponsor_code', 'referral_code');
    }

    /**
     * Direct Left Child node in binary tree.
     */
    public function leftChild(): ?User
    {
        return User::where('sponsor_code', $this->referral_code)->where('position', 'left')->first();
    }

    /**
     * Direct Right Child node in binary tree.
     */
    public function rightChild(): ?User
    {
        return User::where('sponsor_code', $this->referral_code)->where('position', 'right')->first();
    }

    /**
     * Get Left leg team stats (Active, Inactive, Total Count, Business Volume).
     */
    public function getLeftLegStatsAttribute(): array
    {
        $leftDirects = User::where('sponsor_code', $this->referral_code)->where('position', 'left')->get();
        $active = $leftDirects->where('status', 'active')->count();
        $inactive = $leftDirects->where('status', 'inactive')->count();
        $total = $leftDirects->count();
        $business = $active * 1000;

        return [
            'active' => $active,
            'inactive' => $inactive,
            'total' => $total,
            'business' => '$'.number_format($business, 2),
            'raw_business' => $business,
        ];
    }

    /**
     * Get Right leg team stats (Active, Inactive, Total Count, Business Volume).
     */
    public function getRightLegStatsAttribute(): array
    {
        $rightDirects = User::where('sponsor_code', $this->referral_code)->where('position', 'right')->get();
        $active = $rightDirects->where('status', 'active')->count();
        $inactive = $rightDirects->where('status', 'inactive')->count();
        $total = $rightDirects->count();
        $business = $active * 1000;

        return [
            'active' => $active,
            'inactive' => $inactive,
            'total' => $total,
            'business' => '$'.number_format($business, 2),
            'raw_business' => $business,
        ];
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
