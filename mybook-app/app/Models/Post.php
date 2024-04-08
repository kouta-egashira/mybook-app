<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // guarded = 指定したカラムはユーザが変更できる
    protected $guarded = ['id'];

    // Postテーブルを軸にUserテーブルとリレーション
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // postsテーブルを軸にcategoryテーブルとリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
