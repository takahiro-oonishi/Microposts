{{-- 13.1  お気に入りボタンを表示する部分を共通の View として用意しましょう。 --}}
{{--       これを @include すると、お気に入りボタンをクリックすることが可能になります。 --}}


    @if (Auth::user()->is_favorites($micropost->id))
        {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}  {{--users.favorites????  --}}
            {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-sm"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}      {{--users.favorites????  --}}
            {!! Form::submit('Favorite', ['class' => "btn btn-primary btn-sm"]) !!}
        {!! Form::close() !!}
    @endif
