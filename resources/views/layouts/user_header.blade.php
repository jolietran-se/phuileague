<div id="header-information" class="row">
    <div class="col-md-2">
        <div class="header-avatar">
            @if(isset($user->avatar))
                <a href="{{ route('user.detail', $user->username) }}"><img  src="{{ asset('/storage/avatars').'/'.$user->avatar }}" ></a>
            @else
                <img src="{{ asset('/storage/avatars/avatar_default.jpg') }}">
            @endif
        </div>
    </div>
    <div class="col-md-10">
        <div class="header-detail">
            <a href="{{ route('user.detail', $user->username) }}">
                <h5>
                    <strong>{{ $user->username }} </strong>
                </h5>
            </a>
            <p><span><i class="fa fa-envelope"></i></span> {{ $user->email }}</p>
            <p><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> {{ $user->phone }}</p>
        </div>
    </div>
</div>