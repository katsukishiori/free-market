<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
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
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function sold_item()
    {
        return $this->hasMany(SoldItem::class);
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class)->withPivot('manager_id')->withTimestamps();
    // }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    // Accessor
    public function getIntroductionUrlAttribute()
    {

        $user_id = $this->id;

        return route('register', [
            'introduced_user_id' => $user_id
        ]);
    }
}
