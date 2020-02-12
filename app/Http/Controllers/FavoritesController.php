<?php
/*
今回は中間テーブルを操作するアクションなので、新しくUserFollowController.phpファイルを作成して、
その中に、フォローするためのstoreメソッドとアンフォローするためのdestroyメソッドを作成することにします。
*/
/*
13.1:  2 と 3については中間テーブルを操作することになるので 
FavoritesController のような名前の Controller を新規作成し、
そこに該当のアクションを追加してください。
データの登録／削除を実行するアクションです
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
	//storeメソッドの中でUser.phpの中で定義した favoriteメソッドを使って、ユーザーをフォローできるようにします。
    public function store(Request $request, $id)
    {
        \Auth::user()->favorite($id);
        return back();
    }

    //destroyメソッドの中でUser.phpの中で定義した unfavoriteメソッドを使って、ユーザーをアンフォローできるようにします。
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }
}