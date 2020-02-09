<?php
//ユーザーモデル

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        //$fillable で「一気に保存可能」なパラメータを指定する
        //create() を使ってデータを保存するときには、その Model ファイルの中に $fillable を定義し、create() で保存可能なパラメータを配列として代入しておく必要がある
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //パスワードなど秘匿しておきたいカラムをモデルのコーディングで $hidden に指定しておくと、見られないように隠してくれます。
        'password', 'remember_token',
    ];
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
}
