<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // fields
    protected $fillable = [
        'user_id',
        'name',
        'type',
    ];

    // Relation on User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relation on Transaction
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Relation on Budget
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }
}
