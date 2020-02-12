@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            {{--  共通部の抜出 --}}
            {{-- 　card.blade.phpを（中にフォロー／アンフォローボタン）の設置　 --}}
            @include('users.card', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            {{--  共通部の抜出 --}}
            {{--  ユーザ詳細 の View も共通化したものを @include  --}}
            @include('users.navtabs', ['user' => $user])
            {{--  
            @if (Auth::id() == $user->id)
                {!! Form::open(['route' => 'microposts.store']) !!}
                    <div class="form-group">
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}
                        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
                {!! Form::close() !!}
            @endif
            --}}
            @if (count($microposts) > 0)
                @include('microposts.microposts', ['microposts' => $microposts])
            @endif
        </div>
    </div>
@endsection
