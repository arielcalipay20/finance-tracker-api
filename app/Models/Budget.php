<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    // fields
    protected $fillable = [
        'user_id',
        'category_id',
        'limit_amount',
        'month',
        'year',
    ];

    // Relation on User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relation on Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
