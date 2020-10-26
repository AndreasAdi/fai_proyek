@extends('template')
@section('isi')

<div class="container mt-5">

    <div class="d-flex flex-row ">

        <div class="mr-5" style="height: 400px;width:400px;"">
            <img style="height: 400px;width:400px; object-fit: contain;" src="{{asset("/storage/images/".$barang->gambar_barang)}}" alt="">
        </div>


        <div class="m-3">
        <h3>{{$barang->nama_barang}}</h3>
        <hr>
        <h4>Rp. {{number_format($barang->harga),2,",","."}}</h4>
        <hr>
        <h4>Stock : {{$barang->stok}}</h4>
        <hr>
        <button class="btn btn-success">Add To Cart</button>
        <p>{!!$barang->deskripsi_barang!!}</p>

        </div>

    </div>

</div>

@endsection
