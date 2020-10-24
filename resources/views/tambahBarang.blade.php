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
    <form action="{{url('/prosesTambahBarang')}}" method="POST">
        @method('POST')
        @csrf
        Nama Barang: <input type="text" name="namaBarang" id=""> <br>
        Harga: <input type="text" name='hargaBarang'> <br>
        Stok: <input type="text" name='stokBarang'> <br>
        Harga Sale: <input type="text" name='hargaSale'> <br>
        Kategori
        <select name='kategori'>
            <option selected>Select Kategori</option>
            @foreach ($dataKategori as $item)
                <option value="{{$item['id_kategori']}}">{{$item['nama_kategori']}}</option>
            @endforeach
        </select> <br>
        <button type="submit">Tambahkan Barang</button>
    </form>
</body>
</html>
