<header>
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="header-top-left">                            
                        <ul>
                            <li><a href="mailto:{{ trans('header.owner_mail') }}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ trans('header.owner_mail') }}</a></li>
                            <li><img src="{{ asset('images/logo/flag_vietnam.jpg') }}" alt="Logo">
                                {{-- <a href="{!! route('user.change-language', ['vi']) !!}"> --}}
                                <a href="#">Việt Nam
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                                <ul>
                                    <li><img src="{{ asset('images/logo/flag_england.png') }}" alt="Logo">
                                        <a href="#">English</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="social-media-area">
                        <nav>
                            <ul>
                                <li><a href="#" class="active"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle-area menu-sticky">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-12 col-xs-12 logo">
                    {{-- <a href="#"><img style="border-radius: 0%;" src="images/logo/logo.png" alt="logo"></a> --}}
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12 mobile-menu">
                    <div class="main-menu">
                        {{-- <a class="rs-menu-toggle"><i class="fa fa-bars"></i>Menu</a> --}}
                        <nav class="rs-menu">
                            <ul class="nav-menu">
                                <!-- Home -->
                                <li class="current-menu-item current_page_item"><a href="{{ route('home') }}">{{ trans('header.home') }}</a></li>
                                
                                <!-- Tìm giải đấu -->
                                <li><a href="{{ route('tournament.list') }}">{{ trans('header.tournament_search') }}</a></li>
                                <!-- Tạo giải đấu -->
                                <li><a href="{{ route('tournament.create') }}">{{ trans('header.tournament_create') }}</a></li>
                                <!-- Tìm đội bóng -->
                                <li><a href="{{ route('club.list') }}">{{ trans('header.club_search') }}</a></li>
                                <!-- Tạo đội bóng -->
                                <li><a href="{{ route('club.create') }}">{{ trans('header.club_create') }}</a></li>

                                <!-- Drop Down - Hướng dẫn-->
                                <li class="menu-item-has-children">
                                    <a href="#">{{ trans('header.guide') }}</a>
                                    <ul class="sub-menu">
                                       <li><a href="#">{{ trans('header.guide_create_tour') }}</a></li> 
                                       <li><a href="#">{{ trans('header.guide_create_tour_apply') }}</a></li> 
                                       <li><a href="#">{{ trans('header.guide_apply_to_tour') }}</a></li> 
                                       <li><a href="#">{{ trans('header.guide_export_card') }}</a></li> 
                                    </ul>
                                </li>
                                <!-- Authentication Links -->
                                @guest
                                    <li><a href="{{ route('login') }}">{{ trans('header.login') }}</a></li>
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">{{ trans('header.register') }}</a></li>
                                    @endif
                                @else
                                    <li class="menu-item-has-children">
                                        <a>{{ Auth::user()->username }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.detail', ['username' => Auth::user()->username]) }}">{{ trans('header.your_account') }}</a></li> 
                                            <li><a href="{{ route('user.tournaments',['username' => Auth::user()->username]) }}">{{ trans('header.your_tournament') }}</a></li> 
                                            <li><a href="{{ route('user.clubs',['username' => Auth::user()->username]) }}">{{ trans('header.your_club') }}</a></li>
                                            <li>
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                    {{ __('Đăng xuất') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @endguest
                            </ul>
                       </nav>
                   </div>
               </div>
            </div>
        </div>
    </div>
</header>