<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_cost',
        'item_id',
    ];

    public function user(): HasMany {
        return $this->hasMany(User::class);
    }

    public function item(): HasMany {
        return $this->hasMany(Item::class);
    }

    
}
