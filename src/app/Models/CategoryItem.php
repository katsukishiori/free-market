<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'category_item'; // テーブル名を明示的に指定

    protected $fillable = ['item_id', 'category_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
