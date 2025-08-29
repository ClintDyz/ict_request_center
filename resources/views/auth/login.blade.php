<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Resource</title>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    </head>
    <body style="background: rgb(55 78 96);">

        <nav class="sb-topnav navbar navbar-expand fixed-top" style="background-color: #3490dc">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="{{url('/')}}">Resource System</a>
            <!-- Sidebar Toggle-->
            {{-- <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="color: white"></i></button>
            <!-- Navbar Search--> --}}
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                {{-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div> --}}
            </form>
            <!-- Navbar-->
            {{-- <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item">
                    <a class="nav-link" href="#">Register Speaker</a>
                  </li>
            </ul> --}}
        </nav>


        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row d-flex justify-content-center align-items-center min-vh-100">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4"><i class="fa-solid fa-key fa-1x"></i> Login</h3></div>
                                    <div class="card-body">

                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="form-floating mb-3">

                                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus id="inputEmail">
                                                <label for="inputEmail"><i class="fa-solid fa-user-tie"></i> Username</label>

                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            </div>
                                            <div class="form-floating mb-3">

                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="inputPassword">
                                                <label for="inputPassword"> <i class="fa-solid fa-lock"></i> Password</label>

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                            <div class="form-check mb-3">

                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inputRememberPassword">Remember Me</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                                                {{-- @if (Route::has('password.request'))
                                                <a class="small btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif --}}

                                            <button type="submit" class="btn btn-primary col-12">
                                                    {{ __('Login') }}
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        {{-- <div class="small"><a href="register.html">Need an account? Sign up!</a></div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            {{-- <div id="layoutAuthentication_footer">
                <footer class="page-footer font-small navbar-dark">
                    <!-- Copyright -->
                    <div class="footer-copyright text-center py-2 text-white">
                        <small>© Department of Science &amp; Technology - Cordillera Administrative Region All Rights Reserved 2024</small>
                    </div>
                    <!-- Copyright -->
                </footer>
            </div> --}}
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/scripts.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset ('admin/js/datatables-simple-demo.js') }}"></script>

    </body>
</html>
