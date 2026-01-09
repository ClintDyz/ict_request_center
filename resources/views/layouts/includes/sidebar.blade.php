<style>
.sb-sidenav .nav-link.active {
    /* Styles for the active link (blue background, white text) */
    background-color: #0d6efd;
    color: white !important;
}

.sb-sidenav-collapse-arrow i {
    /* Smooth transition for the dropdown arrow rotation */
    transition: transform 0.3s;
}

.sb-sidenav-collapse-arrow i.rotate {
    /* Rotation class for the dropdown arrow when open */
    transform: rotate(180deg);
}
</style>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu sibedar">
        <div class="nav">

            {{-- --- Links Visible ONLY to emp_type '0' (Admin/High-Level Access) --- --}}
            @if(auth()->user()->emp_type == '0')
                <div class="sb-sidenav-menu-heading">General</div>
                <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ url('/home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>


                <div class="sb-sidenav-menu-heading">Modules</div>
                <a class="nav-link {{ request()->is('rstbl*') ? 'active' : '' }}" href="{{ url('/rstbl') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
                    SMS for Evaluation
                </a>
            @endif

            {{-- --- Links Visible to emp_type '0' OR '1' (Evaluator/Specific Access) --- --}}


            @if(in_array(auth()->user()->emp_type, ['0', '1']))

                <a class="nav-link {{ request()->is('approved-speakers') ? 'active' : '' }}" href="{{ url('/approved-speakers') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user-check"></i></div>
                    List of To Be Evaluated
                </a>
            @endif
            @if(auth()->user()->emp_type == '0')

                <a class="nav-link {{ request()->is('accreditation') ? 'active' : '' }}" href="{{ url('/accreditation') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    Get the Average
                </a>

                <a class="nav-link {{ request()->is('accreditation_average') ? 'active' : '' }}" href="{{ url('/accreditation_average') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line"></i></div>
                    Evaluated SMS
                </a>
            @endif

            {{-- --- Masterlist SMS (Visibility based on your original placement) --- --}}
            {{-- This link is currently visible to ALL users regardless of emp_type --}}
            <a class="nav-link {{ request()->is('masterlist') ? 'active' : '' }}" href="{{ url('/masterlist') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-person-chalkboard"></i></div>
                Masterlist SMS
            </a>

            {{-- --- Libraries and Accounts Visible ONLY to emp_type '0' --- --}}
            @if(auth()->user()->emp_type == '0')
                <div class="sb-sidenav-menu-heading">Libraries</div>

                {{-- PHP Block to determine if any Library link is active for the dropdown --}}
                @php
                    $libraryActive = request()->is('divisions') || request()->is('positions') || request()->is('provinces') || request()->is('units');
                @endphp

                {{-- Libraries Dropdown Toggle --}}
                <a class="nav-link collapsed {{ $libraryActive ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLibraries" aria-expanded="{{ $libraryActive ? 'true' : 'false' }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Libraries
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down {{ $libraryActive ? 'rotate' : '' }}"></i></div>
                </a>

                {{-- Libraries Dropdown Items --}}
                <div class="collapse {{ $libraryActive ? 'show' : '' }}" id="collapseLibraries" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('divisions') ? 'active' : '' }}" href="{{ url('/divisions') }}"><i class="fa fa-object-ungroup"></i> &nbsp; Division</a>
                        <a class="nav-link {{ request()->is('positions') ? 'active' : '' }}" href="{{ url('/positions') }}"><i class="fa fa-address-card"></i> &nbsp; Position</a>
                        <a class="nav-link {{ request()->is('provinces') ? 'active' : '' }}" href="{{ url('/provinces') }}"><i class="fa fa-map-marker"></i> &nbsp; Provinces</a>
                        <a class="nav-link {{ request()->is('units') ? 'active' : '' }}" href="{{ url('/units') }}"><i class="fa fa-book"></i> &nbsp; Units</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Account</div>
                <a class="nav-link {{ request()->is('user') ? 'active' : '' }}" href="{{ url('/user') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Accounts
                </a>
            @endif
        </div>
    </div>
</nav>
