<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBalanceHistory extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the UserBalanceHistory
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter($query)
    {
        if (request()->query('user_id')) {
            $query->where('user_id', request()->query('user_id'));
        }

        return $query;
    }
}
