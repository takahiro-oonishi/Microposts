<?php
//ルーターの設定

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MicropostsController@index'); // 上書き

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// ユーザ機能
/*Route::group() でルーティングのグループを作り
  その際に ['middleware' => ['auth']] を加えることで、このグループに書かれたルーティングは必ずログイン認証を確認させます。
*/
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);//['only' => ['index', 'show']] とすることで実装するアクションを絞り込むことが可能です。
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);  
    
    /*
    auth の Route::group の中に ['prefix' => 'users/{id}'] とした Route::group を追加しています。
    このグループ内のルーティングでは、 URL の最初に /users/{id}/ が付与されます。
    POST /users/{id}/follow
    DELETE /users/{id}/unfollow
    GET /users/{id}/followings
    GET /users/{id}/followers
    
    例) ユーザーID125のユーザーの場合
    // 125番目のユーザーをフォローする
    http://laravel-microposts.herokuapp.com/users/125/follow [POST形式]
    // 125番目のユーザーをアンフォローする
    http://laravel-microposts.herokuapp.com/users/125/unfollow [DELETE形式]
    // 125番目のユーザーがフォローしているユーザー一覧を表示する
    http://laravel-microposts.herokuapp.com/users/125/followings [GET形式]
    // 125番目のユーザーをフォローしているユーザー一覧を表示する
    http://laravel-microposts.herokuapp.com/users/125/followers [GET形式]
    
    上記の POST と DELETE はフォロー／アンフォローを HTTP で操作可能にするルーティングです
     GET の2つはフォローしている人とフォローされている人の User 一覧を表示することになります。
    */
    
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });
    
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});