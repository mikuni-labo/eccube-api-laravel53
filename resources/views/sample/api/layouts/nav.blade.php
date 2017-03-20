<!-- Nav -->
@if ( Route::has('login') )
    <div class="top-right links">
        @if ( Auth::check() )
            <a href="{{ route('home') }}">Home</a>
        @else
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
        @endif
    </div>
@endif
