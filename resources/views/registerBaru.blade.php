<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>RegistrationForm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINEARICONS -->
    <link rel="stylesheet" href="assets/RegisterAssets/fonts/linearicons/style.css">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="assets/RegisterAssets/css/style.css">

    <script src="assets/RegisterAssets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/RegisterAssets/js/main.js"></script>
</head>

<body>

    <div class="wrapper">
        <div class="inner">
            <img src="assets/RegisterAssets/images/image-1.png" alt="" class="image-1">
            <form action="{{url("user/cekregister")}}" method="POST">
                    @csrf
                <h3>New Account?</h3>
                <div class="form-holder">
                    <span class="lnr lnr-user"></span>
                    <input type="text" name="nama_user" class="form-control" placeholder="Username">
                </div>
                {{-- <div class="form-holder">
                    <span class="lnr lnr-phone-handset"></span>
                    <input type="text" class="form-control" placeholder="Phone Number">
                </div> --}}
                <div class="form-holder">
                    <span class="lnr lnr-envelope"></span>
                    <input type="email" name="email" class="form-control" placeholder="Mail">
                </div>
                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input type="password" name="kpassword" class="form-control" placeholder="Confirm Password">
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <button type="submit">Register</button>

                <a href="{{url('/')}}" style="margin-top: 10px; float: right;" class="alreadySignUp">Already Sign Up</a>
            </form>
            <img src="assets/RegisterAssets/images/image-2.png" alt="" class="image-2">
        </div>

    </div>

</body>

</html>