<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'items';

    protected $fillable = [
        'name', 'description', 'price', 'img_url', 'condition_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'item_id');
    }

    public function category_item()
    {
        return $this->hasMany(CategoryItem::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function soldItems()
    {
        return $this->hasMany(SoldItem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function manager()
    {
        return $this->hasMany(Manager::class);
    }


    /**
     * リプライにLIKEを付いているかの判定
     *
     * @return bool true:Likeがついてる false:Likeがついてない
     */
    public function is_liked_by_auth_user()
    {
        $id = Auth::id();

        $likers = array();
        foreach ($this->likes as $like) {
            array_push($likers, $like->user_id);
        }

        if (in_array($id, $likers)) {
            return true;
        } else {
            return false;
        }
    }
}
