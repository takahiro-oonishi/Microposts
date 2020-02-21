<?php
//ユーザーモデル

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [ 
                //$fillable で「一気に保存可能」なパラメータを指定する
                //create() を使ってデータを保存するときには、その Model ファイルの中に $fillable を定義し、create() で保存可能なパラメータを配列として代入しておく必要がある
        'name', 'email', 'password',
    ];

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
        
        $exist = $this->is_following($userId);  // 既にフォローしているかの確認
        
        $its_me = $this->id == $userId;  // 相手が自分自身ではないかの確認
    
        if ($exist || $its_me) // 既にフォローしていれば何もしない
        {  
            return false;
        } else {
            
            $this->followings()->attach($userId);  // 未フォローであればフォローする
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
    
    //11.1:タイムライン用のマイクロポストを取得するためのメソッドを実装します
    public function feed_microposts()
    {
        /*
        $this->followings()->pluck('users.id')->toArray(); では User がフォローしている User の id の配列を取得しています。
        pluck() は与えられた引数のテーブルのカラム名だけを抜き出す命令です。
        そして更に toArray() を実行して、通常の配列に変換しています。

        次に $follow_user_ids[] = $this->id; で自分の id も追加しています。自分自身のマイクロポストも表示させるためです
        */
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        /*
        return Micropost::whereIn('user_id', $follow_user_ids); で、 
        microposts テーブルの user_id カラムで $follow_user_ids の中にある 
        ユーザid を含むもの全てを取得して return します。
        */
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
        /*
        User のモデルファイルに多対多の関係を記述します。
        そのためには belongsToMany メソッドを���用します。
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
        //13.1 お気に入りの一覧を取得する機能は User モデルに favorites() のような名前の関数を用意し、belongsToMany() を指定すると良いでしょう。
        //投稿を取得したいので、第一引数には、 Micropost::class を指定すべき
    public function favorites()//お気に入りの一覧を取得する機能は User モデルに favorites() のような名前の関数を用意:　参照、followingsは「user_id のUser は follow_id の User をフォローしている」
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
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
    /*13.1
    実際の中間テーブルへのデータ登録／削除は
    User モデルに favorite() や unfavorite() のような名前の関数を作成して、そこに構築してください。
    その際、既にお気に入りに追加している Micropost かどうかを調べる処理が必要です
    */
    public function favorite($micropostId)//$micropostIdであってる？
    {
        // 既にお気に入りに追加しているの確認
        $exist = $this->is_favorites($micropostId);
    
        if ($exist) {
            // 既にお気に入りしていれば何もしない
            return false;
        } else {
            // 未お気に入りであればフォローする
            $this->favorites()->attach($micropostId);
            return true;
        }
    }
    
    public function unfavorite($micropostId)
    {
        // 既にお気に入りに追加しているの確認
        $exist = $this->is_favorites($micropostId);
    
        if ($exist) {
            // 既にお気に入りしていればフォローを外す
            $this->favorites()->detach($micropostId);
            return true;
        } else {
            // 未お気に入りであれば何もしない
            return false;
        }
    }
    
    public function is_favorites($micropostId)
    {
        return $this->favorites()->where('micropost_id', $micropostId)->exists();//引数の $micropostId と比較しようとしていますよね。ということは、 micropost_id というカラム名にする必要がある
    }
    
    
    /**
     * 中間テープル messages の多対多の定義
     */
    public function messages()
    {
        // withPivot とすることで中間テープルのカラム(id と content)を取得可能です。
        // withPivot の有無による結果の違いは一度 Tinker で確認してください。
        return $this->belongsToMany(User::class, 'messages', 'from_id', 'to_id')->withPivot('id','content')->withTimestamps();
    }
    /**
     * 受信したメッセージを取得する
     */
    public function messagesReceived()
    {
        return $this->belongsToMany(User::class, 'messages', 'to_id', 'from_id')->withPivot('id','content')->withTimestamps();
    }
    /**
     * メッセージを送信する
     * @param integer $toId  宛先のユーザid
     * @param string  $content 送信するメッセージ
     
     */
    public function messageSend($toId, $content)
    {
        //dd($toId);         // from_id には自動的に $this->id が保存される
        $this->messages()->attach( $this->id, [      //$this->followings()->attach($userId);  // 未フォローであればフォローする
            'to_id'   => $toId,
            'content' => $content,
            ]
        );
        return true;
    }
    /**
     * メッセージを削除する
     * @param integer $messageId 削除対象のメッセージのid(messages テープル内)
     * 
     */
    public function messageDelete($messageId)
    {
        $this->messages()->wherePivot('id', $messageId)->detach();  //$this->followings()->detach($userId);
        return true;
    }
}
