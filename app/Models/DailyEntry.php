<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'revenue',
        'orders',
        'covers',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'revenue' => 'decimal:2',
        'orders' => 'integer',
        'covers' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}