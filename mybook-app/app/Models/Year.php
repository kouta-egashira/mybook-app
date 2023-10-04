<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    public function posts()
    {
        // コメントは1つの投稿に所属
        return $this->hasMany('App\Models\Post');
    }

    public function category()
    {
        // コメントは1つの投稿に所属
        return $this->hasMany('App\Models\Category');
    }

    // 任意のキーのみを取得
    public function getLists()
    {
        $years = Year::orderBy('id')->pluck('year', 'id');
        return $years;
    }
}
