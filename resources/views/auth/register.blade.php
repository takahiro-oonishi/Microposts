
{{-- ユーザ登録（作成）ページ --}}
{{-- RegisterController => RegistersUsers へと辿りました。そして RegistersUsers を見ると --}}
{{-- showRegistrationForm() が定義されており、中には return view('auth.register'); の1行だけが記述されていることがわかります。 --}}
{{-- あとは用意されていなかった auth/ フォルダを作成し、register.blade.php を作成するだけでユーザ登録が動作します。 --}}


@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Sign up</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'signup.post']) !!}
                <div class="form-group">
                    {{-- old() 関数は、直前で入力していた値を再度代入できる関数です。 --}}
                    {{-- 例えば、フォームで password と password_confirmation が一致しない状態で送信するとエラーとなってフォーム画面に戻りますが、 --}}
                    {{-- 全て最初から入力し直してもらうのではなく、入力されていた内容を消さずに残しておけます --}}
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirmation') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('Sign up', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
