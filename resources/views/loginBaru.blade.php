<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- LOAD ASSETS --}}
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="assets/LoginAssets/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/LoginAssets/css/main.css">
    <!--===============================================================================================-->
    <script src="assets/LoginAssets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/LoginAssets/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/LoginAssets/vendor/bootstrap/js/popper.js"></script>
    <script src="assets/LoginAssets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/LoginAssets/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/LoginAssets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/LoginAssets/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="assets/LoginAssets/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="assets/LoginAssets/js/main.js"></script>
</head>

<body>
   @include('alert')
    <div class="limiter">
        <div class="container-login100" style="background-image: url('assets/LoginAssets/images/bg-01.jpg');">
            <div class="wrap-login100">
                {{-- <form class="login100-form validate-form"> --}}
            
                        <span class="login100-form-logo">
                            <i class="zmdi zmdi-landscape"></i>
                        </span>

                        <span class="login100-form-title p-b-34 p-t-27">
                            Log in
                        </span>
                    <form action="{{url("user/ceklogin")}}" method="POST">
                        @csrf
                        <div class="wrap-input100 validate-input" data-validate="Enter email">
                            <input class="input100" type="text" name="email" placeholder="Email">
                            <span class="focus-input100" data-placeholder="&#xf207;"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <input class="input100" type="password" name="password" placeholder="Password">
                            <span class="focus-input100" data-placeholder="&#xf191;"></span>
                        </div>

                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                        <div class="container-login100-form-btn">
                            <button type="submit" class="login100-form-btn">Login </button>
                        </div>
                    </form>
                        <div class="text-center p-t-90">
                            {{-- <a class="txt1" href="#">
                                Forgot Password?
                            </a> --}}
                            <a href="{{url('user/register')}}" class="mt-5" style="color: white;">Create Account</a>
                                    <br>
            <a href="{{url('/')}}" class="mt-5" style="color: white;">Go To Home</a>  
                        </div>
                    
                {{-- </form> --}}
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>
</body>

</html>