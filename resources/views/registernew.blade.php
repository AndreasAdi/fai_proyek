<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login V3</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- LOAD ASSETS --}}
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset ('assets/LoginAssets/images/icons/favicon.ico') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset ('assets/LoginAssets/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/LoginAssets/css/main.css') }}">
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/LoginAssets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/LoginAssets/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/LoginAssets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset ('assets/LoginAssets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/LoginAssets/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/LoginAssets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset ('assets/LoginAssets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/LoginAssets/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset ('assets/LoginAssets/js/main.js') }}"></script>
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('assets/LoginAssets/images/bg-01.jpg');">
            <div class="wrap-login100">
                {{-- <form class="login100-form validate-form"> --}}

                <span class="login100-form-logo">
                    <i class="zmdi zmdi-landscape"></i>
                </span>

                <span class="login100-form-title p-b-34 p-t-27">
                    Register
                </span>

                <form action="{{url("user/cekregister")}}" method="POST">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="nama_user" placeholder="username">
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Enter email">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter confirm password">
                        <input class="input100" type="kpassword" name="kpassword" placeholder="Confirm Password">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">Register </button>
                    </div>
                </form>

                <div class="text-center p-t-30">
                    {{-- <a class="txt1" href="#">
                                Forgot Password?
                            </a> --}}
                    <a href="{{url('/')}}" class="mt-5" style="color: white;">Already Sign Up</a>
                </div>

                {{-- </form> --}}
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>
</body>

</html>