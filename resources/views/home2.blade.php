@extends('template')
@section('judul')
home
@endsection
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

<div>
    <div class="d-flex flex-row">
        <div id="filter" class="col-2 mr-5 shadow">

            <h1 class="ml-3 mt-3">Filter</h1>
            <form action="{{url("barang/filterBarang")}}" method="POST">
                @method('POST')
                @csrf

                <b class="ml-3">Kategori</b>
                <div class="input-group mb-2 p-3">
                    <select class="form-select" id="inputGroupSelect04" name="selectedKategori">
                        @if (isset($dataKategori))
                        @foreach ($dataKategori as $item)
                        <option value="{{$item->id_kategori}}">{{$item->nama_kategori}}</option>
                        @endforeach
                        @else
                        <option value="">Tidak Ada Kategori</option>
                        @endif
                    </select>

                </div>

                <b class="ml-3">Harga Minimum</b>
                <div class="input-group mb-3 p-3">
                    <span class="input-group-text">Rp</span>
                <input type="number" class="form-control" name="hargamin" min="0" value="{{old('hargamin')}}">
                  </div>

                  <b class="ml-3">Harga Maximum</b>
                  <div class="input-group mb-3 p-3">
                      <span class="input-group-text">Rp</span>
                      <input type="number" class="form-control" name="hargamax" max="999999999" value="{{old('hargamaxs')}}>
                    </div>

                    <div class="p-3">
                        <button class="btn btn-block btn-success">Apply Filter</button>
                        <a href="/" class="btn btn-block btn-danger">Reset Filter</a>
                    </div>

            </form>
        </div>

        <div class="mt-5 flex-grow-1" id="listbarang">

            @isset($dataNotifikasi)
            <div class="dropdown show w-25 ml-5 mt-3">
                <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Notifikasi
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    @foreach ($dataNotifikasi as $item)
                    <a class="dropdown-item"
                        href="{{url('user/markAsRead/'.$item->id_notifikasi)}}">{{ $item->isi }}</a>
                    @endforeach
                </div>
            </div>
            @endisset

            <form class="d-flex mx-auto mb-5 col-6" method="POST" action="{{url('barang/searchBarang')}}">
                @method('POST')
                @csrf
                <input type="hidden" name="status" value="normal">
                <input class="form-control mr-2 align-middle" name='searchKeyword' type="search"
                    placeholder="Ketikan Nama Barang Di Sini..." aria-label="Search">
                <button class="btn btn-success" type="submit">Cari</button>
            </form>


            <h2 class="text-success">Featured Item</h2>
            <div class='d-flex justify-content-center  flex-wrap'>
                @foreach ($dataBarang as $item)
                <div class="card m-3 shadow" style="width: 18rem;">
                    <img style="height: 200px;object-fit: scale-down;"
                        src="{{asset("/storage/images/".$item->gambar_barang)}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text text-truncate">{{$item->nama_barang}}</p>
                        <p class="card-text"><b>Rp. {{number_format($item->harga),2,",","."}}</b></p>
                        <a href="{{url("barang/detailBarang/$item->id_barang/normal")}}"
                            class="btn btn-block btn-success">Lihat Barang</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{$dataBarang->links()}}
            </div>

        </div>

    </div>



</div>

@endsection
