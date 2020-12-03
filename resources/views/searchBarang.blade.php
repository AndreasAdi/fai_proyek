@extends('template')
@section('judul')
home
@endsection
@section('style')
.pagination > li > a,
.pagination > li > span {
    color: green;
}

.pagination > .active > a,
.pagination > .active > a:focus,
.pagination > .active > a:hover,
.pagination > .active > span,
.pagination > .active > span:focus,
.pagination > .active > span:hover {
    background-color: #198754;
    border-color: #198754;
}

.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #198754; //your color
    border-color: #198754; //your color
}
.page-link:hover{
    z-index: 1;
    color: #198754;
    border-color: #198754; //your color
}

@endsection
@section('isi')

<div class="container mt-5">

    <form class="d-flex mx-auto mb-5 col-6" method="POST" action="{{url('barang/searchBarang')}}">
        @method('POST')
        @csrf
        <input type="hidden" name="status" value="normal"/>
        <input class="form-control mr-2 align-middle" type="search" name="searchKeyword" placeholder="Ketikan Nama Barang Di Sini..." aria-label="Search">
        <button class="btn btn-success" type="submit">Cari</button>
      </form>

      <h2>Search Result</h2>
      <div class='d-flex justify-content-center  flex-wrap'>
        @foreach ($dataBarang as $item)
            <div class="card m-3" style="width: 18rem;">
            <img style="height: 200px;object-fit: scale-down;"  src="{{asset("/storage/images/".$item->gambar_barang)}}" class="card-img-top" alt="...">
                <div class="card-body">
                <p class="card-text text-truncate">{{$item->nama_barang}}</p>
                <p class="card-text"><b>Rp. {{number_format($item->harga),2,",","."}}</b></p>
                @if ($status=="normal")
                    <a href="{{url("barang/detailBarang/$item->id_barang/normal")}}" class="btn btn-block btn-success">Lihat Barang</a>
                @else
                    <a href="{{url("barang/detailBarang/$item->id_barang/sale")}}" class="btn btn-block btn-success">Lihat Barang</a>
                @endif

                </div>
            </div>
        @endforeach
    </div>
<div class="d-flex justify-content-center">
    {{$dataBarang->links()}}
</div>

</div>

@endsection
