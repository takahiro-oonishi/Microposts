<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加
use App\Micropost; // 追加


use App\Message;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'microposts' => $microposts,
        ];

        $data += $this->counts($user);

        return view('users.show', $data);
    }
    
    //10.4 UsersController@followings, followers
    //Controller: こちらは Userの情報を取得できれば良いので、UsersController へ記述します。
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
    
    //10.4 UsersController@followings, followers
    //Controller: こちらは Userの情報を取得できれば良いので、UsersController へ記述します。
    //13.1お気に入りに関するアクションとビューの作成
    //User モデルの favorites() から一覧の取得ができるので UsersController にアクションを追加すれば良いでしょう
    
    public function favorites($id)//これは親クラスである Controller クラスから継承した自クラスの counts メソッドを呼んでいる
    {
        $user = User::find($id);
        $microposts = $user->favorites()->paginate(10);

        $data = [
            'user' => $user,
            'microposts' => $microposts, //usersじゃなく、microposts   ??????　
        ];

        $data += $this->counts($user);

        return view('users.favorites', $data);
    }
    
    public function messages($id)
    {
        $query =  Message::orWhere(function($query) use ($id) {
                        // 自分から相手に送ったというwhere文を作成
                        $query->where('from_id', '=', \Auth::id())
                              ->where('to_id', '=', $id);
                    })->orWhere(function($query) use ($id) {
                        // 自分に相手から送られたというwhere文を作成
                        $query->where('to_id', '=', \Auth::id())
                              ->where('from_id', '=', $id);
                    });
                    
        $user = User::find($id);
        $messages = $query->orderBy('created_at', 'asc')->paginate(10);//descで降順、ascで昇順
        
        $data = [
            'user' => $user,
            'messages' => $messages,];
        
        $data += $this->counts($user);
        
        return view('users.messages', $data);
    }
    
    public function messagesReceived($id)
    {
        $user = User::find($id);
        $messagesReceived = $user->messagesReceived()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $messagesReceived,
        ];

        $data += $this->counts($user);

        return view('users.messagesReceived', $data);
    }

    
}