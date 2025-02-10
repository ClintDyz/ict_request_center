<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu sibedar">
        <div class="nav">

            <div class="sb-sidenav-menu-heading">General</div>
            <a class="nav-link" href="{{url('/home')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Modules</div>
            <a class="nav-link" href="{{url('/rstbl')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
                Resource Speaker
            </a>
            <a class="nav-link" href="{{url('#')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-line-chart"></i></div>
                Training
            </a>
            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Layouts
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Pages
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                        Authentication
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="login.html">Login</a>
                            <a class="nav-link" href="register.html">Register</a>
                            <a class="nav-link" href="password.html">Forgot Password</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                        Error
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="401.html">401 Page</a>
                            <a class="nav-link" href="404.html">404 Page</a>
                            <a class="nav-link" href="500.html">500 Page</a>
                        </nav>
                    </div>
                </nav>
            </div> --}}
            <div class="sb-sidenav-menu-heading">Libraries</div>
            <a class="nav-link" href="{{url('/divisions')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Division
            </a>
            <a class="nav-link" href="{{url('/positions')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Position
            </a>
            <a class="nav-link" href="{{url('/provinces')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Provinces
            </a>
            <a class="nav-link" href="{{url('/units')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Units
            </a>
            <div class="sb-sidenav-menu-heading">Account</div>
            <a class="nav-link" href="{{url('/user')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Accounts
            </a>
        </div>
    </div>
    {{-- <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        Start Bootstrap
    </div> --}}
</nav>
