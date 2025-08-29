<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu sibedar">
        <div class="nav">

            <div class="sb-sidenav-menu-heading">General</div>
            <a class="nav-link" href="{{ url('/home') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <div class="sb-sidenav-menu-heading">Modules</div>
            <a class="nav-link" href="{{ url('/rstbl') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
                Resource Speaker
            </a>
            <a class="nav-link" href="{{ url('/accreditation') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-person-chalkboard"></i></div>
                List of To Be Accredited
            </a>
            <a class="nav-link" href="{{ url('/accreditation_average') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-person-chalkboard"></i></div>
                List of the accredited
            </a>
            <a class="nav-link" href="{{ url('/training') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-line-chart"></i></div>
                Training
            </a>

            <div class="sb-sidenav-menu-heading">Libraries</div>

            <!-- Dropdown Toggle -->
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLibraries" aria-expanded="false" aria-controls="collapseLibraries">
                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                Libraries
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <!-- Dropdown Items -->
            <div class="collapse" id="collapseLibraries" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ url('/divisions') }}">Division</a>
                    <a class="nav-link" href="{{ url('/positions') }}">Position</a>
                    <a class="nav-link" href="{{ url('/provinces') }}">Provinces</a>
                    <a class="nav-link" href="{{ url('/units') }}">Units</a>
                </nav>
            </div>

            <div class="sb-sidenav-menu-heading">Account</div>
            <a class="nav-link" href="{{ url('/user') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Accounts
            </a>
        </div>
    </div>
</nav>
