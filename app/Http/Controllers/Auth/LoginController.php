<?php
//ログイン認証のコントローラー
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//ログイン認証のコードの実態は AuthenticatesUsers トレイトです。
//Router で設定した showLoginForm や login はこちらに定義されています。
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
     //ログインページのフォームでログイン認証が成功した際に、
     //ログイン後は、トップページにリダイレクトされます。
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
