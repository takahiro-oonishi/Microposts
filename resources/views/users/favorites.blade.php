{{--   favorites() の View  --}}
@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            @include('users.card', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            @include('users.navtabs', ['user' => $user])
            @include('users.show', ['users' => $microposts]) {{--   ここどこかおかしいはず！  users.show これでいい？--}}
        </div>
    </div>
@endsection

