<nav class="sb-topnav navbar navbar-expand fixed-top" style="background: linear-gradient(90deg, #1a2f5a 0%, #243a6e 100%);">
    {{-- Check if emp_type is NOT 1 or 2. If it is, use #! --}}
    @if(in_array(auth()->user()->emp_type, ['1', '2']))
        {{-- For emp_type 1 or 2: Set href to non-clickable '#' --}}
        <a class="navbar-brand ps-3" href="#!" style="color: white;">RSMIS</a>
    @else
        {{-- For emp_type 0 (or others): Set href to the home page --}}
        <a class="navbar-brand ps-3" href="{{url('/')}}" style="color: white;">RSMIS</a>
    @endif

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="color: white"></i></button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        {{-- ... Form content ... --}}
    </form>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;"><i class="fas fa-user fa-fw" style="color: white;"></i> {{ Auth::user()->lastname }}, {{ Auth::user()->firstname }}</a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('accounts.profile') }}">
                        <i class="fa fa-user me-2"></i> Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
