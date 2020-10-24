<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @include('alert')
    <form action="{{url('/prosesRegisterMerchant')}}" method="POST">
        @method('POST')
        @csrf
        Nama Toko: <input type="text" name="regMerchant_nama" id="">
        Alamat Toko: <input type="text" name="regMerchant_alamat" id="">
        <Button type="submit">Submit</Button>
    </form>
</body>
</html>
