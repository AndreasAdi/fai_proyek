@extends('template')
@section('isi')
@include('alert')
@section('style')

@endsection
<div class="container d-flex justify-content-between shadow rounded mt-5 p-3 bg-success text-light">
<div>
    <h3>{{$dataMerchant->nama_merchant}}</h3>
    <h4><i class="fas fa-map-marked-alt"></i> {{$dataMerchant->alamat_merchant}}</h4>
</div>

<div>
        @if ($dataMerchant->rating_merchant >0)
        <h4>Rating <br>{{$dataMerchant->rating_merchant}}
            @for ($i = 0; $i < $dataMerchant->rating_merchant; $i++)
            <i style="color: gold" class="fas fa-star icon"></i>
            @endfor
        </h4>
        <form action="/user/reviewMerchant/{{$dataMerchant->id_merchant}}">
            <button type="submit" class="btn btn-warning">Lihat Review</button>
        </form>
        
        @else
        <h4>Belum Ada Rating</h4>
        <form action="/user/reviewMerchant/{{$dataMerchant->id_merchant}}">
            <button type="submit" class="btn btn-warning">Lihat Review</button>
        </form>
        @endif

    </h4>

</div>



</div>

<div class="container"><h3 class=" pt-3 pl-3">Semua Produk</h3>
    <div class='d-flex justify-content-center  flex-wrap'>

        @foreach ($dataItem as $item)
            <div class="card m-3 shadow" style="width: 18rem;">
            <img style="height: 200px;object-fit: scale-down;"  src="{{asset("/storage/images/".$item->gambar_barang)}}" class="card-img-top" alt="...">
                <div class="card-body">
                <p class="card-text text-truncate">{{$item->nama_barang}}</p>
                <p class="card-text"><b>Rp. {{number_format($item->harga),2,",","."}}</b></p>
                <a href="{{url("barang/detailBarang/$item->id_barang")}}" class="btn btn-block btn-success">Lihat Barang</a>

                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
