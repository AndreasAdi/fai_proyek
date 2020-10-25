@extends('template')
@section('judul')
home
@endsection
@section('isi')

<div class="container mt-5">

    <form class="d-flex mx-auto mb-5 col-6">
        <input class="form-control mr-2 align-middle" type="search" placeholder="Cari Barang" aria-label="Search">
        <button class="btn btn-success" type="submit">Cari</button>
      </form>
      <h2>Featured Item</h2>
      <div class='d-flex flex-row'>
        @foreach ($dataBarang as $item)
            <div class="card m-3" style="width: 18rem;">
            <img src="{{asset("/storage/images/".$item->gambar_barang)}}" class="card-img-top" alt="...">
                <div class="card-body">
                <p class="card-text">{{$item->nama_barang}}</p>
                <p class="card-text">Rp. {{number_format($item->harga),2,",","."}}</p>
                <a href="{{url("/detailBarang/$item->id_barang")}}" class="btn btn-block btn-success">Lihat Barang</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
