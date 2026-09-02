<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_amount',
        'max_amount',
        'daily_roi',
        'duration_days',
        'total_return_multiplier',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'min_amount' => 'decimal:2',
            'max_amount' => 'decimal:2',
            'daily_roi' => 'decimal:2',
            'duration_days' => 'integer',
            'total_return_multiplier' => 'decimal:2',
        ];
    }

    public function userPackages(): HasMany
    {
        return $this->hasMany(UserPackage::class);
    }
}
