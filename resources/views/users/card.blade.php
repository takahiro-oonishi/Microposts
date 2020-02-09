{{--  ユーザの詳細情報表示( users.show )、自分がフォローしているUser一覧( followings )、自分をフォローしているUser一覧( followers )には共通している部分があるので、  --}}
{{--  まずは共通部分（ユーザ名と Gravatarの表示部分、ナビゲーションタブの部分）を切り出しましょう。 --}}
{{--  また、ナビゲーションタブの方に followings と followers のリンクを追記します。 --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <img class="rounded img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="">
    </div>
</div>
@include('user_follow.follow_button', ['user' => $user])