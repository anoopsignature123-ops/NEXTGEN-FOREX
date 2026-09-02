<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'invested_amount',
        'daily_roi',
        'daily_roi_amount',
        'duration_days',
        'total_return_amount',
        'paid_roi_amount',
        'status',
        'purchased_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'invested_amount' => 'decimal:2',
            'daily_roi' => 'decimal:2',
            'daily_roi_amount' => 'decimal:2',
            'duration_days' => 'integer',
            'total_return_amount' => 'decimal:2',
            'paid_roi_amount' => 'decimal:2',
            'purchased_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
