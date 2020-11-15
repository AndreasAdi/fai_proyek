@extends('template')
@section('isi')

<div class="container mt-5  text-success">
    <h1>Wishlist({{$jumlahwishlist}})</h1>
    <div class="d-flex flex-row">

            @foreach ($wishlist as $item)
                <div class="card m-3 shadow" style="width: 18rem;">
                <img style="height: 200px;object-fit: scale-down;"  src="{{asset("/storage/images/".$item['gambar_barang'])}}" class="card-img-top" alt="...">
                    <div class="card-body">
                    <p class="card-text text-truncate">{{$item['nama_barang']}}</p>
                    <p class="card-text"><b>Rp. {{number_format($item['harga']),2,",","."}}</b></p>
                    <a href="{{url("barang/detailBarang/".$item['id_barang'])}}" class="btn btn-block btn-success">Lihat Barang</a>
                    </div>
                </div>
            @endforeach

    </div>
    <form action="{{url('user/checkOut')}}">
        {{-- <button class="btn btn-success" type="submit">Check Out</button> --}}
    </form>
</div>

@endsection
