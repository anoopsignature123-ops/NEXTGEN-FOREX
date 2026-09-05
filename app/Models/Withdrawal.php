<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trx_number',
        'amount',
        'charge',
        'net_amount',
        'usdt_address',
        'wallet_type',
        'status',
        'admin_remark',
        'txn_hash',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'charge' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the withdrawal request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
