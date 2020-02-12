<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /*
    13.1多対多の関係を正確に記述するため、
    Micropost モデル(Micropost.php)にも favorite_users() のような名前の関数を用意して
    belongsToMany() を指定してください。
    */
    public function favorite_users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'micropost_id', 'user_id')->withTimestamps();
    }
}