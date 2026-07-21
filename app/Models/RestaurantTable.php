<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'seats', 'status'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /** The order currently in progress at this table, if any. */
    public function activeOrder(): ?Order
    {
        return $this->orders()
            ->whereNotIn('status', ['paid', 'cancelled'])
            ->latest()
            ->first();
    }
}
