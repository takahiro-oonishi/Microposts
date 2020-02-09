<?php
/*
今回は中間テーブルを操作するアクションなので、新しくUserFollowController.phpファイルを作成して、
その中に、フォローするためのstoreメソッドとアンフォローするためのdestroyメソッドを作成することにします。
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
	//storeメソッドの中でUser.phpの中で定義した followメソッドを使って、ユーザーをフォローできるようにします。
    public function store(Request $request, $id)
    {
        \Auth::user()->follow($id);
        return back();
    }

    //destroyメソッドの中でUser.phpの中で定義した unfollowメソッドを使って、ユーザーをアンフォローできるようにします。
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
