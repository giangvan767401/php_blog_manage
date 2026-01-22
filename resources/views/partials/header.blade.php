<header style="background: #f5f5f5; padding:10px;">
    <h1>Laravel News</h1>
    <section class="row">
    <nav class="col-9">
        <a href="{{ route('home') }}">Trang Chủ</a> |
        <a href="{{ route('news.index') }}">Tin Tức</a> |
        <a href="/about">Giới Thiệu</a>
    </nav>
    <div class="col-3 row">
        @if(Route::has('login'))
            @auth
                <a class="col-3" href="{{route('profile.edit')}}">{{Auth::user()->name}}</a>
                <form class="col-3" method="POST" action="{{route('logout')}}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log out') }}
                        </x-dropdown-link>
                </form>
            @else
                <a href="{{route('login')}}" class="col-6">Log in</a>

                @if (Route::has('register'))
                    <a href="{{route('register')}}" class="col-6">Register</a>
                @endif
            @endauth
        </nav>
        @endif
    </div>
    </section>

</header>