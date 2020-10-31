@extends('template')
@section('isi')

<div class="container mt-5">
    @include('alert')
    <div class="">

        <form action="{{url('barang/addToCart')}}" method="POST">
            @method('POST')
            @csrf
            <div class="mx-auto" style="height: 400px;width:400px;">
                <img style="height: 400px;width:400px; object-fit: contain;" src="{{asset("/storage/images/".$barang->gambar_barang)}}" alt="">
            </div>
            <div class="m-3">
                <input type="hidden" name="idBarang" value="{{$barang->id_barang}}">
                <input type="hidden" name="idMerchant" value="{{$barang->id_merchant}}">
                <input type="hidden" name='nama' value="{{$barang->nama_barang}}">
                <input type="hidden" value="{{$barang->harga}}" name='harga'>
                <input type="hidden" value="{{$barang->stok}}" name='stok'>
                <h4>{{$barang->nama_barang}}</h4>
                <hr>
                    <h3>Rp. {{number_format($barang->harga),2,",","."}}</h3>
                <hr>
                    <b>Sisa Stock : {{$barang->stok}}</b>
                <hr>

                <div class="input-group mb-3" style = "width : 300px">
                    <input class="form-control col-xs-2" type="number" name='jumlah' placeholder="Jumlah">
                    <button class="btn btn-success" type="submit" id="button-addon2"><i class="fas fa-plus"></i> Add To Cart</button>
                  </div>
                <hr>
                @if (isset($wishlist))
                <a class="btn btn-danger mb-5" href="{{url("barang/RemoveFromWishlist/".$barang->id_barang)}}"> <i class="far fa-heart"></i> Remove From WishLists</a>
                @else
                <a class="btn btn-danger mb-5" href="{{url("barang/addToWishlist/".$barang->id_barang)}}"><i class="far fa-heart"></i> Add to Wishlist</a>
                @endif

                <a class="btn btn-primary mb-5" href="{{url("user/makeChatroom/$barang->id_merchant")}}"><i class="far fa-comment"></i> Chat Merchant</a>
                <a class="btn btn-success mb-5" href="{{url("user/loadtoko/".$barang->id_merchant)}}"><i class="fas fa-store"></i> Lihat Toko</a><br>
                <b class="mt-5">Deskripsi {{$barang->nama_barang}}</b>
                <p>{!!$barang->deskripsi_barang!!}</p>
            </div>
        </form>
    </div>

</div>

@endsection
