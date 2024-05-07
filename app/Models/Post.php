<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
      'title',
      'description',
      'likes',
      'media_id',
      'user_id',  
    ];

    public function user(): HasOne {
        return $this->hasOne(User::class);
    }
}
