<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Cat;
use App\Models\Post;
use App\Models\Item;
use App\Models\Transaction;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'date_of_birth',
        'exp',
        'coins',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function cat(): HasOne
    {
        return $this->hasOne(Cat::class);
    }

    public function transactions(): BelongsToMany {
        return $this->belongsToMany(Transaction::class);
    }

    public function posts(): BelongsToMany {
        return $this->belongsToMany(Post::class);
    }

    public function friends(): BelongsToMany {
        return $this->belongsToMany(User::class, 'friendships', 'user_id_1', 'user_id_2')
        ->withTimestamps();    
    }

    public function items(): BelongsToMany {
        return $this->belongsToMany(Item::class);
    }
    
}
