<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    // テーブル名が role_user であることを確認
    protected $table = 'role_user';

    // フィルラブル属性を設定
    protected $fillable = [
        'user_id',
        'role_id',
        'manager_id'];

    public function manager()
    {
        // role_userテーブルのmanager_idとmanagersテーブルのidを結びつける
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}
