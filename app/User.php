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
    
    /*
    User のモデルファイルに多対多の関係を記述します。
    そのためには belongsToMany メソッドを使用します。
    フォロー関係の場合、多対多の関係がどちらも User に対するものなので、
    どちらも User のModelファイルに記述します。
    */
    /*
    ( followings を例にとると) belongsToMany() では、
    第一引数に得られる Model クラス (User::class) を指定し、
    第二引数に中間テーブル (user_follow) を指定し、
    第三引数に中間テーブルに保存されている自分の id を示すカラム名 (user_id) を指定し、
    第四引数に中間テーブルに保存されている関係先の id を示すカラム名 (follow_id) を指定します。
    followersの場合、第三引数と第四引数が逆になります。
    */
    public function followings()//追加 followingsは「user_id のUser は follow_id の User をフォローしている」
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers()//追加  followers は「follow_id のUser は user_id の User からフォローされている
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    /*
    フォロー／アンフォローするときには、2つ注意することがあります。
	既にフォローしているか
    相手が自分自身ではないか
    */
    /*
    フォロー／アンフォローとは、中間テーブルのレコードを保存／削除することです。
    そのために attach() と detach() というメソッドが用意されているので、それを使用します。
    */
    
    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;
    
        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
}
