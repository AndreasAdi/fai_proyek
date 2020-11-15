<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
        integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <style>
        @yield('style');

    </style>
    <title>@yield('judul')</title>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-success shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{url('user/home')}}">
                <h3> E-Store</h3>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if (session()->get("isMerchant")==true)
                        {{-- nanti di hide kalau loginnya bukan akun merchant--}}
                    <li class="nav-item dropdown float-right">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                          Menu Merchant
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{url('barang/addItem')}}">Add An Item</a>
                            </li>
                            <li> <a class="dropdown-item" href="{{url('barang/yourItem')}}">Your Item</a></li>
                            <li>
                                <a class="dropdown-item" href="{{url('user/penjualan')}}">Daftar Penjualan</a>
                            </li>

                        </ul>
                      </li>
                      <li>
                        <a class="nav-link" href="{{url('user/pembelian')}}">Daftar Pembelian</a>
                    </li>
                    @else
                    @if (session()->get('isAdmin')==false)
                    <li>
                        <a class="nav-link" href="{{url('user/regisMerchant')}}">Register As A Merchant</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{url('user/pembelian')}}">Daftar Pembelian</a>
                    </li>
                    @endif
                    @endif
                    <li>
                        <a class="nav-link" href="{{url('user/alamat')}}">Alamat</a>
                    </li>
                    <a class="nav-link" href="{{url('user/wishlist')}}">Wishlist</a>
                    @if (session()->get("isAdmin")==true)
                    <li> <a href="{{url('voucher/addVoucher')}}" class="nav-link">Voucher</a></li>
                    <li>
                        <a class="nav-link" href="{{url('sale/addSale')}}">Sale</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{url('admin/listVoucher')}}">Lihat Voucher</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{url('admin/listSale')}}">Lihat Sale</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{url('admin/konfirmasi')}}">Konfirmasi Pembayaran</a>
                    </li>
                    @else

                    <li>
                        <a class="nav-link" href="{{url('user/loadChatroom')}}">Chat Room</a>
                    </li>

                    <li>
                        <a class="nav-link" href="{{url('user/listVoucher')}}">Lihat Voucher</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{url('user/listSale')}}">Lihat Sale</a>
                    </li>
                    

                    <li> <a href="{{url('barang/cart')}}" class="nav-link ml-auto">Cart</a></li>
                    @endif
                </ul>
            </div>

            <div class="form-inline my-2 my-lg-0">

                <a href="{{url('user/prosesLogout')}}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>
    @yield('isi')

    <!-- JavaScript Bundle with Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js"
        integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous">
    </script>

    @yield('script')

</body>

</html>
