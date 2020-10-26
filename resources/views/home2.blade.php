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
      <div class='d-flex justify-content-center  flex-wrap'>
        @foreach ($dataBarang as $item)
            <div class="card m-3" style="width: 18rem;">
            <img style="height: 200px;object-fit: scale-down;"  src="{{asset("/storage/images/".$item->gambar_barang)}}" class="card-img-top" alt="...">
                <div class="card-body">
                <p class="card-text text-truncate">{{$item->nama_barang}}</p>
                <p class="card-text"><b>Rp. {{number_format($item->harga),2,",","."}}</b></p>
                <a href="{{url("/detailBarang/$item->id_barang")}}" class="btn btn-block btn-success">Lihat Barang</a>
                </div>
            </div>
        @endforeach
    </div>
<div class="d-flex justify-content-center">
    {{$dataBarang->links()}}
</div>

</div>

@endsection
