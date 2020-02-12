{{--  10.4  --}}
{{--  resources/views/users/show.blade.php  の共通部を抜出   --}}
{{--  ナビゲーションタブの方に followings と followers のリンクを追記します。  --}}
{{--  resources/views/users/show.blade.php にユーザ詳細 の View も共通化したものを @include するように変更  --}}
<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item"><a href="{{ route('users.show', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}">TimeLine <span class="badge badge-secondary">{{ $count_microposts }}</span></a></li>
    <li class="nav-item"><a href="{{ route('users.followings', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/*/followings') ? 'active' : '' }}">Followings <span class="badge badge-secondary">{{ $count_followings }}</span></a></li>
    <li class="nav-item"><a href="{{ route('users.followers', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/*/followers') ? 'active' : '' }}">Followers <span class="badge badge-secondary">{{ $count_followers }}</span></a></li>
    {{-- 13.1 ナビゲーションタブの方にfavoritesのリンクを追加　　--}}
    <li class="nav-item"><a href="{{ route('users.favorites', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/*/favorites') ? 'active' : '' }}">Favorites <span class="badge badge-secondary">{{ $count_favorites }}</span></a></li>
    
</ul>
{{--  <li class="dropdown-item">{!! link_to_route('users.favorites', 'favorite',['id'=>$user->id]) !!}</li>  --}}
