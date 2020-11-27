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
@isset($dataNotifikasi)
    <div class="dropdown show w-25 ml-5 mt-3">
    <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Notifikasi
    </a>
  
    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        @foreach ($dataNotifikasi as $item)
            <a class="dropdown-item" href="{{url('user/markAsRead/'.$item->id_notifikasi)}}">{{ $item->isi }}</a>
        @endforeach
    </div>
  </div>
@endisset
<div class="container mt-5">

    <form class="d-flex mx-auto mb-5 col-6" method="POST" action="{{url('barang/searchBarang')}}">
        @method('POST')
        @csrf
        <input class="form-control mr-2 align-middle" name='searchKeyword' type="search" placeholder="Ketikan Nama Barang Di Sini..." aria-label="Search">
        <button class="btn btn-success" type="submit">Cari</button>
    </form>
    <form action="{{url("barang/filterBarang")}}" method="POST">
        @method('POST')
        @csrf

        <div class="input-group">
            <select class="custom-select rounded-left" id="inputGroupSelect04"  name="selectedKategori">
                @if (isset($dataKategori))
                @foreach ($dataKategori as $item)
                    <option value="{{$item->id_kategori}}">{{$item->nama_kategori}}</option>
                @endforeach
                @else
                    <option value="">Tidak Ada Kategori</option>
                @endif
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-success rounded-left" type="submit">Filter</button>
            </div>
        </div>
    </form>

      <h2 class="text-success">Featured Item</h2>
      <div class='d-flex justify-content-center  flex-wrap'>
        @foreach ($dataBarang as $item)
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
<div class="d-flex justify-content-center">
    {{$dataBarang->links()}}
</div>

</div>

@endsection
