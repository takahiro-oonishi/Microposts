{{-- ダイレクトメッセージを表示します。 --}}
@extends('layouts.app')

@section('content')

    
    {{--  lesson15 9.3参照　メッセージの表記  --}}
    <ul class="media-list">
    @foreach ($messages as $message)
        <li class="media mb-3">
            <img class="mr-2 rounded" src="{{ Gravatar::src($message->user->email, 50) }}" alt="">
            <div class="media-body">
                <div>
                    {!! link_to_route('users.show', $message->user->name, ['id' => $message->user->id]) !!} <span class="text-muted">posted at {{ $message->created_at }}</span>
                </div>
                <div>
                    <p class="mb-0">{!! nl2br(e($message->content)) !!}</p>
                    
                </div>
                <div>
                @if (Auth::id() == $message->user->id)
                        {!! Form::open(['route' => ['user.messageDelete', $message->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                @endif
                </div>
            </div>
        </li>
    @endforeach
    </ul>
    
	{!! Form::open(['route' => ['user.messageSend',$user->id]]) !!}
        <div class="form-group">
            {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}
            {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
        </div>
    {!! Form::close() !!}
    
{{ $messages->links('pagination::bootstrap-4') }}
    
    
@endsection