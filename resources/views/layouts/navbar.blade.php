<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-users"></i> {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">{{ __('app.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/members">{{ __('app.members') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/news">{{ __('app.news') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/notices">{{ __('app.notices') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/donations">{{ __('app.donations') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tracking">{{ __('app.tracking') }}</a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if (Auth::user()->is_admin)
                                <li><a class="dropdown-item" href="/admin/dashboard">
                                    <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                                </a></li>
                            @else
                                <li><a class="dropdown-item" href="/user/dashboard">
                                    <i class="fas fa-chart-line"></i> {{ __('app.dashboard') }}
                                </a></li>
                                <li><a class="dropdown-item" href="/user/profile">
                                    <i class="fas fa-user"></i> {{ __('app.profile') }}
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('app.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login">{{ __('app.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/register">{{ __('app.register') }}</a>
                    </li>
                @endauth

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-language"></i>
                        {{ app()->getLocale() === 'bn' ? 'বাংলা' : 'English' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/lang/bn">বাংলা</a></li>
                        <li><a class="dropdown-item" href="/lang/en">English</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
