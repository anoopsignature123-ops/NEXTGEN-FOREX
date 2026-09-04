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
        'wallet_address',
        'referral_code',
        'sponsor_code',
        'position',
        'status',
        'deposit_wallet',
        'earning_wallet',
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
            'activated_at' => 'datetime',
            'password' => 'hashed',
            'deposit_wallet' => 'decimal:2',
            'earning_wallet' => 'decimal:2',
        ];
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
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
     * Direct Left Child node in tree graph (First direct referral or position='left').
     */
    public function leftChild(): ?User
    {
        return User::where('sponsor_code', $this->referral_code)
            ->orderByRaw("CASE WHEN position = 'left' THEN 0 ELSE 1 END")
            ->orderBy('id', 'asc')
            ->first();
    }

    /**
     * Direct Right Child node in tree graph (Second direct referral or position='right').
     */
    public function rightChild(): ?User
    {
        $left = $this->leftChild();

        return User::where('sponsor_code', $this->referral_code)
            ->when($left, function ($q) use ($left) {
                $q->where('id', '!=', $left->id);
            })
            ->orderByRaw("CASE WHEN position = 'right' THEN 0 ELSE 1 END")
            ->orderBy('id', 'asc')
            ->first();
    }

    /**
     * Get Left leg team stats (Active, Inactive, Total Count, Business Volume).
     */
    public function getLeftLegStatsAttribute(): array
    {
        $allDirects = User::where('sponsor_code', $this->referral_code)->get();
        $leftDirects = $allDirects->filter(function ($u, $index) {
            return strtolower((string) $u->position) === 'left' || (empty($u->position) && $index % 2 === 0);
        });

        $active = $leftDirects->where('status', 'active')->count();
        $inactive = $leftDirects->where('status', 'inactive')->count();
        $total = $leftDirects->count();
        $business = UserPackage::whereIn('user_id', $leftDirects->pluck('id'))->where('status', 'active')->sum('invested_amount');

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
        $allDirects = User::where('sponsor_code', $this->referral_code)->get();
        $rightDirects = $allDirects->filter(function ($u, $index) {
            return strtolower((string) $u->position) === 'right' || (empty($u->position) && $index % 2 !== 0);
        });

        $active = $rightDirects->where('status', 'active')->count();
        $inactive = $rightDirects->where('status', 'inactive')->count();
        $total = $rightDirects->count();
        $business = UserPackage::whereIn('user_id', $rightDirects->pluck('id'))->where('status', 'active')->sum('invested_amount');

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
