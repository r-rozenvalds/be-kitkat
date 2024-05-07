<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Cat;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'price',
        'type',
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function cats() {
        return $this->belongsToMany(Cat::class);
    }
}
