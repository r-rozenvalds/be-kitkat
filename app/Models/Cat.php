<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Item;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'user_id',
    ];

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function items(): BelongsToMany {
        return $this->belongsToMany(Item::class);
    }
}
