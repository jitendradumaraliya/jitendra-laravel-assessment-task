<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    @if (request()->routeIs('admin.login') || request()->routeIs('admin.dashboard'))
        <a class="navbar-brand bg-dark text-white p-3 pr-3" href="#">Admin Area</a>
        <a class="navbar-brand" href="#">Laravel Assessment Task </a>
    @else
        <a class="navbar-brand" href="#">Laravel Assessment Task</a>
    @endif
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @if (auth()->check())
            <ul class="navbar-nav mb-2 mb-lg-0 d-flex float-right">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.logout') }}">Logout</a>
                </li>
            </ul>
        @elseif (auth()->guard('admin')->check())
            <ul class="navbar-nav mb-2 mb-lg-0 d-flex float-right">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.logout') }}">Logout</a>
                </li>
            </ul>
        @endif
    </div>
</nav>
