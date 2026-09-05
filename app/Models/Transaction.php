<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'txn_number',
        'wallet_type',
        'amount',
        'charge',
        'post_balance',
        'trx_type',
        'type',
        'description',
        'reference_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'charge' => 'decimal:2',
            'post_balance' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the transaction log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the referenced user package if applicable.
     */
    public function userPackage(): BelongsTo
    {
        return $this->belongsTo(UserPackage::class, 'reference_id');
    }

    /**
     * Dynamic accessor for source member who generated/purchased for this commission.
     */
    public function getSourceMemberAttribute(): ?User
    {
        if ($this->type === 'direct_commission' && $this->relationLoaded('userPackage') && $this->userPackage && $this->userPackage->user) {
            return $this->userPackage->user;
        }

        if ($this->type === 'direct_commission' && ! empty($this->description)) {
            if (preg_match('/\((NGF-[A-Z0-9]+|\bNG[A-Z0-9]+\b)\)/i', $this->description, $matches)) {
                return User::where('referral_code', strtoupper($matches[1]))->first();
            }
        }

        return null;
    }
}
