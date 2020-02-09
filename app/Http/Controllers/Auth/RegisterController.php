<?php
//ユーザー登録のためのコントローラー

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    //RegisterUsers は トレイト です。
    //RegistersUsers を取り込んだ RegisterController は、 RegistersUsers で定義されているメソッドをそのまま取り込むことができます。
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
     //ユーザ登録後のリダイレクト先がトップページに変更されます。
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {//ミドルウェアは Controller にアクセスする前に事前に確認される条件 
    //guest である必要があるという条件を持ったミドルウェアが設定されている
        $this->middleware('guest');
        //guest は エイリアス（ニックネームのようなもの）としてつけられた名前です。
        //guest のミドルウェアの場所は app/Http/Kernel.php を開くことで確認できます。
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    //validator() をオーバーライドすることで、ユーザ登録時のバリデーション処理の内容を定義しています。
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
     
     //RESTfulなアクション7つの内のひとつである create とは違って、User を 新規作成しているメソッドになります。
     //これも RegistersUsers トレイトの register メソッドの中身で呼び出されているのがわかります。
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
