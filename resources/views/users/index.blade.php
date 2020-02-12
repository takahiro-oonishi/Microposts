{{-- ユーザ一覧を表示します。 --}}
@extends('layouts.app')

@section('content')
    @include('users.users', ['users' => $users])
    
@endsection