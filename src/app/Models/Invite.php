<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'token',
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}