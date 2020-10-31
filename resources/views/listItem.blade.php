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
    <h4>Rating <br>{{$dataMerchant->rating_merchant}}
        @for ($i = 0; $i < $dataMerchant->rating_merchant; $i++)
        <i style="color: gold" class="fas fa-star icon"></i>
        @endfor
    </h4>

</div>



</div>

<div class="container shadow rounded mt-3"><h3 class=" pt-3 pl-3">Semua Produk</h3>
    <div class='d-flex justify-content-center  flex-wrap'>

        @foreach ($dataItem as $item)
            <div class="card m-3 shadow" style="width: 18rem;">
            <img style="height: 200px;object-fit: scale-down;"  src="{{asset("/storage/images/".$item->gambar_barang)}}" class="card-img-top" alt="...">
                <div class="card-body">
                <p class="card-text text-truncate">{{$item->nama_barang}}</p>
                <p class="card-text"><b>Rp. {{number_format($item->harga),2,",","."}}</b></p>
                <div class="d-flex inline">
                    <a href="{{url("barang/editBarang/$item[id_barang]")}}" class="btn btn-warning mr-2"><i class="far fa-edit fa-2x"></i> Edit</a>
                    @if (is_null($item['deleted_at']))
                        <form action="{{url("barang/NonAktifBarang/$item[id_barang]")}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button style="height: 58px; width:150px" class='btn btn-danger'>Non-Aktifkan Barang</button>
                        </form>
                    @else
                        <form action="{{url("barang/aktifkanBarang/$item[id_barang]")}}" method="POST">
                            @method('PATCH')
                            @csrf
                            <button style="height: 58px; width:150px" class='btn btn-success'>Aktifkan Barang</button>
                        </form>
                    @endif
                </div>

                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
