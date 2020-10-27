@extends('template')
@section('isi')

<div class="container mt-5">
    @include('alert')
    <div class="d-flex flex-row ">

        <form action="{{url('barang/addToCart')}}" method="POST">
            @method('POST')
            @csrf
            <div class="mr-5" style="height: 400px;width:400px;">
                <img style="height: 400px;width:400px; object-fit: contain;" src="{{asset("/storage/images/".$barang->gambar_barang)}}" alt="">
            </div>
            <div class="m-3">
                <input type="hidden" name="idBarang" value="{{$barang->id_barang}}">
                <input type="hidden" name="idMerchant" value="{{$barang->id_merchant}}">
                <input type="hidden" name='nama' value="{{$barang->nama_barang}}">
                <input type="hidden" value="{{$barang->harga}}" name='harga'>
                <h3>{{$barang->nama_barang}}</h3>
                <hr>
                    <h4>Rp. {{number_format($barang->harga),2,",","."}}</h4>
                <hr>
                    <h4>Stock : {{$barang->stok}}</h4>
                <hr>
                    Jumlah:<input type="number" name='jumlah'>
                <hr>
                <button class="btn btn-success" type="submit">Add To Cart</button>
                <p>{!!$barang->deskripsi_barang!!}</p>
            </div>
        </form>
    </div>

</div>

@endsection
