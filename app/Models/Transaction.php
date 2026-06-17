<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    // fields
    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'amount',
        'note',
        'transaction_date',
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
