<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // $fillableに設定したもの以外のカラムはユーザーが変更できないようにできる
    // protected $fillable = [
    //     'user_id',
    //     'title',
    //     'body',
    //     'image'
    // ];

    // guarded = 指定したカラムはユーザが変更できる
    protected $guarded = ['id'];


    // Postテーブルを軸にUserテーブルとリレーション
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // Postテーブルを軸にcategorysテーブルとリレーション
    public function category()
    {
        // 投稿は1つのカテゴリーに属する
        return $this->belongsTo('App\Models\Category');
    }

    // Postテーブルを軸にyearテーブルとリレーション
    public function year()
    {
        // 投稿は1つのカテゴリーに属する
        return $this->belongsTo('App\Models\Year');
    }
}
