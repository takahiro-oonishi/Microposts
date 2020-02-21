{{-- ユーザ一覧の表示部分は、あとで「ユーザがフォローしているユーザ一覧／ユーザのフォロワー一覧」にも使用するので、1つにまとめておきます。 --}}
@if (count($users) > 0)
    <ul class="list-unstyled">
        @foreach ($users as $user)
            <li class="media">
                <img class="mr-2 rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $user->name }}
                    </div>
                    <div>
                        <p>{!! link_to_route('users.show', 'View profile', ['id' => $user->id]) !!}</p>
                        <p>{!! link_to_route('users.messages', 'DirectMessage', ['id' => $user->id]) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $users->links('pagination::bootstrap-4') }}
@endif