<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    // public function users()
    // {
    //     return $this->belongsToMany(User::class)->withPivot('manager_id')->withTimestamps();
    // }

    protected $fillable = [
        'role',
        'name'// 一括代入可能な属性を追加する
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}
