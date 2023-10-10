<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function posts()
    {
        // コメントは1つの投稿に所属する
        return $this->hasMany('App\Models\Post');
    }

    public function years()
    {
        // コメントは1つの投稿に所属する
        return $this->hasMany('App\Models\Year');
    }

    // 任意のキーのみを取得
    public function getLists()
    {
        $categories = Category::orderBy('id')->pluck('moth', 'id');
        return $categories;
    }
}
